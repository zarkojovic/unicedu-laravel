<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldCategory extends Model
{
    use HasFactory;
    protected $primaryKey = 'field_category_id';
    protected $fillable = [
        'category_name'
    ];
}
