<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Deal;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealController extends Controller
{
    public function showDeals()
    {
        try {
            // Fetch all deals from the 'deals' table and select 'deal_id' as 'id'
            $data = Deal::select('*', "deal_id as id")->get();

            // Get the column listing of the 'deal' table
            $columns = DB::getSchemaBuilder()->getColumnListing('deals');

            // Return the admin template view with necessary data
            return view("templates.admin", [
                'pageTitle' => 'Deals',  // Page title for display
                'data' => $data,               // Actions data to be displayed
                'name' => 'Deals',           // Name of the entity being displayed
                'columns' => $columns,         // Column listing for the table
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::errorLog("Error showing deals: " . $e->getMessage());

            // Redirect to the home route with an error message
            return redirect()->route('home')->withErrors(['error' => 'An error occurred while fetching actions.']);
        }

    }
}
