<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $primaryKey = 'field_id';
    protected $fillable = [
        'field_name',
        'type',
        'title'
    ];


    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(FieldCategory::class);
    }
}
