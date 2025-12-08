@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ isset($dish) ? 'Редактировать блюдо' : 'Добавить блюдо' }}</h1>

    <form action="{{ isset($dish) ? route('admin.dishes.update', $dish->id) : route('admin.dishes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($dish))
            @method('PUT')
        @endif

        <div class="mb-2">
            <label class="block">Название</label>
            <input type="text" name="name" value="{{ $dish->name ?? '' }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-2">
            <label class="block">Цена</label>
            <input type="number" name="price" value="{{ $dish->price ?? '' }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-2">
            <label class="block">Вес</label>
            <input type="number" name="weight" value="{{ $dish->weight ?? '' }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-2">
            <label class="block">Фото</label>
            <input type="file" name="photo_path" class="border p-2 w-full">
            @if(isset($dish) && $dish->photo_path)
                <img src="{{ asset('storage/'.$dish->photo_path) }}" class="w-16 h-16 mt-2">
            @endif
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ isset($dish) ? 'Сохранить' : 'Добавить' }}</button>
    </form>
</div>
@endsection
