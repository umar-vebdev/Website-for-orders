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

    {{-- Список админов --}}
    <div class="col-span-full p-6 border border-slate-800 rounded-xl shadow bg-[#020617]/80 text-white">
        <div class="font-semibold text-lg mb-4">Список администраторов</div>
        <ul class="space-y-2">
            @foreach($admins as $admin)
                <li class="flex justify-between items-center bg-gray-800/50 rounded p-2">
                    <span>{{ $admin->name }} ({{ $admin->email }})</span>
                    <form action="{{ route('admin.delete', $admin->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-400">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Выход --}}
    <form action="{{ route('admin.logout') }}" method="POST" class="col-span-full">
        @csrf
        <button type="submit" class="w-full p-4 border border-red-500 rounded-xl shadow hover:scale-105 transition transform text-red-400 hover:text-white flex items-center justify-center gap-2">
            <i class="fas fa-sign-out-alt"></i>
            Выйти
        </button>
    </form>

{{-- Список логов --}}
<ul class="space-y-2 max-h-96 overflow-y-auto">
    @foreach($adminLogs as $log)
        <li class="flex justify-between items-center bg-gray-800/50 rounded p-2">
            <span><strong>{{ $log->admin_name }}</strong> — {{ $log->action }} {{ $log->description }}</span>
        </li>
    @endforeach
</ul>

</div>
@endsection
