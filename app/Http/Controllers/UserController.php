<?php

namespace App\Http\Controllers;

use CRest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Kafka0238\Crest\Src;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


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
//        $user = new User();
        $user = Auth::user();



        return view('profile', ['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();

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

//    public function getProfileImagePath($directory,$imageName)
//    {
//        $user = Auth::user();
//
//        if ($user && $user->profile_image === $imageName) {
//            return asset("storage/profile/{$directory}/{$imageName}");
//        }
//
//        abort(403, 'Unauthorized');
//    }

    #CONTINUE WORKING ON UPLOADING PROFILE IMAGE
    public function updateImage(Request $request) {
//        if($request->method() !== "put"){
//            return redirect()->route("home");
//        }

        #INPUTS
        if (!$request->hasFile('profile-image')) {
            return "No file uploaded.";
        }

        $pathOriginal = "public/profile/original";
        $pathThumbnail = "public/profile/thumbnail";
        $pathTiny = "public/profile/tiny";
        $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/png'];
        $maxFileSize = 2048; // 2MB in kilobytes
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

        if ($fileSize > $maxFileSize * 1024) {
            $errors[] = "File size should not exceed 2MB.";
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error;
            }
            return false;
        }

        #QUESTION: DA LI SU OVDE PRISTUPACNE SLIKE? DA LI MOGU DA SE PRIKAZU IZ STORAGEA? MOZDA MORA SOFTLINK...
        #ODGOVOR: MORAO JE SOFTLINK...

        $uniqueString = Str::uuid()->toString();
        $currentDate = now()->format('Y-m-d');
        $newFileName = $currentDate.'_'.$uniqueString.'.'.$fileExtension;

        $moved = Storage::putFileAs($pathOriginal, $file, $newFileName);
        if (!$moved) {
            return "Saving image on the server failed.";
        }

        #MAKE SMALL IMAGES
        try {
            #THUMBNAIL
            $size = 150;
            $thumbnail = Image::make($file)->fit($size, $size, null, "top");
            Storage::put($pathThumbnail.'/'.$newFileName, (string) $thumbnail->encode());

            #TINY
            $size = 35;
            $tinyImage = Image::make($file)->fit($size, $size, null, "top");
            Storage::put($pathTiny.'/'.$newFileName, (string) $tinyImage->encode());
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while storing images.');
        }

        #NAPOMENA: KADA KORISNIK PRISTUPA SLIKAMA, OBAVEZNO PROVERI DA LI NJEGOV ID ODGOVARA ID-JU KORISNIKA IZ BAZE,
        #I TAKO MU DOZVOLI DA VIDI SAMO SVOJE SLIKE!

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
//            report($e);
            return back()->with('error', 'An error occurred while saving images and updating records.');
        }

        #NASTAVI OVDE: UPDATE U BITRIXU



        $user = Auth::user();
        return redirect()->route('profile', ['user' => $user])->with("success", "Profile image updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
