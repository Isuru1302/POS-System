<?php


namespace App\Http\Controllers;
use App\dealers;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    public function getDealers(){
        return response()->json(dealers::orderBy('id', 'DESC')->get());
    }

    public function addNew(Request $request){
        $dealer = new dealers();
        $dealer->name = $request->input('Name');
        $dealer->tp_num = $request->input('Phone');
        $dealer->email = $request->input('Email');
        $dealer->address = $request->input('Address');
        $dealer->status = 1;

        $dealer->save();
    }

    public function updateDealer(Request $request,$id){
        $dealer = dealers::find($id);
        $dealer->name = $request->input('name');
        $dealer->tp_num = $request->input('tp_num');
        $dealer->email = $request->input('email');
        $dealer->address = $request->input('address');
        $dealer->status = 1;

        $dealer->save();
    }

    public function deleteDealer($id){
        $dealer = dealers::find($id);
        $dealer->delete();
    }

    public function getDealerByID($id){
        return response()->json(dealers::find($id)->first());
    }
}
