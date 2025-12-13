@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-md">
    <h1 class="text-2xl font-bold mb-4">Вход для администратора</h1>

    <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1">Пароль</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Войти</button>
    </form>
</div>
@endsection
