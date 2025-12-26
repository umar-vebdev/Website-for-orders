<?php

namespace App\Services;

use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;

class AdminLogService
{
    /**
     * Логирование действия администратора
     *
     * @param string $action
     * @param string| $description 
     */
    public static function log(string $action, string $description)
    {
        $admin = Auth::user();

        AdminLog::create([
            'admin_id'   => $admin?->id,
            'admin_name' => $admin?->name,
            'action'     => $action,
            'description'=> $description,
        ]);
    }
}
