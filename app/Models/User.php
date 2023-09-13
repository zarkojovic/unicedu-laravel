<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'user_id';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $visible = [
        'email', 'first_name', 'last_name', 'user_id'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'profile_image',
        'phone',
        'contact_id',
        'role_id',
        'agent_id',
        'package_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //Relationships

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function info(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(UserInfo::class, 'user_id');
    }

    public function package(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasONe(Package::class);
    }

//    public function getUserById($id) {
//        return $this->find($id);
//    }


    public static function getAllUserFieldsValue()
    {

        $user = Auth::user();

        $pathOriginalImage = "public/profile/original";
        $pathDocuments = "public/profile/documents";

        //GET FROM UNIVERSITY APPLICATION FORM SUBMIT


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
        $applicationFieldsValues = [];


        //MERGE WITH APPLICATION FIELDS
        $dealFields = array_merge($dealFields, $applicationFieldsValues);
//            foreach ($deals as $deal) {
//                // Make API call to create the deal in Bitrix24
//                $result = CRest::call("crm.deal.update", [
//                    'ID' => '7887',
//                    'FIELDS' => [$dealFields]
//                ]);
//            }
        return $dealFields;

    }


}
