<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldController;
use App\Models\Page;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

//CUSTOM 404 REDIRECT
Route::fallback(function () {
    return view('notification', ['type' => '404']);
});

Route::middleware(["verified"])->group(function () {
    $routeNames = Page::all();
    foreach ($routeNames as $route) {

        $role = DB::table('pages')
            ->join('role_page', 'pages.page_id', '=', 'role_page.page_id')
            ->join('roles', 'role_page.role_id', '=', 'roles.role_id')
            ->select('roles.role_id', 'roles.role_name')
            ->where('pages.route', '=', $route->route)
            ->first();

        if(!empty($role->role_name)){
        switch ($role->role_name) {
            case 'admin':
                Route::middleware(["admin"])->group(function () use ($route) {
                    //ADMIN ROUTES
                    Route::prefix('admin')->group(function () use ($route) {
                        Route::get($route->route, function () use ($route) {
                            return view('templates.student', ['pageTitle' => $route->title]);
                        });
                    });
                });
                break;
            default :
                Route::get($route->route, function () use ($route) {
                    return view('templates.student', ['pageTitle' => $route->title]);
                });
                break;
        }
        }
    }

});


//ROUTES FOR AUTHORIZED USERS
Route::middleware(["auth"])->group(function () {
    //REGISTRATION SUCCESS, GO TO EMAIL TO VERIFY
    Route::get('/email/verify', [AuthController::class, 'disallowVerified'])->name('verification.notice');
//    LOGOUT ROUTE
    Route::post("/logout", "\App\Http\Controllers\AuthController@logout")->name("logout");

    //RESEND CONFIRMATION EMAIL
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])->middleware(['throttle:6,1'])->name('verification.send');

    //ROUTES FOR VERIFIED USERS
    Route::middleware(["verified"])->group(function () {
        //ROUTES FOR AJAX RETURN OF DATA
        Route::post("/user_info", [UserController::class, 'getUserInfo']);
        Route::post("/update_user", [UserController::class, 'updateUserInfo']);

        Route::get('/', function () {
//            $user = Auth::user();
//            if ($user->role->role_name === "admin") {
//                return redirect()->route("admin_home");
//            }
            return view('profile');
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
//            ROUTES FOR ADMIN FIELD DATA
            Route::post("/add_fields", [FieldController::class, "setFieldCategory"]);
//                REFRESH ALL FIELDS FROM API
            Route::post("/field/check", [FieldController::class, "updateFields"]);

            //ADMIN ROUTES
            Route::prefix('admin')->group(function () {
                Route::get('/', [AdminController::class, "home"])->name("admin_home");
                Route::get("/category_fields", [AdminController::class, "fieldSelect"]);
                Route::get('/pages', [PageController::class, 'showPages']);
                Route::get('/pages/{id}/edit', [PageController::class, 'editPages'])->name('edit_pages');
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

//TEST ROUTE FOR GETTING CATEGORIES FOR PAGE
Route::post('/page_category', [\App\Http\Controllers\PageController::class, 'pageCategories']);


#TEST
Route::get("/page_icons", function () {

    echo asset('resources/css/icons/tabler-icons/tabler-icons.css');

    $cssContent = file_get_contents(asset('resources/css/icons/tabler-icons/tabler-icons.css'));

    var_dump($cssContent);

//    $pattern = '/\.([a-zA-Z0-9_-]+)/'; // Regular expression to match class names
//
//    preg_match_all($pattern, $cssContent, $matches);
//
//    $classNames = $matches[1];
//    $jsonData = json_encode($classNames, JSON_PRETTY_PRINT);
//
//    file_put_contents(asset('resources/js/icons.json'), $jsonData);


});

#TEST
Route::get("/search", function () {
    return view("search-test");
});

Route::get("/search-dropdown", [AdminController::class, "search"]);

Route::post("/search-update", [AdminController::class, "setFieldCategory"]);

