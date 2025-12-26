<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminLog;

class AdminController extends Controller
{
    public function dashboard()
{
    $admins = User::where('is_admin', true)->get();
    $adminLogs = AdminLog::latest()->take(10)->get(['admin_name', 'action']); // последние 10 действий
    return view('admin.dashboard', compact('admins', 'adminLogs'));
}

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Нельзя удалить самого себя.');
        }

        $user->delete();

        AdminLog::create([
            'admin_id' => Auth::id(),
            'admin_name' => Auth::user()->name,
            'action' => 'Удалил админа',
            'description' => "{$user->name} (email: {$user->email})",
        ]);

        return back()->with('success', 'Админ удалён.');
    }

}
