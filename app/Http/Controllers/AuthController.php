<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register()
    {
        return view("register");
    }

    public function login()
    {
        return view("login");
    }

    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'email' => 'required|email|unique:users',
        ], [
            'password.regex' => 'Password must contain at least one small letter, one big letter and one number!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $validated = $validator->validated();
            $auth_code = Str::random(30);
            $contact_id = random_int(1000, 2000);
            $new = new User();

            $new->first_name = $request->first_name;
            $new->last_name = $request->last_name;
            $new->email = $request->email;
            $new->password = bcrypt($request->password);
            $new->auth_code = $auth_code;
            $new->phone = $request->phone;
            $new->contact_id = $contact_id;

            if ($new->save()) {
                return view("notification", ["type" => "success_registration"]);
            } else {
                return redirect()->back();
            }

        }
    }

    public function activate(Request $request)
    {
        $code = $request->query("code");
        if ($code != null) {
            $user = User::where('auth_code', $code)->where('email_verified_at', NULL)->first();
            if (!$user) {
                return view("notification", ["activation_failed"]);
            }
            $user->email_verified_at = Carbon::now();

            if ($user->save()) {
                return view("notification", ["type" => 'profile_activated']);
            }
            return view("notification", ["type" => "activation_failed"]);


        } else {
            return view("notification");
        }
    }

    public function auth(Request $request){

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $credentials = $validator->safe(["email","password"]);

            if (Auth::attempt($credentials)) {
                $user = Auth()->user();
                // Check if the verification column is not null (verified)
                if ($user->email_verified_at !== null) {
                    // Authentication successful
                    return redirect()->intended('/');
                } else {
                    // User is not verified
                    Auth::logout();
                    return redirect()->back()->withInput($request->only('email'))->withErrors([
                        'password' => 'Your account is not verified.',
                    ]);
                } // Redirect to the dashboard or the intended URL
            } else {
                // Authentication failed
                return redirect()->back()->withErrors(['password' => 'Invalid credentials'])->withInput();
            }

//            if ($new->save()) {
//                return view("notification", ["type" => "success_registration"]);
//            } else {
//                return redirect()->back();
//            }

        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("login");
    }
}
