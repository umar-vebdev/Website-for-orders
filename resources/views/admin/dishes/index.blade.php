@extends('layouts.admin')

@section('title', 'Управление блюдами')

@section('content')

{{-- Заголовок и кнопка добавления --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="font-display text-2xl font-black tracking-tighter uppercase italic text-white">
            Меню <span class="text-accent text-outline">блюд</span>
        </h1>
        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em] mt-1">Всего позиций: {{ $dishes->count() }}</p>
    </div>

    <a href="{{ route('admin.dishes.create') }}"
       class="group relative px-6 py-3 bg-accent rounded-2xl shadow-[0_10px_25px_rgba(255,77,0,0.3)] overflow-hidden transition-all active:scale-95">
        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
        <span class="relative font-display font-black text-white text-xs uppercase tracking-widest flex items-center gap-2">
            Добавить блюдо <i class="fas fa-plus text-[10px]"></i>
        </span>
    </a>
</div>

{{-- Список блюд --}}
<div class="grid grid-cols-1 gap-3">

    @foreach($dishes as $dish)
        <div class="group flex items-center gap-4 p-4 glass-panel rounded-[24px] hover:border-accent/30 transition-all">

            {{-- Основная информация --}}
            <div class="flex-1 min-w-0">
                <div class="flex flex-col md:flex-row md:items-center gap-1 md:gap-4">
                    <h2 class="font-bold text-sm sm:text-base text-white uppercase italic tracking-tight truncate">
                        {{ $dish->name }}
                    </h2>
                </div>
                
                <div class="mt-2 text-base sm:text-lg font-display font-black text-accent italic">
                    {{ number_format($dish->price, 0, ',', ' ') }} ₽
                </div>
            </div>

            {{-- Действия --}}
            <div class="flex items-center gap-2">
                {{-- Редактировать --}}
                <a href="{{ route('admin.dishes.edit', $dish->id) }}"
                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition-all shadow-lg active:scale-90"
                   title="Редактировать">
                    <i class="fas fa-edit text-xs"></i>
                </a>

                {{-- Удалить --}}
                <form action="{{ route('admin.dishes.destroy', $dish->id) }}" method="POST" 
                      onsubmit="return confirm('Вы уверены, что хотите удалить это блюдо?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-lg active:scale-90"
                            title="Удалить">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </button>
                </form>
            </div>

        </div>
    @endforeach

</div>

{{-- Сообщение, если блюд нет --}}
@if($dishes->isEmpty())
    <div class="py-20 text-center glass-panel rounded-[32px]">
        <i class="fas fa-utensils text-4xl text-white/5 mb-4"></i>
        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Список блюд пока пуст</p>
    </div>
@endif

<style>
    .text-outline {
        color: transparent;
        -webkit-text-stroke: 1px #FF4D00;
    }
</style>

@endsection