<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'field_id',
        'value',
        'display_value',
        'file_name',
        'file_path'
    ];

    protected $primaryKey = 'user_info_id';

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function field(): hasOne
    {
        return $this->hasOne(Field::class, 'field_id');
    }

}
