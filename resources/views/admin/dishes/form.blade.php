@extends('layouts.admin')

@section('title', isset($dish) ? 'Редактировать блюдо' : 'Добавить блюдо')

@section('content')
<div class="max-w-md mx-auto p-4 bg-gray-900/80 backdrop-blur rounded-xl shadow-md">

    <form action="{{ isset($dish) ? route('admin.dishes.update', $dish->id) : route('admin.dishes.store') }}" 
          method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @if(isset($dish))
            @method('PUT')
        @endif

        {{-- Название --}}
        <div>
            <label class="block text-gray-300 mb-1">Название</label>
            <input type="text" name="name" value="{{ $dish->name ?? '' }}" 
                   class="w-full p-2 rounded bg-gray-800 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500" required>
        </div>

        {{-- Цена --}}
        <div>
            <label class="block text-gray-300 mb-1">Цена</label>
            <input type="number" name="price" value="{{ $dish->price ?? '' }}" 
                   class="w-full p-2 rounded bg-gray-800 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500" required>
        </div>

        {{-- Вес --}}
        <div>
            <label class="block text-gray-300 mb-1">Вес (г)</label>
            <input type="number" name="weight" value="{{ $dish->weight ?? '' }}" 
                   class="w-full p-2 rounded bg-gray-800 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500" required>
        </div>

        {{-- Кнопка --}}
        <button type="submit" 
                class="w-full py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded shadow hover:from-blue-500 hover:to-blue-700 transition">
            {{ isset($dish) ? 'Сохранить' : 'Добавить' }}
        </button>
    </form>
</div>
@endsection
