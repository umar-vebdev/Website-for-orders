@extends('layouts.admin')

@section('title', 'Панель админа')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Управление блюдами --}}
    <a href="{{ route('admin.dishes') }}" class="flex items-center gap-4 p-6 border border-blue-500 rounded-xl shadow hover:scale-105 transition transform text-blue-400 hover:text-white">
        <i class="fas fa-utensils fa-2x"></i>
        <div class="font-semibold text-lg">Управление блюдами</div>
    </a>

    {{-- Управление заказами --}}
    <a href="{{ route('admin.orders') }}" class="flex items-center gap-4 p-6 border border-green-500 rounded-xl shadow hover:scale-105 transition transform text-green-400 hover:text-white">
        <i class="fas fa-receipt fa-2x"></i>
        <div class="font-semibold text-lg">Управление заказами</div>
    </a>

    {{-- Добавить администратора --}}
    <a href="{{ route('admin.register') }}" class="flex items-center gap-4 p-6 border border-purple-500 rounded-xl shadow hover:scale-105 transition transform text-purple-400 hover:text-white">
        <i class="fas fa-user-plus fa-2x"></i>
        <div class="font-semibold text-lg">Добавить администратора</div>
    </a>

    {{-- Выход --}}
    <form action="{{ route('admin.logout') }}" method="POST" class="col-span-full">
        @csrf
        <button type="submit" class="w-full p-4 border border-red-500 rounded-xl shadow hover:scale-105 transition transform text-red-400 hover:text-white flex items-center justify-center gap-2">
            <i class="fas fa-sign-out-alt"></i>
            Выйти
        </button>
    </form>

</div>
@endsection
