<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

//    public function sendVerificationEmail($email, $first_name, $auth_code)
//    {
//        $verificationLink = "http://127.0.0.1:8000/activate?code=".$auth_code;
//        Mail::to($email)->send(new VerifyEmail($email, $first_name, $verificationLink));
//
//        return "Email sent successfully!";
//    }

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
            $contact_id = random_int(1000, 2000);
            $new = new User();
            $new->first_name = $request->first_name;
            $new->last_name = $request->last_name;
            $new->email = $request->email;
            $new->password = bcrypt($request->password);
            $new->phone = $request->phone;
            $new->contact_id = $contact_id;

            if ($new->save()) {
                event(new Registered($new));
                Auth::login($new);
                return redirect()->route("verification.notice");
            } else {
                return redirect()->back();
            }

        }
    }

    public function auth(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $credentials = $validator->safe(["email", "password"]);

            if (Auth::attempt($credentials)) {
                $user = Auth()->user();
                // Check if the verification column is not null (verified)
                if ($user->email_verified_at !== null) {
                    // Authentication successful
                    return redirect()->intended('/');
                } else {
                    // User is not verified
                    return redirect()->route('verification.notice');

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

    public function resendVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route("login");
    }


    public function disallowVerified()
    {
        $user = Auth::user();

        //NOTIFICATION ONLY IF LOGGED IN BUT NOT YET VERIFIED
        if ($user->email_verified_at === null) {
            return view('notification', ['type' => 'success_registration']);
        }

        return redirect()->route('home');
    }


    public function successVerification(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return view('notification', ['type' => 'profile_activated']);
    }
}
