<?php

namespace App\Http\Controllers;

use App\Models\FieldCategory;
use App\Models\Page;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FieldCategoryController extends Controller
{
    //
    public function showCategories()
    {
        $data = FieldCategory::select('*', "field_category_id as id")->get();
        $columns = DB::getSchemaBuilder()->getColumnListing('field_categories');

        return view("templates.admin", ['pageTitle' => 'Field Categories', 'data' => $data, 'name' => 'Categories', 'columns' => $columns]);
    }

    public function editCategories(string $id)
    {
        $categories = FieldCategory::select('*', "field_category_id as id")->findOrFail($id);


        return view('admin.categories.edit', ['pageTitle' => 'Edit Category', 'data' => $categories, 'name' => 'Categories']);

    }

    public function updateCategories(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|unique:field_categories,category_name,' . $request->id . ',field_category_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $update = FieldCategory::find($request->id);

            $update->category_name = $request->category_name;

            if ($update->save()) {
                return redirect()->back();
            } else {
                return redirect()->back();
            }

        }

    }

    public function insertCategories()
    {

        return view('admin.categories.edit', ['pageTitle' => 'Edit Category', 'name' => 'Categories']);
    }

    public function addNewCategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|unique:field_categories',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $new = new FieldCategory();

            $new->category_name = $request->category_name;

            if ($new->save()) {
                return redirect()->back();
            } else {
                return redirect()->back();
            }

        }
    }

    public function deleteCategories(Request $request)
    {
        $id = $request->id;

        $category = FieldCategory::findOrFail($id);

        if ($category) {
            $category->delete();
        }

        return redirect()->back();
    }

}
