<?php


namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function newUser(Request $request){

        $user = new User();
        $user->name = $request->input('name');
        $user->userName = $request->input('userName');

        $Pw = $request->input('uPw');
        $user->password = Hash::make($Pw);

        $user->save();
        return response()->json(['newUser'=>"success"],201);
    }

    public function updateAdmin(Request $request){
        $admin = User::find(2);
        $admin->name = $request->input('Name');
        $admin->userName = $request->input('UserName');
        $Pw = $request->input('Password');
        $admin->password = Hash::make($Pw);
        $admin->save();
    }

    public function updateSeller(Request $request){
        $admin = User::find(1);
        $admin->name = $request->input('Name');
        $admin->userName = $request->input('UserName');
        $Pw = $request->input('Password');
        $admin->password = Hash::make($Pw);
        $admin->save();
    }


    public function login(Request $request){

        $userName = $request->input('userName');
        $Pw = $request->input('password');

        $user = User::where('userName','=',$userName)->first();

        if($user){

            if (Hash::check($Pw, $user->password))
            {
                return response()->json(['loggedUser'=>$user],201);
            }else{
                return response()->json(['loggedUser'=>"error"],201);
            }
        }else{
            return response()->json(['loggedUser'=>"error"],201);
        }
    }

    public function getAdmin(){
        return response()->json(User::find(2));
    }

    public function getSeller(){
        return response()->json(User::find(1));
    }

}
