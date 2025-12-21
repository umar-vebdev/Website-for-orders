@extends('layouts.admin')

@section('title', 'Блюда')

@section('content')
<div class="container mx-auto p-2 space-y-2">

    @foreach($dishes as $dish)
        <div class="flex flex-wrap items-center gap-2 p-2 bg-gray-900/80 rounded-xl shadow-md hover:bg-gray-800/70 transition w-full">

            {{-- Фото --}}
            <img src="{{ asset('storage/' . $dish->photo_path) }}" 
                 alt="{{ $dish->name }}" 
                 class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 object-cover rounded-xl flex-shrink-0">

            {{-- Информация --}}
            <div class="flex-1 min-w-0">
                <h2 class="text-sm sm:text-base md:text-lg font-semibold text-white truncate">{{ $dish->name }}</h2>
                <p class="text-gray-400 text-xs sm:text-sm">{{ $dish->weight }} г</p>
                <p class="text-gray-200 font-medium text-sm sm:text-base">{{ number_format($dish->price, 0, ',', ' ') }} ₽</p>
            </div>

            {{-- Действия --}}
            <div class="flex gap-1 flex-shrink-0 mt-2 sm:mt-0">
                <a href="{{ route('admin.dishes.edit', $dish->id) }}" 
                   class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-xs sm:text-sm whitespace-nowrap">
                    Редактировать
                </a>
                <form action="{{ route('admin.dishes.destroy', $dish->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-xs sm:text-sm whitespace-nowrap">
                        Удалить
                    </button>
                </form>
            </div>
        </div>
    @endforeach

</div>
@endsection
