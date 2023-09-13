<?php

use App\Http\Controllers\DealController;
use App\Http\Controllers\FieldCategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldController;
use App\Models\Deal;
use App\Models\Field;
use App\Models\Log;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

//CUSTOM 404 REDIRECT
Route::fallback(function () {
    return view('layouts.notification', ['type' => '404']);
})->name("fallback");

Route::middleware(["verified"])->group(function () {
    $routeNames = Page::all();
    foreach ($routeNames as $route) {

        if (!empty($route->role->role_name)) {
            switch ($route->role->role_name) {
                case 'admin':
                    Route::middleware(["admin"])->group(function () use ($route) {
                        //ADMIN ROUTES
                        Route::prefix('admin')->group(function () use ($route) {
                            Route::get($route->route, function () use ($route) {
                                return view('student.generic_page', ['pageTitle' => $route->title]);
                            });
                        });
                    });
                    break;
                default :
                    Route::get($route->route, function () use ($route) {
                        return view('student.generic_page', ['pageTitle' => $route->title]);
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
        Route::post("/user_fields", [\App\Http\Controllers\FieldController::class, 'getAvailableFields']);

        Route::get('/', function () {
//            $user = Auth::user();
//            if ($user->role->role_name === "admin") {
//                return redirect()->route("admin_home");
//            }
            return view('student.profile');
        })->name("home");

        Route::get("/profile", [UserController::class, "show"])->name("profile");

        //EDIT IMAGE
        Route::match(['post', 'put', 'patch'], '/image/edit', [UserController::class, 'updateImage'])->name("user.image.update");
//        DELETE FILE
        Route::post('/removeFileFromUserInfo', [\App\Http\Controllers\UserController::class, 'removeUserFile']);


        Route::get('/applications', [UserController::class, 'showMyApplications'])->name("applications");
        Route::post('/applications/{deal_id}', [DealController::class, 'deleteDeal']);


        //ADMIN PERMISSIONS
        Route::middleware(["admin"])->group(function () {

            // ROUTES FOR ADMIN FIELD DATA
            Route::post("/add_fields", [FieldController::class, "setFieldCategory"]);


            //ADMIN ROUTES
            Route::prefix('admin')->group(function () {

                Route::get('/', [AdminController::class, "home"])->name("admin_home");
                Route::get("/category_fields", [AdminController::class, "fieldSelect"]);
                // REFRESH ALL FIELDS FROM API
                Route::post("/field/check", [FieldController::class, "updateFields"])->name('updateApiFields');

                //pages routes
                Route::get('/pages', [PageController::class, 'showPages'])->name('showPages');
                Route::get('/pages/{id}/edit', [PageController::class, 'editPages'])->name('edit_pages');
                Route::post('/pages/update', [PageController::class, 'updatePage'])->name('updatePage');
                Route::get('/pages/insert', [PageController::class, 'insertPage'])->name('insertPage');
                Route::post('/pages/create', [PageController::class, 'addNewPage'])->name('createPage');
                Route::post('/pages/remove', [PageController::class, 'deletePage'])->name('deletePage');

                //categories routes
                Route::get('/categories', [FieldCategoryController::class, 'showCategories'])->name('showCategories');
                Route::get('/categories/{id}/edit', [FieldCategoryController::class, 'editCategories'])->name('edit_categories');
                Route::post('/categories/update', [FieldCategoryController::class, 'updateCategories'])->name('updateCategories');
                Route::get('/categories/insert', [FieldCategoryController::class, 'insertCategories'])->name('insertCategories');
                Route::post('/categories/create', [FieldCategoryController::class, 'addNewCategories'])->name('createCategories');
                Route::post('/categories/remove', [FieldCategoryController::class, 'deleteCategories'])->name('deleteCategories');

                //fields routes
                Route::get('/fields', [AdminController::class, "home"])->name('showFields');

                //user routes
                Route::get('/users', [UserController::class, 'showUsers'])->name('showUsers');
                Route::get('/users/{id}/edit', [UserController::class, 'editUsers'])->name('edit_users');

                //action routes
                Route::get('/actions', [\App\Http\Controllers\ActionController::class, 'showActions'])->name('showActions');

                //applications routes
                Route::get('/applications', [\App\Http\Controllers\DealController::class, 'showDeals']);


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

Route::get('/test-page', function () {
    $user = Auth::user();
    $info = Db::table("user_infos")
        ->selectRaw("`field_id`, `value`, `display_value`, `file_name`,`file_path`")
        ->where("user_id", '1')
        ->groupBy("field_id", "value", "display_value", "file_name", 'file_path')
        ->get();


    dd($info);
    #test
});


Route::get("/page_icons", function () {

//    echo asset('resources/css/icons/tabler-icons/tabler-icons.css');
//
//    $cssContent = file_get_contents(asset('resources/css/icons/tabler-icons/tabler-icons.css'));
//
//    var_dump($cssContent);

//    $pattern = '/\.([a-zA-Z0-9_-]+)/'; // Regular expression to match class names
//
//    preg_match_all($pattern, $cssContent, $matches);
//
//    $classNames = $matches[1];
//    $jsonData = json_encode($classNames, JSON_PRETTY_PRINT);
//
//    file_put_contents(asset('resources/js/icons.json'), $jsonData);


    // Path to the resource/js directory
    $jsPath = resource_path('css/icons/tabler-icons');
    //Gets content from json file
    $cssContent = file_get_contents($jsPath . "/tabler-icons.css");
    $pattern = '/\.([a-zA-Z0-9_-]+)/'; // Regular expression to match class names

    preg_match_all($pattern, $cssContent, $matches);

    $classNames = $matches[1];
    $jsonData = json_encode($classNames, JSON_PRETTY_PRINT);


    // Path to the public/js directory
    $jsPath = resource_path('js');

    file_put_contents($jsPath . "/tabler.json", $jsonData);


});

#TEST
Route::get("/search", function () {
    return view("search-test");
});

Route::get("/search-dropdown", [AdminController::class, "search"]);

Route::post("/search-update", [AdminController::class, "setFieldCategory"]);


#TEST
Route::post("/apply", [DealController::class, "apply"])->name('makeDeal');


Route::get("/test", function () {


//    $categories = \App\Models\FieldCategory::whereIn('field_category_id', [1, 2])->get();
//    $fields = Field::where('is_active', '1')->where('field_category_id', '<>', NULL)->orderBy('order', 'asc')->get();
//    $items = [];
//    foreach ($fields as $field) {
//        if ($field->type == "enumeration") {
//            $activeItems = array_filter($field->items->toArray(), function ($el) {
//                return $el['is_active'] == 1;
//            });
//            $field['items'] = $activeItems;
//        }
//    }


//    $res = \CRest::call('crm.dealcategory.stage.list');
////
//    $stages = $res["result"];
//    echo "<pre>";
////        print_r($values);
//    $field = Field::where('field_name', 'STAGE_ID')->first();
//    if ($field) {
//        foreach ($stages as $stage) {
//            \App\Models\FieldItem::create([
//                'item_value' => $stage['NAME'],
//                'item_id' => $stage['ID'],
//                'filed_id' => $field->field_id
//            ]);
//        }
//    }
//
//    echo "</pre>";
//
//    $newArray = array_filter($values,function ($el){
//       return  $el['type'] == 'enumeration';
//    });
//
//    echo "<pre>";
//
//    foreach ($newArray as $key => $value){
//        $fieldId = Field::where("field_name",$key)->pluck('field_id');
//        echo "<h1>" . $key . $fieldId[0] . "</h1>";
//        foreach ($value["items"] as $item){
//            echo "<h1>".$item["ID"]."  ".$item["VALUE"]."</h1>";
//        }
////        print_r($value["items"]);
//    }
//
//    echo "</pre>";

    $user = Auth::user();
    $deals = Deal::where('user_id', $user->user_id)->pluck('user_id', 'bitrix_deal_id')->toArray();



//    UPDATING THE DEALS

//    if (count($deals) > 0) {
//        $fields = User::getAllUserFieldsValue();
//
//        foreach ($deals as $key => $val) {
//            // Make API call to create the deal in Bitrix24
//            $res = CRest::call("crm.deal.update", [
//                'ID' => (string)$key,
//                'FIELDS' => $fields
//            ]);
//        }
//
//    }

});

