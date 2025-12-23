<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\support\Facades\Auth;

class AdminController extends Controller
{
    // Панель администратора
    public function dashboard()
    {
        $admins = User::where('is_admin', true)->get();
        return view('admin.dashboard', compact('admins'));
    }

    // Форма регистрации нового админа
    public function showForm()
    {
        return view('admin.register');
    }

    // Регистрация нового админа
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => true,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Админ добавлен.');
    }

    // Удаление админа
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Нельзя удалить самого себя.');
        }

        $user->delete();
        return back()->with('success', 'Админ удалён.');
    }
}