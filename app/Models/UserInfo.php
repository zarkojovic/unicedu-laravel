<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInfo extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_info_id';
    protected function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

}
