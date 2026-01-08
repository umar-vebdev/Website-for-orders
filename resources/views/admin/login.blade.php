@extends('layouts.front')

@section('title', 'Вход для админа')

@section('content')
<h1 class="text-2xl font-bold text-white mb-4">Вход для администратора</h1>

<div class="max-w-md mx-auto p-6 bg-gray-900 rounded-xl shadow-md mt-6">

    {{-- Ошибки --}}
    @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-600/20 border border-red-600 text-red-300 text-sm">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 text-gray-300">Email</label>
            <input type="email" name="email"
                   class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700"
                   required>
        </div>

        <div>
            <label class="block mb-1 text-gray-300">Пароль</label>
            <input type="password" name="password"
                   class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700"
                   required>
        </div>

        <button type="submit"
                class="w-full py-2 bg-blue-600 hover:bg-blue-500 text-white rounded transition">
            Войти
        </button>
    </form>
</div>
@endsection
