<?php

use App\Models\Agency;
use App\Models\Field;
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
    Route::get('/email/verify', function () {
        $user = Auth::user();

        //NOTIFICATION ONLY IF LOGGED IN BUT NOT YET VERIFIED
        if ($user->email_verified_at === null) {
            return view('notification', ['type' => 'success_registration']);
        }

        return redirect()->route('home');
    })->name('verification.notice');

    Route::post("/logout", "\App\Http\Controllers\AuthController@logout")->name("logout");

    //RESEND CONFIRMATION EMAIL
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');

    //    Route::put("/user/{id}/edit",[UserController::class,"edit"]);


    //ROUTES FOR VERIFIED USERS
    Route::middleware(["verified"])->group(function () {
        Route::get('/', function () {

            $user = Auth::user();

            if ($user->role->role_name == "admin") {
                return redirect()->route("admin_home");
            }

            return view('profile');//, ['user' => $user]);
        })->name("home");

        Route::get("/profile",[UserController::class,"show"])->name("profile");

        //EDIT IMAGE
        Route::match(['post','put','patch'], '/image/edit', [UserController::class, 'updateImage'])->name("user.image.update");

        //ADMIN PERMISSIONS
        Route::middleware(["admin"])->group(function () {
            //ADMIN ROUTES
            Route::prefix('admin')->group(function () {
                Route::get('/', function () {
                    $categories = \App\Models\FieldCategory::all();
                    $fields = Field::where('is_active', '1')->where('field_category_id', NULL)->get();
                    return view("admin", ["fields" => $fields, "categories" => $categories]);
                })->name("admin_home");

                Route::get("/category_fields", function () {
                    $categories = \App\Models\FieldCategory::all();
                    $fields = Field::where('is_active', '1')->where('field_category_id', '<>', NULL)->get();
                    return view("category_fields", ["fields" => $fields, "categories" => $categories]);
                });
            });
        });
    });
});

Route::get("/user_info", function () {
    $user = Auth::user();

//        $info = UserInfo::where('user_id',$user->user_id)->groupBy('field_id')->get();

    $info = Db::table("user_infos")
        ->selectRaw("field_id, value")
        ->where("user_id", $user->user_id)
        ->groupBy("field_id", "value")
        ->get();

    foreach ($info as $item) {
        echo $item->value . "<br>";
    }
//        var_dump($info);
});

Route::post("/user_info", function () {
    $user = Auth::user();
    $info = Db::table("user_infos")
        ->selectRaw("field_id, value")
        ->where("user_id", $user->user_id)
        ->groupBy("field_id", "value")
        ->get();

    echo json_encode($info);
});


Route::post("/update_user", function (Request $request) {

    $allData = $request->all();

    $items = $allData['data'];

    $user = Auth::user();
    foreach ($items as $entry) {

        $user_info = UserInfo::where("user_id", (int)$user->user_id)->where("field_id", (int)$entry['field_id'])->first();

        if (!$user_info) {
            UserInfo::create([
                'user_id' => (int)$user->user_id,
                'field_id' => (int)$entry['field_id'],
                'value' => $entry['value']
            ]);
        } else {
            $user_info->value = $entry['value'];
            $user_info->save();
        }

    }
    return "Uspeh!";


});

//    DOCUMENTS
Route::get('/documents', function (){
    return view('documents');
});



//AUTH ROUTE
//Auth::routes(['verify' => true]);

//AFTER CLICK ON VERIFY LINK IN EMAIL
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return view('notification', ['type' => 'profile_activated']);//redirect('/home');
})->middleware(['signed','auth'])->name('verification.verify');



//ROUTES FOR GUESTS
Route::middleware(['guest'])->group(function () {
    Route::get("/register", "\App\Http\Controllers\AuthController@register")->name("register");

    Route::post("/register", "\App\Http\Controllers\AuthController@check");

    Route::get("/login", "\App\Http\Controllers\AuthController@login")->name("login");

    Route::post("/login", "\App\Http\Controllers\AuthController@auth");

//    //REGISTRATION SUCCESS, GO TO EMAIL TO VERIFY
//    Route::get('/email/verify', function () {
//        return view('notification', ['type' => 'success_registration']);
//    })->name('verification.notice');
});




//CONVERT THIS ROUTE IN CONTROLLER
Route::post("/add_fields", function (\Illuminate\Http\Request $request) {

    $fields = $request->fields;
    foreach ($fields as $field) {

        $f_id = (int)$field;

        $field_update = Field::find($f_id);

        $field_update->field_category_id = $request->category_id;

        $field_update->save();
    }

    return redirect()->back();

});

