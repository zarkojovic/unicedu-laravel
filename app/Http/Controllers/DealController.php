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

    public function apply(Request $request)
    {

        $user = Auth::user();

        if (!$user || !$user->email_verified_at) {
//            return "User not logged in or not verified.";
            Log::errorLog('Unauthenticated or unverified user tried to apply to university.', $user->user_id);
            return redirect()->route("fallback");
        }

        try {
            $title = "University Application From Platform";

            //GET FROM USERS TABLE
            $contactId = $user->contact_id;
            $profileImageName = $user->profile_image;

            //GET FROM UNIVERSITY APPLICATION FORM SUBMIT
            $applicationFields = $request->all();

            if (!$applicationFields) {
                return redirect()->route("home")->with(["errors" => ["You must fill in your information before applying to universities."]]);
            }

            foreach ($applicationFields as $key=>$value) {
                if (!$value){
                    return redirect()->route("home")->with(["errors" => ["You must fill in the required information in your application before applying to universities."]]);
                }
            }

            // Get user info from the 'user_infos' table based on user_id
            #OVO UZME VREDNOSTI IZABRANE ALI ZA DROPDOWNOWE MORA DA IDE VALUE ATRIBUT
//            $userInfoFields = UserInfo::join('fields', 'user_infos.field_id', '=', 'fields.field_id')
//                                    ->where('user_infos.user_id', $user->user_id)
//                                    ->where('fields.field_category_id', '!=', 4)
//                                    ->select('user_infos.field_id', 'user_infos.value');
//                                    ;
//            dd($userInfoFields);

//            $userInfoFields = UserInfo::where('user_id', $user->user_id)->get();
            $userInfoFields = UserInfo::where('user_id', $user->user_id)
                                        ->pluck("value","field_id")
                                        ->toArray(); #ASOCIJATIVNI NIZ
//            dd($userInfoFields);

            //IF NO FIELDS ARE FILLED
            //OVO MOZDA NE TREBA, MOZDA SAMO OBAVEZNA POLJA
//            if ($userInfoFields->isEmpty()) {
////                Log::errorLog('User information not found.', $user->user_id);
//                return redirect()->route("home")->with(["errors" => ["You must fill in information on your profile before applying to universities."]]);
//            }

//            foreach ($userInfoFields as $info) {
//                $fields[] = $info->field_id;
//            }

//            $requiredFields = Field::where("is_required", 1)->pluck("field_id");
//            $requiredFields = Field::where("is_required", 1)->where("field_category_id", "!=", 4)->pluck("field_id")->toArray();
            $requiredFields = Field::where("is_required", 1)
                                    ->where("field_category_id", "!=", 4)
                                    ->pluck("field_id")
                                    ->toArray();
//            dd($requiredFields);

            $missing = array_filter($requiredFields, function ($fieldId) use ($userInfoFields) {
                return empty($userInfoFields[$fieldId]);
//                return empty($userInfoFields->where('field_id', $fieldId)->first()->value); //mozda ! treba
//                return $userInfoFields->where('field_id', $fieldId)->isEmpty();
            });
//            dd($missing);
            if (!empty($missing)){
                Log::errorLog('Required fields not filled in.', $user->user_id);
                return redirect()->route("home")->with(["errors" => ["You must fill in all required fields before applying to universities."]]);
            }

            // Create a deal in Bitrix24 using CRest
//            $fieldNames = Field::select('field_name', 'field_id')
//                               ->whereIn('field_id', $userInfoFields)
//                               ->get();
            $fieldIds = array_keys($userInfoFields);
//            dd($fieldIds);
            $fieldNames = Field::whereIn('field_id', $fieldIds)
                                ->pluck('field_name','field_id')
                                ->toArray();
//            dd($fieldNames);
            $dealFields = [
                'TITLE' => $title,
                'CONTACT_ID' => $contactId,
            ];

            // Populate $dealFields with the field names and values
            foreach ($userInfoFields as $key=>$value) {
//                $fieldId = $info->field_id;
//                $fieldName = $fieldNames[$fieldId];
//                $fieldValue = $info->value;
//
//                $dealFields[$fieldName] = $fieldValue;
                $fieldId = $key;
                $fieldName = $fieldNames[$fieldId];
                $fieldValue = $value;

                $dealFields[$fieldName] = $fieldValue;
            }

            unset($applicationFields['_token']);

//            dd($applicationFields);
            $dealFields = array_merge($dealFields, $applicationFields);

//            dd($dealFields);
            // Make API call to create the deal in Bitrix24
             $result = CRest::call("crm.deal.add", ['FIELDS' => $dealFields]);

            if (isset($result['result']) && $result['result'] > 0) {
                // Deal created successfully
                Log::apiLog('Deal successfully created in Bitrix24.', $user->user_id);

                // Insert a record into the 'deal' table in your database
                $deal = new Deal();
                $deal->bitrix_deal_id = $result['result'];
                $deal->user_id = $user->user_id;
                $deal->date = now();

                foreach ($dealFields as $fieldName => $fieldValue) {
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
                return redirect()->back()->with("success","Your application to university has been successfully created.");
            }

            // Deal creation failed
            Log::errorLog('Failed to create deal in Bitrix24.', $user->user_id);
            return redirect()->back()->with(["errors" => ["Application to university failed. Please try again later."]]);
        }
        catch (\Exception $e) {
            Log::errorLog('Error during application creation: '.$e->getMessage(), $user->user_id);
            return redirect()->back()->with(["errors" => ["Application to university failed. Please try again later."]]);
        }
//        return view('notification', ['type' => 'deal_created']);
    }
}
