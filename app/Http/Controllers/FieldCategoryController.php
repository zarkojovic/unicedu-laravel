<?php

namespace App\Http\Controllers;

use App\Models\FieldCategory;
use App\Models\Log;
use App\Models\Page;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FieldCategoryController extends Controller
{
    //
    public function showCategories()
    {
        try {
            // Fetch all field categories from the 'field_categories' table and select 'field_category_id' as 'id'
            $data = FieldCategory::select('*', "field_category_id as id")->get();

            // Get the column listing of the 'field_categories' table
            $columns = DB::getSchemaBuilder()->getColumnListing('field_categories');

            // Return the admin template view with necessary data
            return view("admin.table_data", [
                'pageTitle' => 'Field Categories', // Page title for display
                'data' => $data,                   // Field categories data to be displayed
                'name' => 'Categories',            // Name of the entity being displayed
                'columns' => $columns,             // Column listing for the table
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::errorLog("Error showing categories: " . $e->getMessage());

            // Redirect to the home route with an error message
            return redirect()->route('home')->withErrors(['error' => 'An error occurred while fetching categories.']);
        }
    }

    public function editCategories(string $id)
    {
        try {
            // Find the FieldCategory by its ID and select 'field_category_id' as 'id'
            $categories = FieldCategory::select('*', "field_category_id as id")->findOrFail($id);

            // Return the admin categories edit view with necessary data
            return view('admin.categories.edit', [
                'pageTitle' => 'Edit Category',  // Page title for display
                'data' => $categories,           // Field category data to be displayed
                'name' => 'Categories',          // Name of the entity being edited
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::errorLog("Error editing category: " . $e->getMessage());

            // Redirect to the showCategories route with an error message
            return redirect()->route('showCategories')->withErrors(['error' => 'Category not found.']);
        }
    }

    public function updateCategories(Request $request)
    {
        $data = $request->all();

        try {
            // Validate the incoming data based on defined rules
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|string|unique:field_categories,category_name,' . $request->id . ',field_category_id',
            ]);

            // If validation fails, redirect back with errors and input data
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {

                // Find the FieldCategory to update
                $update = FieldCategory::find($request->id);

                // Store the old category name for later use
                $old_name = $update->category_name;

                // Update the category name
                $update->category_name = $request->category_name;

                if ($update->save()) {
                    // Log the category name change
                    Log::apiLog("Category '" . $old_name . "' changed to :'" . $update->category_name . "'", Auth::user()->user_id);

                    // Redirect to the showCategories route after successful update
                    return redirect()->route('showCategories');
                } else {
                    // Redirect to the showCategories route if save fails
                    return redirect()->route('showCategories');
                }
            }
        } catch (\Exception $e) {
            // Log the error if needed
            Log::errorLog("Error updating category");

            // Handle the error appropriately and redirect to the showCategories route
            return redirect()->route('showCategories')->withErrors(['error' => 'An error occurred while updating the category.']);
        }
    }

    public function insertCategories()
    {
        return view('admin.categories.edit', ['pageTitle' => 'Edit Category', 'name' => 'Categories']);
    }

    public function addNewCategories(Request $request)
    {
        try {
            // Validate the incoming data based on defined rules
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|string|unique:field_categories',
            ]);

            // If validation fails, redirect back with errors and input data
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                // Create a new FieldCategory instance and set its attribute
                $new = new FieldCategory();
                $new->category_name = $request->category_name;

                // If category creation fails, throw an exception
                if (!$new->save()) {
                    throw new \Exception("Category creation failed.");
                }

                // Redirect to the showCategories route after successful creation
                return redirect()->route('showCategories');
            }
        } catch (\Exception $e) {
            // Log the error and handle it appropriately
            Log::errorLog("Error adding new category");

            // Redirect to the showCategories route with an error message
            return redirect()->route('showCategories')->withErrors(['error' => 'An error occurred while adding the category.']);
        }
    }

    public function deleteCategories(Request $request)
    {
        try {
            $id = $request->id;

            // Find the category by its ID
            $category = FieldCategory::findOrFail($id);

            // If category is found
            if ($category) {
                // Log the successful deletion of the category
                Log::apiLog("Category '" . $category->category_name . "' deleted.", Auth::user()->user_id);

                // Delete the category
                $category->delete();
            }

            // Redirect back after successful deletion or if the category was not found
            return redirect()->back();
        } catch (\Exception $e) {
            // Log the error and handle it appropriately
            Log::errorLog("Error deleting category: " . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the category.']);
        }
    }
}
