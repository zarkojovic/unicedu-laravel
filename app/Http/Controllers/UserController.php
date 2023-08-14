<?php

namespace App\Http\Controllers;

use CRest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Kafka0238\Crest\Src;
use Illuminate\Support\Facades\Storage;

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
    public function show(string $id)
    {
        $user = new User();
        $user = $user->getUserById($id);

        return view('profile', ['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = new User();
        $user = $user->getUserById($id);

        return view('user.edit', ['user'=>$user]);
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
        if (empty($firstName) || empty($lastName)){
            $errors[] = "No field can be empty.";
        }

        if (count($errors) == 0) {
            try {
                $data = [
                    'first_name' => $firstName,
                    'last_name' => $lastName
                ];

                DB::transaction(function() use ($id, $data){
                    $user = new User();

                    #UPDATE DATABASE
                    $updatedRows = $user->updateUser($id, $data);

                    if (!$updatedRows){
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
            }
            catch (\Exception $e){
                return "Error: ".$e->getMessage();
            }
        }
        else {
            foreach ($errors as $error) {
                echo $error;
            }

            return false;
        }
    }

    #CONTINUE WORKING ON UPLOADING PROFILE IMAGE
    public function updateImage(Request $request, string $id) {
        #INPUTS
        if (!$request->hasFile('profile-image')) {
            return "No file uploaded.";
        }

//        $pathOriginal = public_path("/images/profile/original");
//        $pathThumbnail = public_path("/images/profile/thumbnail");
        $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/png'];
        $maxFileSize = 2048; // 2MB in kilobytes
        $errors = [];

        $file = $request->file('profile-image');

        $fileName = $file->getClientOriginalName();
        $tmpName = $file->getPathname(); // tmp_name
        $fileSize = $file->getSize();
        $fileType = $file->getClientMimeType();

        #VALIDATE INPUTS
        if (!in_array($fileType, $allowedMimeTypes)) {
            $errors[] = "Allowed file types are jpg, jpeg and png.";
        }

        if ($fileSize > $maxFileSize * 1024) {
            $errors[] = "File size should not exceed 2MB.";
        }

//        if (file_exists($pathOriginal.'/'.$fileName)) {
//            $errors[] = "File with the same name already exists.";
//        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error;
            }
            return false;
        }


        #NASTAVI OVDE: UPLOADUJE SLIKE U TMP FOLDER I PREMESTA IH U STORAGE UMESTO U PUBLIC
//        $uploadedPath = $file->store("images/profile/original", 'public');
        Storage::move($tmpName,"public/profile/original");
        echo "check folder";



        #REDIRECT
//        return redirect()->route('user.show', ['user' => $id])->with("success", "Profile information updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
