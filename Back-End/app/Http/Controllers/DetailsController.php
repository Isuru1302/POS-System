<?php

namespace App\Http\Controllers;

use App\items;
use Illuminate\Http\Request;
use App\details;

class DetailsController extends Controller
{
    public function getDetails(){
        return response()->json(details::find(1));
    }

    public function updateDetails(Request $request){

        $path = "H:\Laravel\POS-Backend\company";
        $url = "H:\Laravel\POS-Backend\company";


        $detail = details::find(1);


        $logoImg = $request->input('logo');

        if($logoImg){

            if(strpos($logoImg,'base64')!==false){
                $newImage = ItemController::convertImage($logoImg,$path);

                $dbImage = $url."\\".$newImage;

                $detail->logo = $dbImage;
            }else{
                $detail->logo =$logoImg;
            }
        }else{
            $detail->logo='';
        }

        $detail->conNo = $request->input('conNo');
        $detail->email = $request->input('email');
        $detail->addLine1 = $request->input('addLine1');
        $detail->addLine2 = $request->input('addLine2');
        $detail->save();
    }
}
