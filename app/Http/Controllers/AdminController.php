<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldCategory;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home()
    {
        $categories = FieldCategory::all();
        $fields = Field::where('is_active', '1')->where('field_category_id', NULL)->get();
        return view("admin", ["fields" => $fields, "categories" => $categories]);
    }

    public function fieldSelect()
    {
        $categories = FieldCategory::all();
        $fields = Field::where('is_active', '1')->where('field_category_id', '<>', NULL)->get();
        return view("category_fields", ["fields" => $fields, "categories" => $categories]);
    }
}
