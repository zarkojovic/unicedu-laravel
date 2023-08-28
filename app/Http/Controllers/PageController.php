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
        $pages = Page::all();
        $columns = DB::getSchemaBuilder()->getColumnListing('pages');

//        $columns = Schema::getColumnListing('pages')->get();
        return view("templates.admin", ['pageTitle' => 'Pages', 'pages' => $pages, 'columns' => $columns]);
    }

    public function editPages(string $id)
    {
        $page = Page::findOrFail($id);

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

        return view('admin.pages.edit', ['pageTitle' => 'Edit Page', 'page' => $page, 'icons' => $icons, 'roles' => $roles, 'categories' => $categories]);
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

        return view('admin.pages.edit', ['pageTitle' => 'Insert Page', 'icons' => $icons, 'roles' => $roles, 'categories' => $categories]);
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

        dd($data);
//        return redirect()->route('show');
    }

    public function addNew(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:pages',
            'route' => 'required|string|unique:pages',
            'icon' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $new = new Page();

            $new->title = $request->title;
            $new->route = $request->route;
            $new->icon = $request->icon;


            if ($new->save()) {
                foreach ($request->roles as $role) {
                    DB::table('role_page')->insert([
                        'role_id' => $role,
                        'page_id' => $new->page_id,
                    ]);
                }
                foreach ($request->categories as $category) {
                    DB::table('field_category_page')->insert([
                        'field_category_id' => $category,
                        'page_id' => $new->page_id,
                    ]);
                }

                return redirect()->back();
            } else {
                return redirect()->back();
            }

        }
    }


}
