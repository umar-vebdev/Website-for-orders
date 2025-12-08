@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Блюда</h1>

    <a href="{{ route('admin.dishes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
        Добавить блюдо
    </a>

    <table class="w-full bg-white shadow rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Название</th>
                <th class="p-2">Цена</th>
                <th class="p-2">Вес</th>
                <th class="p-2">Фото</th>
                <th class="p-2">Действия</th>
            </tr>
        </thead>
        <tbody>
        @foreach($dishes as $dish)
            <tr class="border-t">
                <td class="p-2">{{ $dish->id }}</td>
                <td class="p-2">{{ $dish->name }}</td>
                <td class="p-2">{{ $dish->price }} ₽</td>
                <td class="p-2">{{ $dish->weight }} г</td>
                <td class="p-2">
                    @if($dish->image)
                        <img src="{{ asset('storage/' . $dish->image) }}" class="h-12">
                    @endif
                </td>
                <td class="p-2">
                    <a href="{{ route('admin.dishes.edit', $dish->id) }}" class="text-blue-500">Редактировать</a>

                    <form action="{{ route('admin.dishes.destroy', $dish->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 ml-2" onclick="return confirm('Удалить блюдо?')">
                            Удалить
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
