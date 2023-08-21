<?php

use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("/user_fields", "\App\Http\Controllers\FieldController@getAvailableFields");

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

