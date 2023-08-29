<?php

namespace App\Http\Controllers;

use App\Models\FieldCategory;
use App\Models\Log;
use App\Models\Page;
use App\Models\UserInfo;
use CRest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Kafka0238\Crest\Src;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Mockery\Exception;

class UserController extends RootController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();

        if ($user->role->role_name === "admin") {
            return redirect()->route("admin_home");
        }
        return view('profile');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        #POTENTIAL PROBLEM 1: WHEN USER UPDATES ONLY SOME OF THE FIELDS, NOT ALL OF THEM
        #POTENTIAL SOLUTION: THROUGH AJAX SEND AN ARRAY OF DATA IN THE RIGHT FORMAT AND MAKE A FUNCTION THAT ACCEPTS IT
        #AND SENDS THAT ARRAY TO THE TRANSACTION

        #POTENTIAL PROBLEM 2: MAYBE IT WON'T WORK WHEN THE USER TRIES TO EDIT SOME INFORMATION FOR THE FIRST TIME,
        #LIKE WHEN INPUTTING INFORMATION FOR THE FIRST TIME, HE MAY BE REQUIRED TO FILL IN ALL INFORMATION AT ONCE

        #INPUTS
        $firstName = $request->input('first-name');
        $lastName = $request->input('last-name');

        $errors = [];

        #VALIDATE INPUTS
        if (empty($firstName) || empty($lastName)) {
            $errors[] = "No field can be empty.";
        }

        if (count($errors) == 0) {
            try {
                $data = [
                    'first_name' => $firstName,
                    'last_name' => $lastName
                ];

                DB::transaction(function () use ($id, $data) {
                    $user = new User();

                    #UPDATE DATABASE
                    $updatedRows = $user->updateUser($id, $data);

                    if (!$updatedRows) {
                        throw new \Exception('Updating information failed.');
                    }

                    #IF UPDATED IN DATABASE, CALL CREST METHOD
//                    CRest::call("crm.contact.update", [
//                        'ID' => '3025',//contact for test deal
//                        'FIELDS' => [
//                            'NAME' => $data["first_name"],
//                            'LAST_NAME' => $data["last_name"]
//                        ]
//                    ]);
                });

                return redirect()->route('show', ['user' => $id])->with("success", "Profile information updated successfully.");
            } catch (\Exception $e) {
                return "Error: " . $e->getMessage();
            }
        } else {
            foreach ($errors as $error) {
                echo $error;
            }

            return false;
        }
    }


    public function updateUserInfo(Request $request)
    {
//        GET ALL OF THE DATA FROM REQUEST
        $items = $request->all();
//        GET AUTH-ED USER FOR UPDATING HIS DATA
        $user = Auth::user();


//        LOOPING THROUGH EACH ELEMENT IN REQUEST
        foreach ($items as $key => $value) {
            try {
                DB::beginTransaction();
//            GETTING THE FIELD_ID BASE ON FIELD_NAME FROM REQUEST
                $field_id = DB::table('fields')->select('field_id')->where('field_name', $key)->first();
//            CHECKING IF THE INFO ALREADY EXISTS IN TABLE
                $user_info = UserInfo::where("user_id", (int)$user->user_id)->where("field_id", (int)$field_id->field_id)->first();
//            CHECKING IF THE REQUEST IS FILE
                if ($request->hasFile($key)) {
//                GETTING THE INFO FROM FILE
                    $storeFile = $request->file($key);
                    $fileName = $storeFile->getClientOriginalName();
                    // Store the uploaded file
                    $storedPath = $storeFile->store('profile/documents', 'public');
//                GETTING THE NEW NAME OF FILE
                    $fileNewName = basename($storedPath);
                }
                //IF INFO DOESNT EXIST

                if (!$user_info) {
//                IF IT IS A FILE
                    if ($request->hasFile($key)) {
                        UserInfo::create([
                            'user_id' => (int)$user->user_id,
                            'field_id' => (int)$field_id->field_id,
                            'file_name' => $fileName,
                            'file_path' => $fileNewName
                        ]);
                    } else {
//                    IF IT'S NOT FILE
                        UserInfo::create([
                            'user_id' => (int)$user->user_id,
                            'field_id' => (int)$field_id->field_id,
                            'value' => $value,
                        ]);
                    }
                } else {
//                IF ITS AN UPDATING
                    if ($request->hasFile($key)) {
                        #REMOVE OLD IMAGE FROM FOLDERS
                        $oldProfileImage = $user_info->file_path;
                        Storage::delete([
                            "public/profile/documents/$oldProfileImage"
                        ]);
//                    UPDATE INFO
                        $user_info->file_name = $fileName;
                        $user_info->file_path = $fileNewName;
                        $user_info->save();
                    } else {
//                    UPDATE INFO FOR NO FILE
                        $user_info->value = $value;
                        $user_info->save();
                    }
                }
                DB::commit();
            } catch (\Exception $ex) {
                http_response_code(401);
                return "Error occurred while updating information!";
            }

        }
    }

    public
    function getUserInfo()
    {
        $user = Auth::user();
        $info = Db::table("user_infos")
            ->selectRaw("`field_id`, `value`, `file_name`,`file_path`")
            ->where("user_id", $user->user_id)
            ->groupBy("field_id", "value", "file_name", 'file_path')
            ->get();

        echo json_encode($info);
    }

    public
    function updateImage(Request $request)
    {
        #INPUTS
        if (!$request->hasFile('profile-image')) {
            return "No file uploaded.";
        }

        $pathOriginal = "public/profile/original";
        $pathThumbnail = "public/profile/thumbnail";
        $pathTiny = "public/profile/tiny";
        $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/png'];
        $numberOfMegabytes = 8;
        $kilobyte = 1024; // 2MB in kilobytes
        $errors = [];

        $file = $request->file('profile-image');

        $fileName = $file->getClientOriginalName();
        $tmpName = $file->getPathname(); // tmp_name
        $fileSize = $file->getSize();
        $fileType = $file->getClientMimeType();
        $fileExtension = $file->getClientOriginalExtension();

        #VALIDATE INPUTS
        if (!in_array($fileType, $allowedMimeTypes)) {
            $errors[] = "Allowed file types are jpg, jpeg and png.";
        }

        if ($fileSize > $numberOfMegabytes * pow($kilobyte, 2)) {
            $errors[] = "File size should not exceed 8MB.";
        }

        if (!empty($errors)) {
            return redirect()->route('profile')->with(["errors" => $errors]);
        }

        #QUESTION: DA LI SU OVDE PRISTUPACNE SLIKE? DA LI MOGU DA SE PRIKAZU IZ STORAGEA? MOZDA MORA SOFTLINK...
        #ODGOVOR: MORAO JE SOFTLINK...

        $uniqueString = Str::uuid()->toString();
        $currentDate = now()->format('Y-m-d');
        $newFileName = $currentDate . '_' . $uniqueString . '.' . $fileExtension;

        $moved = Storage::putFileAs($pathOriginal, $file, $newFileName);
        if (!$moved) {
            return redirect()->route('profile')->with(["errors" => ['Saving image on the server failed.']]);
//            return "Error: Saving image on the server failed.";
        }

        #MAKE SMALL IMAGES
        try {
            #THUMBNAIL
            $size = 150;
            $thumbnail = Image::make($file)->fit($size, $size, null, "top");
            Storage::put($pathThumbnail . '/' . $newFileName, (string)$thumbnail->encode());

            #TINY
            $size = 35;
            $tinyImage = Image::make($file)->fit($size, $size, null, "top");
            Storage::put($pathTiny . '/' . $newFileName, (string)$tinyImage->encode());
        } catch (\Exception $e) {
            report($e);

            return redirect()->route('profile')->with(["errors" => ['An error occurred while saving images and updating records.']]);
//            return back()->with('error', 'An error occurred while saving images and updating records.');
        }

        #INSERT INTO DATABASE
        try {
            DB::beginTransaction();

            $user = Auth::user();

            #REMOVE OLD IMAGE FROM FOLDERS
            $oldProfileImage = $user->profile_image;
            Storage::delete([
                "{$pathOriginal}/{$oldProfileImage}",
                "{$pathThumbnail}/{$oldProfileImage}",
                "{$pathTiny}/{$oldProfileImage}",
            ]);

            $user->profile_image = $newFileName;
            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            report($e);
            return redirect()->route('profile')->with(["errors" => ['An error occurred while updating.']]);
//            return back()->with('error', 'An error occurred while updating.');
        }

        #UF_CRM_1667336320092 - polje za sliku
        #6533 - DEAL ID

        #IF UPDATED IN DATABASE, UPDATE IN BITRIX24
//        try {
//            $imageContent = Storage::get($pathOriginal.'/'.$newFileName);
//
//            CRest::call("crm.deal.update", [
//                'id' => '6533',//test deal
//                'fields' => [
//                    'UF_CRM_1667336320092' => [
//                        'fileData' => [
//                            $newFileName,
//                            base64_encode($imageContent)
//                        ]
//                    ]
//                ]
//            ]);
//        } catch (\Exception $e) {
//            return "Error: " . $e->getMessage();
//        }


        $user = Auth::user();
        return redirect()->route('profile')->with("success", "Profile image updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(string $id)
    {
        //
    }

    public function showUsers()
    {
        $users = User::select('first_name', 'last_name', 'email', 'phone', 'email_verified_at', 'profile_image', 'contact_id', 'created_at', 'updated_at', 'user_id as id')->get();
        $columns = DB::getSchemaBuilder()->getColumnListing('users');
        $columns = ['id', 'profile_image', 'first_name', 'last_name', 'email', 'phone', 'email_verified_at', 'contact_id', 'created_at', 'updated_at'];
        return view("templates.admin", ['pageTitle' => 'User', 'data' => $users, 'columns' => $columns, 'name' => 'Users']);
    }

    public function editUsers(string $id)
    {
        $users = User::select('first_name', 'last_name', 'email_verified_at', 'profile_image', 'contact_id', 'created_at', 'phone', 'updated_at', "user_id as id")
            ->findOrFail($id);
        $history = Log::where('user_id', $id)->get();
        return view('admin.users.edit', ['pageTitle' => 'User Info', 'history' => $history, 'data' => $users, 'name' => 'Users']);
    }
}
