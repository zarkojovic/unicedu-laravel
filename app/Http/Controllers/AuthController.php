<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\Log;
use App\Models\User;
use App\Rules\ReCaptcha;
use Closure;
use CRest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

//use Kafka0238\Crest\Src\CRest;
use Mockery\Exception;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;

class AuthController extends Controller
{
    public function register()
    {
        return view("auth.register");
    }

    public function login()
    {
        return view("auth.login");
    }

//    public function check(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'first_name' => 'lN|string|max:20|regex:/^[A-Z][a-z]{3,17}$/',
//            'last_name' => 'required|string|max:20|regex:/^[A-Z][a-z]{3,17}$/',
//            'phone' => 'required|unique:users',
//            'password' => 'required|confirmed|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
//            'email' => 'required|email|unique:users',
//        ], [
//            'first_name.regex' => 'First name start with capital letter first!',
//            'last_name.regex' => 'First name start with capital letter first!',
//            'password.regex' => 'Password must contain at least one small letter, one big letter and one number!',
//        ]);
//
//        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator)->withInput();
//        } else {
//            $validated = $validator->validated();
//            $new = new User();
//            $new->first_name = $request->first_name;
//            $new->last_name = $request->last_name;
//            $new->email = $request->email;
//            $new->password = bcrypt($request->password);
//            $new->phone = $request->phone;
//
//            if ($new->save()) {
//                Log::authLog('User registered!(Not verified)', $new->user_id);
//                event(new Registered($new));
//                Auth::login($new);
//                return redirect()->route("verification.notice");
//            } else {
//                Log::errorLog('Tried to register! Failed attempt!');
//                return redirect()->back();
//            }
//
//        }
//    }
    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed|string|min:8',
            'email' => 'required|email|unique:users',
            'g-recaptcha-response' => ['required', function (string $attribute, mixed $value, Closure $fail) {
                $g_response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $value,
                    'remoteip' => \request()->ip()
                ]);


                if (!$g_response->json('success')) {
                    $fail("The captcha is invalid.");
                }
            }]
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        try {
            DB::beginTransaction();

            $new = new User();
            $new->fill([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
//                'g-recaptcha-response' => ['required', NoCaptcha::rule()],
            ]);

            if ($new->save()) {
                DB::commit();

                Log::authLog('User registered!(Not verified)', $new->user_id);
                event(new Registered($new));
                Auth::login($new);

                return redirect()->route("verification.notice");
            }
            DB::rollback();

            Log::errorLog('Tried to register! Failed attempt!');
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();

            Log::errorLog('Exception during user registration: ' . $e->getMessage());

            return redirect()->back();
        }
    }


    public function auth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email',
            'g-recaptcha-response' => ['required', function (string $attribute, mixed $value, Closure $fail) {
                $g_response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $value,
                    'remoteip' => \request()->ip()
                ]);

                if (!$g_response->json('success')) {
                    $fail("The captcha is invalid.");
                }
            }]
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $credentials = $validator->safe(["email", "password"]);

            if (Auth::attempt($credentials)) {

                $user = Auth()->user();
                // Check if the verification column is not null (verified)
                if ($user->email_verified_at !== null) {

                    Log::authLog('User logged in!', $user->user_id);
                    // Authentication successful
                    return redirect()->intended('/');
                } else {

                    Log::authLog('User logged in! (Not verified yet)', $user->user_id);
                    // User is not verified
                    return redirect()->route('verification.notice');

                } // Redirect to the dashboard or the intended URL
            } else {
                // Authentication failed
                Log::errorLog('Tried to login! Wrong credentials!');
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
        Log::authLog('Verification code resended to user!', $request->user()->user_id);
        return back()->with('message', 'Verification link sent!');
    }


    public function logout()
    {
        Log::authLog('User logged out!', Auth::user()->user_id);
        Auth::logout();
        return redirect()->route("login");
    }


    public function disallowVerified()
    {
        $user = Auth::user();

        //NOTIFICATION ONLY IF LOGGED IN BUT NOT YET VERIFIED
        if ($user->email_verified_at === null) {
            Log::errorLog('Unverified user tried to access home!', $user->user_id);
            return view('layouts.notification', ['type' => 'success_registration']);
        }

        return redirect()->route('home');
    }


    public function successVerification(EmailVerificationRequest $request)
    {
        $request->fulfill();

        $user = Auth::user();

        if (!$user || !$user->email_verified_at) {
            return "user not logged in or not verified";
        }

        try {
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            $email = $user->email;
            $phone = $user->phone;

            //CREATE CONTACT IN BITRIX24
//            $result = CRest::call("crm.contact.add", [
//                'FIELDS' => [
//                    'NAME' => $firstName,
//                    'LAST_NAME' => $lastName,
//                    'PHONE' => [
//                        ['VALUE' => $phone]
//                    ],
//                    'EMAIL' => [
//                        ['VALUE' => $email]
//                    ]
//                ]
//            ]);

            //UPDATE IN DATABASE AFTER WE RECEIVE CONTACT ID
            //if ($result) {
//                $user->update(['contact_id' => $result["result"]]);
            $user->update(['contact_id' => mt_rand(100000, 999999)]);

            //}

            Log::authLog('User verified.', $user->user_id);
        } catch (Exception $e) {
            Log::errorLog('Error during verification. Message: ' . $e->getMessage(), $user->user_id);
        }

        //Log::authLog('User is verified now!', $user->user_id);
        return view('layouts.notification', ['type' => 'profile_activated']);
    }
}
