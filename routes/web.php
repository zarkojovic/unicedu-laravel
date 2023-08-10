<?php

use App\Models\Agency;
use App\Models\Field;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Kafka0238\Crest\Src;
use Illuminate\Support\Facades\File;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/user_role', function () {
    $user = User::find(1);

    var_dump($user->role->role_name);
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
    $items = $agencies[47]->items;
    foreach ($items as $item) {
        var_dump($item->ID);
//        Agency::create([
//            'bitrix_agency_id'=> $item->ID,
//            'agency_name' => $item->VALUE
//        ]);
    }
    echo "</pre>";
});

//Route::get('/user/{id}', '\App\Http\Controllers\UserController@index');

Route::get("/make/users", '\App\Http\Controllers\UserController@store');

Route::get("/register","\App\Http\Controllers\AuthController@index");

Route::post("/register","\App\Http\Controllers\AuthController@check");

Route::get("/user/profile",function (){
   return view("profile");
});

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
        if($newItem['type'] == 'enumeration'){
            // gets the dropdown item from json, to check it's fields
            $jsonItem = array_filter($jsonData,function ($item) use ($key){
               return $item['field_name'] == $key;
            });
            // make the index goes from zero
            $jsonItem = array_values($jsonItem);
            // going through items in dropdown menu
            foreach ($newItem['items'] as $item){
                //geting the id from dropdown item
                $i_id = $item["ID"];
                // getting dropdown items from json array
                $elemItems = $jsonItem[0]['items'];

                // checking if the items exists in json dropdown items
                $checkItem = array_filter($elemItems,function ($el) use ($i_id){
                    return $el["ID"] == $i_id;
                });
                // if it doesn't exist add to json
                if($checkItem == null){
                    // get the index of array element with that field name
                    $id = array_filter($jsonData,function ($el) use ($key){
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
    foreach ($jsonKeys as $jsonKey){
        if(!in_array($jsonKey,$keys)){

            $field = Field::where('field_name',$jsonKey)->first();
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
