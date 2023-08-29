<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Log extends Model
{
    use HasFactory;

    protected $primaryKey = 'log_id';

    protected $fillable = [
        'user_id',
        'action_id',
        'description'
    ];

    protected function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    protected function action(): HasOne
    {
        return $this->HasOne(Action::class, 'action_id');
    }



    public static function errorLog($message, $user_id = null)
    {
        $newLog = new Log();

        $newLog->description = $message;
        $newLog->ip_address = request()->ip();
        if ($user_id != null) {
            $newLog->user_id = $user_id;
        }
        $newLog->action_id = 3;

        $newLog->save();

    }

    public static function informationLog($message, $user_id = null)
    {
        $newLog = new Log();

        $newLog->description = $message;
        $newLog->ip_address = request()->ip();
        if ($user_id != null) {
            $newLog->user_id = $user_id;
        }
        $newLog->action_id = 2;

        $newLog->save();
    }

    public static function authLog($message, $user_id = null)
    {
        $newLog = new Log();

        $newLog->description = $message;
        $newLog->ip_address = request()->ip();
        if ($user_id != null) {
            $newLog->user_id = $user_id;
        }
        $newLog->action_id = 3;

        $newLog->save();
    }

    public static function apiLog($message, $user_id = null)
    {
        $newLog = new Log();

        $newLog->description = $message;
        $newLog->ip_address = request()->ip();
        if ($user_id != null) {
            $newLog->user_id = $user_id;
        }
        $newLog->action_id = 4;

        $newLog->save();
    }

}
