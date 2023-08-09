<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Log extends Model
{
    use HasFactory;
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'user_id',
        'action'
    ];

    protected function user(): HasOne {
        return $this->hasOne(User::class);
    }
}
