<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $primaryKey = 'agency_id';

    protected $fillable = [
        'agency_name',
        'bitrix_agency_id'
    ];


    protected function agents(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(User::class);
    }
}
