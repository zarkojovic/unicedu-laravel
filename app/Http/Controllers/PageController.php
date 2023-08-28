<?php

namespace App\Http\Controllers;

use App\Models\FieldCategory;
use App\Models\Page;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

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
        $pages = Page::select('*', "page_id as id")->get();
        $columns = DB::getSchemaBuilder()->getColumnListing('pages');

//        $columns = Schema::getColumnListing('pages')->get();
        return view("templates.admin", ['pageTitle' => 'Pages', 'data' => $pages, 'columns' => $columns, 'name' => 'Page']);
    }

    public function editPages(string $id)
    {
        $page = Page::select('*', "page_id as id")->findOrFail($id);

        // Path to the resource/js directory
        $jsPath = resource_path('js');
        //Gets content from json file
        $cssContent = file_get_contents($jsPath . "/tabler.json");

        $icons = json_decode($cssContent);

        $icons = array_filter($icons, function ($icon) {
            return str_contains($icon, 'ti') && $icon != 'ti';
        });

        $roles = Role::all();

        $categories = FieldCategory::all();

        $selectedCategories = DB::table('field_category_page')->select('field_category_id')->where('page_id', $id)->get();

        $selectedRoles = DB::table('role_page')->select('role_id')->where('page_id', $id)->get();

        return view('admin.pages.edit', ['pageTitle' => 'Edit Page', 'selectedCategories' => $selectedCategories, 'selectedRoles' => $selectedRoles,
            'page' => $page, 'name' => 'Page', 'icons' => $icons, 'roles' => $roles, 'categories' => $categories]);
    }

    public function insertPage()
    {
        // Path to the resource/js directory
        $jsPath = resource_path('js');
        //Gets content from json file
        $cssContent = file_get_contents($jsPath . "/tabler.json");

        $icons = json_decode($cssContent);

        $icons = array_filter($icons, function ($icon) {
            return str_contains($icon, 'ti') && $icon != 'ti';
        });

        $roles = Role::all();

        $categories = FieldCategory::all();

        return view('admin.pages.edit', ['pageTitle' => 'Insert Page', 'name' => 'Page', 'icons' => $icons, 'roles' => $roles, 'categories' => $categories]);
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

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:pages,title,' . $request->id . ',page_id',
            'route' => 'required|string|unique:pages,route,' . $request->id . ',page_id|regex:/^\/(?:[a-z0-9_]+\/)*[a-z0-9_]+$/',
            'icon' => 'required',
        ], [
            'route.regex' => "Route must start with / and it can have characters, numbers and '_'"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $update = Page::find($request->id);

            $update->title = $request->title;
            $update->route = $request->route;
            $update->icon = $request->icon;


            if ($update->save()) {

                // Delete existing role-page relationships for the specified page
                DB::table('role_page')->where('page_id', $request->id)->delete();

// Delete existing field-category-page relationships for the specified page
                DB::table('field_category_page')->where('page_id', $request->id)->delete();

// Insert new role-page relationships if roles are provided
                if (!empty($request->roles)) {
                    foreach ($request->roles as $role) {
                        DB::table('role_page')->insert([
                            'role_id' => $role,
                            'page_id' => $update->page_id,
                        ]);
                    }
                }

// Insert new field-category-page relationships if categories are provided
                if (!empty($request->categories)) {
                    foreach ($request->categories as $category) {
                        DB::table('field_category_page')->insert([
                            'field_category_id' => $category,
                            'page_id' => $update->page_id,
                        ]);
                    }
                }

// Redirect back after updating relationships
                return redirect()->back();
            } else {
                return redirect()->back();
            }

        }

    }

    public function addNewPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:pages',
            'route' => 'required|string|unique:pages|regex:/^\/(?:[a-z0-9_]+\/)*[a-z0-9_]+$/',
            'icon' => 'required',
        ], [
            'route.regex' => "Route must start with / and it can have characters, numbers and '_'"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $new = new Page();

            $new->title = $request->title;
            $new->route = $request->route;
            $new->icon = $request->icon;


            if ($new->save()) {
                if (!empty($request->roles)) {
                    if (count($request->roles) > 0) {
                        foreach ($request->roles as $role) {
                            DB::table('role_page')->insert([
                                'role_id' => $role,
                                'page_id' => $new->page_id,
                            ]);
                        }
                    }
                }

                if (!empty($request->categories)) {
                    if (count($request->categories) > 0) {
                        foreach ($request->categories as $category) {
                            DB::table('field_category_page')->insert([
                                'field_category_id' => $category,
                                'page_id' => $new->page_id,
                            ]);
                        }
                    }
                }

                return redirect()->back();
            } else {
                return redirect()->back();
            }

        }

    }

    public function deletePage(Request $request)
    {
        $id = $request->id;

        $page = Page::findOrFail($id);

        if ($page) {
            $page->delete();
        }

        return redirect()->back();

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

//        return request()->json($icons);

        echo(json_encode($icons));

    }


}
