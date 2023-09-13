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
use Illuminate\Validation\ValidationException;

class PageController extends Controller
{
    //

    public function pageCategories(Request $request)
    {

        $page = $request->input('name');

        $pagesWithRole = DB::table('pages')
            ->join('field_category_page', 'pages.page_id', '=', 'field_category_page.page_id')
            ->select('field_category_page.field_category_id')
            ->where('pages.route', '=', $page)
            ->get();

        return response()->json($pagesWithRole);
    }

    public function showPages()
    {
        try {
            // Fetch all pages from the 'pages' table and select 'page_id' as 'id'
            $pages = Page::select('*', 'page_id as id')->get();

            // Get the column listing of the 'pages' table
            $columns = DB::getSchemaBuilder()->getColumnListing('pages');

            // Return the admin template view with necessary data
            return view("admin.table_data", [
                'pageTitle' => 'Pages',     // Page title for display
                'data' => $pages,           // Pages data to be displayed
                'columns' => $columns,      // Column listing for the table
                'name' => 'Page',           // Name of the entity being displayed
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::errorLog("Error showing pages: " . $e->getMessage());

            // Redirect to the home route with an error message
            return redirect()->route('home')->withErrors(['error' => 'An error occurred while fetching pages.']);
        }
    }

    public function editPages(string $id)
    {
        try {
            // Find the page by its ID
            $page = Page::findOrFail($id);

            if (!$page->is_editable) {
                throw new \Exception('This page is not editable!');
            }
            // Path to the resource/js directory
            $jsPath = resource_path('js');

            // Read the content of tabler.json file for icons
            $cssContent = file_get_contents($jsPath . "/tabler.json");
            $icons = json_decode($cssContent);

            // Filter icons based on certain criteria
            $icons = array_filter($icons, fn($icon) => str_contains($icon, 'ti') && $icon != 'ti');

            // Fetch all roles and field categories
            $roles = Role::all();
            $categories = FieldCategory::where('category_name', '<>', 'Hidden')->get();

            // Get selected field category IDs for the page
            $selectedCategories = DB::table('field_category_page')->select('field_category_id')
                ->where('page_id', $id)->get();

            // Return the edit view with necessary data
            return view('admin.pages.edit', [
                'pageTitle' => 'Edit Page',                  // Page title for display
                'selectedCategories' => $selectedCategories, // Selected field categories for the page
                'page' => $page,                             // The page being edited
                'name' => 'Page',                            // Name of the entity being displayed
                'icons' => $icons,                           // Filtered icon data
                'roles' => $roles,                           // All available roles
                'categories' => $categories,                 // All available field categories
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::errorLog("Error editing page: " . $e->getMessage());

            // Redirect to the showPages route with an error message
            return redirect()->route('showPages')->withErrors(['error' => 'Page not found.']);
        }
    }

    public function insertPage()
    {
        // Path to the resource/js directory
        $jsPath = resource_path('js');

        // Read the content of tabler.json file for icons
        $cssContent = file_get_contents($jsPath . "/tabler.json");
        $icons = json_decode($cssContent);

        // Filter icons based on certain criteria
        $icons = array_filter($icons, fn($icon) => str_contains($icon, 'ti') && $icon != 'ti');

        // Fetch all roles and field categories
        $roles = Role::all();
        $categories = FieldCategory::all();

        // Return the edit view for inserting a new page with necessary data
        return view('admin.pages.edit', [
            'pageTitle' => 'Insert Page', // Page title for display
            'name' => 'Page',             // Name of the entity being displayed
            'icons' => $icons,            // Filtered icon data
            'roles' => $roles,            // All available roles
            'categories' => $categories,  // All available field categories
        ]);
    }

    public function generateIcons()
    {

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

    }

    public function updatePage(Request $request)
    {
        $data = $request->all();

        try {
            // Validate the incoming data based on defined rules
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|unique:pages,title,' . $request->id . ',page_id',
                'route' => [
                    'required',
                    'string',
                    'unique:pages,route,' . $request->id . ',page_id',
                    'regex:/^\/(?:[a-z0-9_]+\/)*[a-z0-9_]+$/',
                ],
                'icon' => 'required',
            ], [
                'route.regex' => "Route must start with / and can contain characters, numbers, and '_'"
            ]);

            // If validation fails, throw a ValidationException
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Find the page to update
            $update = Page::find($request->id);
            if (!$update) {
                throw new \Exception("Page not found");
            }

            // Update page data
            $update->title = $request->title;
            $update->route = $request->route;
            $update->icon = $request->icon;
            $update->role_id = $request->role_id;

            DB::beginTransaction();

            try {
                // Save the updated page
                $update->save();

                // Delete existing field-category-page relationships for the specified page
                DB::table('field_category_page')->where('page_id', $request->id)->delete();

                // Insert new field-category-page relationships if categories are provided
                if (!empty($request->categories)) {
                    foreach ($request->categories as $category) {
                        DB::table('field_category_page')->insert([
                            'field_category_id' => $category,
                            'page_id' => $update->page_id,
                        ]);
                    }
                }

                DB::commit();

                // Log the update and redirect to showPages route
                Log::apiLog("Page " . $update->title . " updated", Auth::user()->user_id);
                return redirect()->route('showPages');
            } catch (\Exception $e) {
                // Rollback the transaction on exception
                DB::rollback();

                // Log the error and redirect with error message
                Log::errorLog("Error updating page: " . $e->getMessage());
                return redirect()->route('showPages')->withErrors(['error' => 'An error occurred while updating the page.']);
            }
        } catch (ValidationException $e) {
            // Redirect back with validation errors and input data
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function addNewPage(Request $request)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Validate the incoming data based on defined rules
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|unique:pages',
                'route' => [
                    'required',
                    'string',
                    'unique:pages',
                    'regex:/^\/(?:[a-z0-9_]+\/)*[a-z0-9_]+$/',
                ],
                'icon' => 'required',
            ], [
                'route.regex' => "Route must start with / and can contain characters, numbers, and '_'"
            ]);

            // If validation fails, redirect back with errors and input data
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Create a new Page instance and set its attributes
            $newPage = new Page();
            $newPage->title = $request->title;
            $newPage->route = $request->route;
            $newPage->icon = $request->icon;
            $newPage->role_id = $request->role_id;

            // If page creation fails, throw an exception
            if (!$newPage->save()) {
                throw new \Exception("Page creation failed.");
            }

            // Log the successful creation of the new page
            Log::apiLog("New page - " . $newPage->title . " added!");

            // Insert field-category-page relationships if categories are provided
            if ($request->filled('categories')) {
                foreach ($request->categories as $category) {
                    DB::table('field_category_page')->insert([
                        'field_category_id' => $category,
                        'page_id' => $newPage->page_id,
                    ]);
                }
            }

            // Commit the transaction as everything was successful
            DB::commit();

            // Redirect to the showPages route
            return redirect()->route('showPages');
        } catch (\Exception $e) {
            // Rollback the transaction on exception
            DB::rollback();

            // Log the error and handle it appropriately
            Log::errorLog("Error adding new page");

            // Redirect to the showPages route with an error message
            return redirect()->route('showPages')->withErrors(['error' => 'An error occurred while adding the page.']);
        }
    }

