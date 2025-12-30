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
}

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Нельзя удалить самого себя.');
        }

        $user->delete();

        return back()->with('success', 'Админ удалён.');
    }

}
