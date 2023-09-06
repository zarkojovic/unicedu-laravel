<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Field extends Model
{
    use HasFactory;

    protected $primaryKey = 'field_id';

    protected $fillable = [
        'field_name',
        'type',
        'title',
        'status',
        'is_active',
        'is_required',
        'field'
    ];


    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(FieldCategory::class, 'field_category_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(FieldItem::class, 'field_id');
    }

}
