<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(){
        return view("register");
    }

    public function login(){
        return view("login");
    }
    public function check(Request $request){

        $email = $request->email;
        $password = $request->password;

//        $validator = $request->validate([
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'phone'=>'required',
//            'password'=>'required',
//            'repeat_password'=>'required',
//            'email' => 'required|email',
//        ]);

        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'phone'=>'required|unique:users',
            'password'=>'required|confirmed',
            'repeat_password'=>'required',
            'email' => 'required|email|unique:users',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $validated = $validator->validated();

            return view("login");
        }
//        echo $email." : ". $password;

//        return view("register",["email"=>$email]);
    }
}
