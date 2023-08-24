<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FieldController extends Controller
{
    public function getAvailableFields(Request $request)
    {
        $c_vals = $request->input('id');

        $categories = \App\Models\FieldCategory::whereIn('field_category_id',$c_vals)->get();
        $fields = Field::where('is_active', '1')->where('field_category_id', '<>', NULL)->get();

        // Path to the public/js directory
        $jsPath = resource_path('js');
        //Gets content from json file
        $json = file_get_contents($jsPath . "/fields.json");
        //Make it in php array
        $json_fields = json_decode($json, true);

        $data = [$categories, $fields, $json_fields];

        return response()->json($data);
    }

    public function setFieldCategory(Request $request)
    {
        $fields = $request->fields;
        foreach ($fields as $field) {
            $f_id = (int)$field;
            $field_update = Field::find($f_id);
            $field_update->field_category_id = $request->category_id;
            $field_update->save();
        }

        return redirect()->back();
    }

    public function updateFields()
    {

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

    }

}
