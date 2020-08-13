<?php


namespace App\Http\Controllers;
use App\items;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function newItem(Request $request){
        $item = new items();

        $path = "H:\Laravel\POS-Backend\itemImages";
        $url = "H:\Laravel\POS-Backend\itemImages";

        $item->itemName = $request->input("itemName");
        $item->itemCode = $request->input("itemCode");

        $uploadedImage = $request->input("itemImage");;
        $newImage = $this->convertImage($uploadedImage,$path);

        $dbImage = $url."\\".$newImage;

        $item->itemImage = $dbImage;

        $item->itemPrice = $request->input("itemPrice");
        $item->itemWarranty = $request->input("itemWarranty");
        $item->itemCategory = $request->input("itemCategory");
        $item->itemBarcode = "";
        $item->itemQty = 0;
        $item->itemStatus = 1;
        $item->itemDescription = $request->input("itemDescription");

        $item->save();
        return response()->json(['newItem'=>"added"],201);
    }

    public function updateItem(Request $request,$id){
        $item = items::find($id);

        $path = "H:\Laravel\POS-Backend\itemImages";
        $url = "H:\Laravel\POS-Backend\itemImages";

        $item->itemName = $request->input("itemName");
        $item->itemCode = $request->input("itemCode");

        $uploadedImage = $request->input("itemImage");;


        if($uploadedImage){

            if(strpos($uploadedImage,'base64')!==false){
                $newImage = $this->convertImage($uploadedImage,$path);

                $dbImage = $url."\\".$newImage;

                $item->itemImage = $dbImage;
            }else{
                $item->itemImage =$uploadedImage;
            }
        }else{
            $item->itemImage='';
        }

        $item->itemPrice = $request->input("itemPrice");
        $item->itemWarranty = $request->input("itemWarranty");
        $item->itemCategory = $request->input("itemCategory");
        $item->itemBarcode = "";
        $item->itemQty = 0;
        $item->itemStatus = 1;
        $item->itemDescription = $request->input("itemDescription");

        $item->save();
        return response()->json(['newItem'=>"added"],201);
    }

    public function getItems(){
        $items = items::orderBy('id','desc')->get();
        return response()->json(['items'=>$items],201);
    }

    public function getAvailableItems(){
        $items = items::where('itemStatus','=',1
        )->orderBy("id","desc")->get();
        return response()->json(['items'=>$items],201);
    }

    public function getAvailableItemByID($id){
        $items = items::find($id);

        if($items->itemStatus==1){
            return response()->json(['items'=>$items],201);
        }else{
            return response()->json(['items'=>"No Results"],201);
        }

    }

    public function getItemByID($id){
        $item = items::find($id);
        return response()->json(['item'=>$item],201);
    }

    public function searchItem($searchWord){
        $item = items::Where(function ($query) use ($searchWord) {
                $query->where('itemName', 'like', '%'.$searchWord.'%')
                    ->orWhere('itemCode', 'like','%'.$searchWord.'%');
            })
           ->get();
        return response()->json(['results'=>$item],201);
    }

    public function searchBarcode($barcode){
        $item = items::where('itemBarcode','=',$barcode)->first();
        if($item){
            return response()->json(['barcodeRes'=>$item],201);
        }else{
            return response()->json(['barcodeRes'=>"Not found"],201);
        }
    }

    public function updateQty($id,$value){
        $item = items::find($id);
        $item->itemQty = $value;
        $item->save();
    }

    public function updateStatus($id){
        $item = items::find($id);

        if($item->itemStatus===0){
            $item->itemStatus = 1;
        }else{
            $item->itemStatus = 0;
        }

        $item->save();
    }

    public function checkItemCode($itemCode){
        $item = items::where('itemCode','=',$itemCode)->first();
        if($item){
            return response()->json(['itemFound'=>"yes"],201);
        }else{
            return response()->json(['itemFound'=>"no"],201);
        }
    }

    public static function convertImage($img,$path){
        $fre_img = explode(',',$img);

        $decode = base64_decode($fre_img[1]);
        if(str_contains($fre_img[0],'png')){
            $exte = 'png';
        }elseif (str_contains($fre_img[0],'gif')){
            $exte = 'gif';
        }
        elseif (str_contains($fre_img[0],'jpeg')){
            $exte = 'jpeg';
        }else{
            $exte = 'jpg';
        }

        $rand = substr(md5(microtime()),rand(0,26),5);

        $currentTime = Carbon::now()->timestamp;
        $filename = $currentTime.'.'.$exte;


        $filepath = $path.'/'.$rand.$filename;

        $returnName = $rand.$filename;

        file_put_contents($filepath,$decode);
        return $returnName;
    }

    public function saveBarcode($item_code,$barcode){
        $item = items::where('itemCode','=',$item_code)->first();
        $item->itemBarcode = $barcode;
        $item->save();
    }

    public function deleteItem($id){
        $item = items::find($id);
        $item->delete();
    }

    public function getWarranty($id){
        $item = items::find($id)->first();
        $warranty = $item->itemWarranty;
        return response()->json(['warranty'=>$warranty],201);
    }

    public function reduceStock($id,$value){
        $item = items::find($id)->first();
        $current = $item->itemQty;
        $new = $current-$value;
        $item->itemQty = $new;
        $item->save();
    }
}
