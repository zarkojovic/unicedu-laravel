<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'field_item_id';

    protected $fillable = [
        'item_value',
        'item_id',
        'field_id',
        'is_active'
    ];
}
