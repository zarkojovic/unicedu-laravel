<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        return view("register");
    }

    public function check(Request $request){

        $email = $request->email;
        $password = $request->password;

//        echo $email." : ". $password;

        return view("register",["email"=>$email]);
    }
}
