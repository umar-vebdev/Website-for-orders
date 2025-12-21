@extends('layouts.front')

@section('title', 'Вход для админа')

@section('content')
<div class="max-w-md mx-auto p-6 bg-gray-900 rounded-xl shadow-md mt-6">

    <h1 class="text-2xl font-bold text-white mb-4">Вход для администратора</h1>

    <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 text-gray-300">Email</label>
            <input type="email" name="email" 
                   class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   required>
        </div>

        <div>
            <label class="block mb-1 text-gray-300">Пароль</label>
            <input type="password" name="password" 
                   class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   required>
        </div>

        <button type="submit" 
                class="w-full py-2 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 text-white font-semibold rounded shadow-md transition">
            Войти
        </button>
    </form>
</div>
@endsection
