<?php


namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($description, $action = null, $module = null)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id'    => Auth::id(),
                'description'=> $description,
                'action'     => $action,
                'module'     => $module,
            ]);
        }
    }
}
