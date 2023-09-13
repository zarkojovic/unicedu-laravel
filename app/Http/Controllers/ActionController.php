<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{
    //GET ALL INFORMATION FROM ACTION TABLE
    public function showActions()
    {
        try {
            // Fetch all actions from the 'actions' table and select 'action_id' as 'id'
            $data = Action::select('*', "action_id as id")->get();

            // Get the column listing of the 'actions' table
            $columns = DB::getSchemaBuilder()->getColumnListing('actions');

            // Return the admin template view with necessary data
            return view("admin.table_data", [
                'pageTitle' => 'Log Actions',  // Page title for display
                'data' => $data,               // Actions data to be displayed
                'name' => 'Actions',           // Name of the entity being displayed
                'columns' => $columns,         // Column listing for the table
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::errorLog("Error showing actions: " . $e->getMessage());

            // Redirect to the home route with an error message
            return redirect()->route('home')->withErrors(['error' => 'An error occurred while fetching actions.']);
        }
    }
}
