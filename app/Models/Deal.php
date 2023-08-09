<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Deal extends Model
{
    use HasFactory;

    protected $primaryKey = 'deal_id';

    protected $fillable = [
        'bitrix_deal_id',
        'university',
        'user_id',
        'degree',
        'program',
        'intake',
        'date'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