    public function deletePage(Request $request)
    {
        try {
            $id = $request->id;

            // Find the page by its ID
            $page = Page::findOrFail($id);

            // If page is found
            if ($page) {
                // Store the title of the page for later use
                $name = $page->title;
                if (!$page->is_editable) {
                    throw new \Exception("You can't delete this page!");
                }
                // Begin a database transaction
                DB::beginTransaction();

                try {
                    // Delete the page
                    $page->delete();

                    // Log the successful deletion of the page
                    Log::apiLog("Page '" . $page->title . "' deleted");

                    // Commit the transaction as everything was successful
                    DB::commit();
                } catch (\Exception $e) {
                    // Rollback the transaction on exception
                    DB::rollback();

                    // Log the error and handle it appropriately
                    Log::errorLog("Error deleting page: " . $e->getMessage());

                    // Redirect to the showPages route with an error message
                    return redirect()->route('showPages')->withErrors(['error' => 'An error occurred while deleting the page.']);
                }
            }

            // Redirect to the showPages route after successful deletion or if the page was not found
            return redirect()->route('showPages');
        } catch (\Exception $e) {
            // Log the error and handle it appropriately
            Log::errorLog("Error finding page: " . $e->getMessage());

            // Redirect to the showPages route with an error message
            return redirect()->route('showPages')->withErrors(['error' => 'Page not found.']);
        }
    }

    public function getIconsByName(Request $request)
    {
        $name = $request->name;

        // Path to the resource/js directory
        $jsPath = resource_path('js');
        //Gets content from json file
        $cssContent = file_get_contents($jsPath . "/tabler.json");

        $icons = json_decode($cssContent);

        $icons = array_filter($icons, function ($icon) {
            return str_contains($icon, 'ti') && $icon != 'ti';
        });

        $icons = array_filter($icons, function ($icon) use ($name) {
            return str_contains($icon, strtolower($name));
        });


        echo(json_encode($icons));

    }


}