Route::get("/crest", function () {
    $res = CRest::call("crm.deal.fields");
    $arrayOfObjects = [];
    $values = $res["result"];
    $keys = array_keys($res["result"]);
    foreach ($keys as $i => $key) {
        $values[$key]["field_name"] = $key;
        $arrayOfObjects[] = $values[$key];
    }
    echo '<pre>';
    print_r($arrayOfObjects);
    echo '</pre>';
});

Route::get("/get/agencies", function () {
    $filePath = resource_path('js/fields.json'); // Adjust the file path

// Read the JSON file content
    $jsonContent = File::get($filePath);

    $jsonData = json_decode($jsonContent);

    $agencies = array_filter($jsonData, function ($item) {
        // Filter items where the 'age' is greater than or equal to 25
        if (isset($item->formLabel)) {
            return $item->formLabel == 'Agency';
        } else {
            return 0;
        }
    });
    echo "<pre>";
//    print_r($agencies[47]->items[0]);
    $agencies = array_values($agencies);
    $items = $agencies[0]->items;
    foreach ($items as $item) {
        var_dump($item->ID);
//        Agency::create([
//            'bitrix_agency_id'=> $item->ID,
//            'agency_name' => $item->VALUE
//        ]);
    }
    echo "</pre>";
});


Route::get("/make/users", '\App\Http\Controllers\UserController@store');

Route::get("/activate", "\App\Http\Controllers\AuthController@activate");


//CONVERT TO CONTROLLER
Route::get("/field/check", function () {

    // Path to the public/js directory
    $jsPath = resource_path('js');
    //Gets content from json file
    $json = file_get_contents($jsPath . "/fields.json");
    //Make it in php array
    $jsonData = json_decode($json, true);

    echo "<pre>";
    //getting all fields from API
    $fields = \CRest::call('crm.deal.fields');
    //simulating new input
//    $fields['result']['new_field'] = ['type' => 'string', 'field_name' => "new_field", 'formLabel' => 'Novo polje'];
    //get the names of all fileds in response
    $keys = array_keys($fields["result"]);

    echo "<h1>API</h1>";

    //getting all keys from api
    $jsonKeys = array_map(function ($el) {
        return $el['field_name'];
    }, $jsonData);

    //passing through all api keys
    foreach ($keys as $key) {
        $newItem = $fields['result'][$key];
        // checking if the type is dropdown list
        if ($newItem['type'] == 'enumeration') {
            // gets the dropdown item from json, to check it's fields
            $jsonItem = array_filter($jsonData, function ($item) use ($key) {
                return $item['field_name'] == $key;
            });
            // make the index goes from zero
            $jsonItem = array_values($jsonItem);
            // going through items in dropdown menu
            foreach ($newItem['items'] as $item) {
                //geting the id from dropdown item
                $i_id = $item["ID"];
                // getting dropdown items from json array
                $elemItems = $jsonItem[0]['items'];

                // checking if the items exists in json dropdown items
                $checkItem = array_filter($elemItems, function ($el) use ($i_id) {
                    return $el["ID"] == $i_id;
                });
                // if it doesn't exist add to json
                if ($checkItem == null) {
                    // get the index of array element with that field name
                    $id = array_filter($jsonData, function ($el) use ($key) {
                        return $el['field_name'] == $key;
                    });
//                    get id and convert to int
                    $id = array_keys($id);

                    $id = (int)$id[0];

                    // add it to existing json file
                    $jsonData[$id]['items'][] = $item;

                }
            }
        }
        //checking if key from json is in array
        if (!in_array($key, $jsonKeys)) {
//            var_dump($fields['result'][$key]);

            //if not then add it to php array which goes to json
            $jsonData[] = $newItem;
//            adding it to the table in database
            if (isset($newItem['formLabel'])) {
                Field::create([
                    'field_name' => $newItem['field_name'],
                    'type' => $newItem['type'],
                    'title' => $newItem['formLabel']
                ]);
            } else {
                Field::create([
                    'field_name' => $newItem['field_name'],
                    'type' => $newItem['type']
                ]);
            }
        }
    }

    //check if json has some element that is not in api anymore
    foreach ($jsonKeys as $jsonKey) {
        if (!in_array($jsonKey, $keys)) {

            $field = Field::where('field_name', $jsonKey)->first();
            $field->is_active = 0;
            $field->status = 0;
            $field->save();

        }
    }


    // updating the json file back
    $json = json_encode($jsonData, JSON_PRETTY_PRINT);

    // Path to the public/js directory
    $jsPath = resource_path('js');

    file_put_contents($jsPath . "/fields.json", $json);
});
