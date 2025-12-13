@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Панель администратора</h1>

    <div class="space-y-2">
        <a href="{{ route('admin.dishes') }}" class="block p-4 bg-blue-500 text-white rounded hover:bg-blue-600">
            Управление блюдами
        </a>

        <a href="{{ route('admin.orders') }}" class="block p-4 bg-green-500 text-white rounded hover:bg-green-600">
            Управление заказами
        </a>

        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="text-red-500 hover:underline">Выйти</button>
        </form>
    </div>
</div>
@endsection
