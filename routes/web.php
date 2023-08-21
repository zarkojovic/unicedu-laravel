<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldController;
use App\Models\Agency;
use App\Models\Field;
use App\Models\FieldCategory;
use App\Models\UserInfo;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Kafka0238\Crest\Src;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//CUSTOM 404 REDIRECT
Route::fallback(function () {
    return view('notification', ['type' => '404']);
});

//ROUTES FOR AUTHORIZED USERS
Route::middleware(["auth"])->group(function () {
    //REGISTRATION SUCCESS, GO TO EMAIL TO VERIFY
    Route::get('/email/verify', [AuthController::class, 'disallowVerified'])->name('verification.notice');

    Route::post("/logout", "\App\Http\Controllers\AuthController@logout")->name("logout");

    //RESEND CONFIRMATION EMAIL
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])->middleware(['throttle:6,1'])->name('verification.send');

    //ROUTES FOR VERIFIED USERS
    Route::middleware(["verified"])->group(function () {

        Route::post("/user_info", [UserController::class, 'getUserInfo']);
        Route::post("/update_user", [UserController::class, 'updateUserInfo']);

        Route::get('/', function () {
            $user = Auth::user();
            if ($user->role->role_name == "admin") {
                return redirect()->route("admin_home");
            }
            return view('profile');//, ['user' => $user]);
        })->name("home");

        Route::get("/profile", [UserController::class, "show"])->name("profile");

        //EDIT IMAGE
        Route::match(['post', 'put', 'patch'], '/image/edit', [UserController::class, 'updateImage'])->name("user.image.update");

        // DOCUMENTS
        Route::get('/documents', function () {
            return view('documents');
        });

        //ADMIN PERMISSIONS
        Route::middleware(["admin"])->group(function () {

            Route::post("/add_fields", [FieldController::class, "setFieldCategory"]);

            Route::post("/field/check", [FieldController::class, "updateFields"]);


            //ADMIN ROUTES
            Route::prefix('admin')->group(function () {
                Route::get('/', [AdminController::class, "home"])->name("admin_home");
                Route::get("/category_fields", [AdminController::class, "fieldSelect"]);
            });
        });
    });
});

//AFTER CLICK ON VERIFY LINK IN EMAIL
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'successVerification'])->middleware(['signed', 'auth'])->name('verification.verify');


//ROUTES FOR GUESTS
Route::middleware(['guest'])->group(function () {
    Route::get("/register", "\App\Http\Controllers\AuthController@register")->name("register");

    Route::post("/register", "\App\Http\Controllers\AuthController@check");

    Route::get("/login", "\App\Http\Controllers\AuthController@login")->name("login");

    Route::post("/login", "\App\Http\Controllers\AuthController@auth");

});


