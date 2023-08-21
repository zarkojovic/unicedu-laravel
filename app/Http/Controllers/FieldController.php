<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FieldController extends Controller
{
    public function getAvailableFields()
    {

        $categories = \App\Models\FieldCategory::all();
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
}
