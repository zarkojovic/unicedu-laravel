<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Deal;
use App\Models\Field;
use App\Models\Log;
use App\Models\UserInfo;
use CRest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\error;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class DealController extends RootController
{
    public function showDeals()
    {
        try {
            // Fetch all deals from the 'deals' table and select 'deal_id' as 'id'
            $data = Deal::select('*', "deal_id as id")->get();

            // Get the column listing of the 'deal' table
            $columns = DB::getSchemaBuilder()->getColumnListing('deals');

            // Return the admin template view with necessary data
            return view("admin.table_data", [
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

    public function apply(Request $request)
    {

        $user = Auth::user();

        if (!$user || !$user->email_verified_at) {
            Log::errorLog('Unauthenticated or unverified user tried to apply to university.', $user->user_id);
            return redirect()->route("fallback");
        }

        $dealCount = Deal::where('user_id',$user->user_id)
                            ->where('active',1)
                            ->count();

        if ($dealCount === 4){//5 deals
            Log::errorLog('Max number of deals already reached.', $user->user_id);
            return redirect()->back()->with(["errors" => ["You have already reached the maximum number applications."]]);
        }

        try {
            $title = "University Application From Platform";
            $contactId = $user->contact_id;
            $pathOriginalImage = "public/profile/original";
            $pathDocuments = "public/profile/documents";

            //GET FROM UNIVERSITY APPLICATION FORM SUBMIT
            $applicationFields = $request->all();

            if (empty($applicationFields)) {
                return redirect()->route("home")->with(["errors" => ["You must fill in your information before applying to universities."]]);
            }

            foreach ($applicationFields as $key => $value) {
                if (!$value) {
                    return redirect()->route("home")->with(["errors" => ["You must fill in the required information in your application before applying to universities."]]);
                }
            }

            $userInfoFields = UserInfo::where('user_id', $user->user_id)
                ->whereNotNull("value")
                ->pluck("value", "field_id")
                ->toArray(); #ASOCIJATIVNI NIZ

            $userInfoFiles = UserInfo::where('user_id', $user->user_id)
                ->whereNull("value")
                ->whereNotNull("file_path")
                ->pluck("file_path", "field_id")
                ->toArray();

            $userInfoFilesNames = UserInfo::where('user_id', $user->user_id)
                ->whereNull("value")
                ->whereNotNull("file_path")
                ->pluck("file_name", "field_id")
                ->toArray();

            $allUserInfoFieldIds = array_merge(array_keys($userInfoFields), array_keys($userInfoFiles));

            //GET REQUIRED FIELDS
            $requiredFields = Field::where("is_required", 1)
                ->where("field_category_id", "!=", 4)
                ->pluck("field_id")
                ->toArray();


            //CHECK REQUIRED FIELDS
            $missing = array_diff($requiredFields, $allUserInfoFieldIds);
            if (!empty($missing)) {
                Log::errorLog('Required fields not filled in.', $user->user_id);
                return redirect()->route("home")->with(["errors" => ["You must fill in all required fields before applying to universities."]]);
            }


            $dealFields = [
                'TITLE' => $title,
                'CONTACT_ID' => $contactId,
            ];

            //EXTRACT FIELD NAMES FOR FIELDS FROM USER_INFO TABLE THAT ARE NOT FILES
            $userInfoFieldIds = array_keys($userInfoFields);
            $fieldNames = Field::whereIn('field_id', $userInfoFieldIds)
                ->pluck('field_name', 'field_id')
                ->toArray();

            // Populate $dealFields with the field names and values
            foreach ($userInfoFields as $fieldId => $fieldValue) {
                $fieldName = $fieldNames[$fieldId] ?? null;

                if ($fieldName) {
                    $dealFields[$fieldName] = $fieldValue;
                }
            }

            //EXTRACT FIELD NAMES FOR FILES
            $userInfoFileIds = array_keys($userInfoFiles);
            $fieldNames = Field::whereIn('field_id', $userInfoFileIds)
                ->pluck('field_name', 'field_id')
                ->toArray();


            //EXTRACT FIELD NAMES FOR FILES, FILE NAMES AND FILE CONTENTS
            foreach ($userInfoFiles as $fieldId => $fieldFilePath) {
                $fieldName = $fieldNames[$fieldId] ?? null;
                $fileName = $userInfoFilesNames[$fieldId] ?? null;

                if ($fieldName) {
                    $path = $fieldName === "UF_CRM_1667336320092" ? $pathOriginalImage : $pathDocuments;
                    $fileContent = Storage::get($path . '/' . $fieldFilePath);

                    $dealFields[$fieldName] = [
                        'fileData' => [
                            $fileName,
                            base64_encode($fileContent)
                        ]
                    ];
                }
            }


            //EXTRACT APPLICATION FIELDS NAMES AND THEIR VALUES (FROM DROPDOWNS) AND THEIR OPTION NAMES
            unset($applicationFields['_token']);
            $applicationFieldsValues = [];
            $applicationFieldsOptions = [];

            foreach ($applicationFields as $key => $value) {
                $array = explode("__", $value);
                if (is_array($array) && count($array) > 1) {
                    $applicationFieldsValues[$key] = $array[0];
                    $applicationFieldsOptions[$key] = $array[1];
                } else {
                    $applicationFieldsOptions[$key] = $value;
                }
            }

            //MERGE WITH APPLICATION FIELDS
            $dealFields = array_merge($dealFields, $applicationFieldsValues);

            // Make API call to create the deal in Bitrix24
            $result = CRest::call("crm.deal.add", ['FIELDS' => $dealFields]);

            //IF DEAL SUCCESSFULLY ADDED IN BITRIX
            if (isset($result['result']) && $result['result'] > 0) {
                Log::apiLog('Deal successfully created in Bitrix24.', $user->user_id);

                // Insert a record into the 'deal' table in your database
                $deal = new Deal();
                $deal->active = true;
                $deal->bitrix_deal_id = $result['result'];
                $deal->user_id = $user->user_id;

                foreach ($applicationFieldsOptions as $fieldName => $fieldValue) {//$dealFields array previously
                    switch ($fieldName) {
                        case 'UF_CRM_1667335624051':
                            $deal->university = $fieldValue;
                            break;
                        case 'UF_CRM_1667335695035':
                            $deal->degree = $fieldValue;
                            break;
                        case 'UF_CRM_1667335742921':
                            $deal->program = $fieldValue;
                            break;
                        case 'UF_CRM_1668001651504':
                            $deal->intake = $fieldValue;
                            break;
                    }
                }

                $deal->save();

                Log::informationLog('Deal inserted into Deals table.', $user->user_id);
                return redirect()->route('applications')->with(["success" => "Your application to university has been successfully created.", "showModal" => "false"]);
//                return redirect()->back()->with(["success" => "Your application to university has been successfully created.", "showModal" => "false"]);
            }

            // Deal creation failed
            Log::errorLog('Failed to create deal in Bitrix24.', $user->user_id);

            return redirect()->route('applications')->with(["errors" => ["Application to university failed. Please try again later."], "showModal" => "false"]);

        } catch (\Exception $e) {
            Log::errorLog('Error during application creation: ' . $e->getMessage(), $user->user_id);
            return redirect()->route('applications')->with(["errors" => ["Application to university failed. Please try again later."], "showModal" => "false"]);

        }
    }

    public function deleteDeal(Request $request)
    {

        $deal_id = $request->deal_id;

        // Get the authenticated user
        $user = Auth::user();

        // Find the deal with the given ID
        $deal = Deal::where('user_id', $user->user_id)
                    ->find($deal_id);



        if (!$deal) {
            Log::errorLog('Tried to remove a deal that doesn\'t exist.', $user->user_id);
            return redirect('/applications')->with('error', 'An error occurred while deleting an application.');
        }
        //OVDE MOZDA TRY CATCH
        // Retrieve the Bitrix deal ID associated with the deal
        $bitrix_deal_id = $deal->bitrix_deal_id;

        // Make an API call to delete the deal in Bitrix24
        $result = CRest::call("crm.deal.delete", ['ID' => (string) $bitrix_deal_id]);

        // Check if the deal was successfully removed from Bitrix24
        if (isset($result['error_description']) && $result['error_description'] === 'Not found') {
            Log::apiLog('Deal failed to delete from Bitrix24.', $user->user_id);
            return redirect('/applications')->with('error', 'An error occurred while deleting an application.');
        }

        // Update the 'active' column to indicate that the deal is inactive (false)
        $deal->active = false;

        if (!$deal->save()) {
            Log::errorLog('Couldn\'t remove the deal from the database.', $user->user_id);
            return redirect()->route('home')->with(['error' => 'An error occurred while deleting an application.']);
        }

        Log::informationLog('Deal set as inactive (active = 0) in the database.', $user->user_id);

        return redirect('/applications')->with('success', 'Application removed successfully.');
    }
}
