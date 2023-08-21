<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'field_id',
        'value',
        'file_name',
        'file_path'
    ];

    protected $primaryKey = 'user_info_id';

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    protected function field(): BelongsTo
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

}
