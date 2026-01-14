@extends('layouts.admin')

@section('title', isset($dish) ? 'Редактировать блюдо' : 'Добавить блюдо')

@section('content')

<div class="mb-8 px-2">
    <h1 class="font-display text-2xl font-black tracking-tighter uppercase italic text-white">
        {{ isset($dish) ? 'Правка' : 'Новое' }} <span class="text-accent text-outline">блюдо</span>
    </h1>
    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em] mt-1">Заполните данные позиции меню</p>
</div>

<div class="max-w-xl mx-auto relative px-2 pb-10">

    <div class="glass-panel rounded-[32px] p-8 shadow-2xl relative overflow-hidden">
        {{-- Декор --}}
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-accent/5 rounded-full blur-3xl"></div>

        <form action="{{ isset($dish) ? route('admin.dishes.update', $dish->id) : route('admin.dishes.store') }}" 
              method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
            @csrf
            @if(isset($dish))
                @method('PUT')
            @endif

            {{-- Название --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Название блюда</label>
                <div class="relative">
                    <i class="fas fa-quote-left absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 text-xs"></i>
                    <input type="text" name="name" value="{{ old('name', $dish->name ?? '') }}" 
                           class="w-full pl-11 pr-4 py-4 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all placeholder:text-slate-700 text-sm font-bold" 
                           placeholder="Например: Пицца Маргарита" required>
                </div>
                @error('name') <p class="text-red-500 text-[10px] uppercase font-bold ml-2">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Цена --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Цена (₽)</label>
                    <div class="relative">
                        <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 text-xs"></i>
                        <input type="number" name="price" value="{{ old('price', $dish->price ?? '') }}" 
                               class="w-full pl-11 pr-4 py-4 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all text-sm font-mono font-bold" 
                               placeholder="550" required>
                    </div>
                </div>

            {{-- Кнопка --}}
            <div class="pt-4 flex flex-col sm:flex-row gap-4">
                <button type="submit" 
                        class="flex-1 group relative py-4 bg-accent rounded-2xl shadow-[0_15px_35px_rgba(255,77,0,0.3)] overflow-hidden transition-all active:scale-95">
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <span class="relative font-display font-black text-white text-xs uppercase tracking-widest flex items-center justify-center gap-2">
                        {{ isset($dish) ? 'Сохранить изменения' : 'Создать блюдо' }}
                        <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </button>

                <a href="{{ route('admin.dishes') }}" 
                   class="py-4 px-8 border border-white/5 rounded-2xl text-slate-500 font-bold text-[10px] uppercase tracking-widest hover:text-white hover:bg-white/5 transition-all text-center">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .text-outline {
        color: transparent;
        -webkit-text-stroke: 1px #FF4D00;
    }
</style>

@endsection