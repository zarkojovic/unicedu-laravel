<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

//        dd($page);
        return view('admin.pages.edit', ['pageTitle' => 'Edit Page', 'page' => $page]);
    }

}
