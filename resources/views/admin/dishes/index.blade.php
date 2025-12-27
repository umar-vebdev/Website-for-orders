@extends('layouts.admin')

@section('title', 'Блюда')

@section('content')

{{-- Кнопка добавления --}}
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.dishes.create') }}"
       class="px-4 py-2
              bg-gradient-to-r from-blue-600 to-blue-800
              hover:from-blue-500 hover:to-blue-700
              text-white rounded-xl shadow transition">
        Добавить блюдо
    </a>
</div>

<div class="flex flex-col gap-2 w-full overflow-x-hidden">

    @foreach($dishes as $dish)
        <div
            class="flex items-center gap-2 p-2 rounded-xl
                   bg-[#020617]/90 border border-slate-800
                   hover:bg-[#020617] transition
                   w-full overflow-hidden"
        >

            {{-- Информация --}}
            <div class="flex-1 min-w-0">
                <h2 class="text-sm sm:text-base font-medium text-white truncate">
                    {{ $dish->name }}
                </h2>
                <div class="text-xs sm:text-sm text-slate-400">
                    {{ $dish->weight }} г
                </div>
                <div class="mt-0.5 text-sm sm:text-base font-semibold text-white">
                    {{ number_format($dish->price, 0, ',', ' ') }} ₽
                </div>
            </div>

            {{-- Действия (как в меню — компактно) --}}
            <div class="flex flex-col gap-1 flex-shrink-0">

                <a href="{{ route('admin.dishes.edit', $dish->id) }}"
                   class="px-3 py-1 text-xs sm:text-sm
                          bg-gradient-to-r from-blue-600 to-blue-800
                          hover:from-blue-500 hover:to-blue-700
                          text-white rounded-lg text-center transition">
                    Редактировать
                </a>

                <form action="{{ route('admin.dishes.destroy', $dish->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="px-3 py-1 text-xs sm:text-sm
                               bg-gradient-to-r from-red-600 to-red-800
                               hover:from-red-500 hover:to-red-700
                               text-white rounded-lg w-full transition">
                        Удалить
                    </button>
                </form>

            </div>

        </div>
    @endforeach

</div>

@endsection
