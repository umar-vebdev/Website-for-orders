<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(Auth::attempt(array_merge($credentials, ['is_admin' => 1]))) {
            return redirect()->route('admin.dashboard');
        } else {
            return back()->withErrors([
                'email' => 'Неверные данные для входа или вы не админ.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('menu');
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
                'password' => 'required|string|min:6',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'is_admin' => 1,
            ]);
            
            Auth::login($user);
            
            return redirect()->route('admin.dashboard')->with('success', 'Админ добавлен.');
            
        }

        public function showLogin()
{
    session(['init' => true]);

    return view('admin.login');
}

}