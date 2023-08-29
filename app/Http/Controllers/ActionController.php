<?php

namespace App\Http\Controllers;

use App\Models\Action;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{
    public function showActions(){

        $data = Action::select('*', "action_id as id")->get();
        $columns = DB::getSchemaBuilder()->getColumnListing('actions');

        return view("templates.admin", ['pageTitle' => 'Log Actions', 'data' => $data, 'name' => 'Actions', 'columns' => $columns]);
    }
}
