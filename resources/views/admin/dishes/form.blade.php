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

    <div class="glass-panel rounded-[32px] p-8 shadow-2xl relative overflow-hidden bg-white/[0.02] border border-white/5">
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
                           placeholder="Например: Самса с говядиной" required>
                </div>
                @error('name') <p class="text-red-500 text-[10px] uppercase font-bold ml-2">{{ $message }}</p> @enderror
            </div>

           {{-- Категория --}}
<div class="space-y-2">
    @php
        $dishCategories = ['Самса', 'Выпечка с мясом', 'Сытная выпечка', 'Сладкая выпечка', 'Пироги', 'Хлеб'];
    @endphp
    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Категория блюда</label>
    <div class="relative">
        <i class="fas fa-folder absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 text-xs"></i>
        <select name="category"
                class="w-full pl-11 pr-10 py-4 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all text-sm font-bold appearance-none cursor-pointer"
                required>
            <option value="" disabled {{ !isset($dish) ? 'selected' : '' }}>Выберите категорию</option>
            @foreach($dishCategories as $cat)
                <option value="{{ $cat }}" {{ (old('category', $dish->category ?? '') == $cat) ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-600">
            <i class="fas fa-chevron-down text-[10px]"></i>
        </div>
    </div>
    @error('category') <p class="text-red-500 text-[10px] uppercase font-bold ml-2">{{ $message }}</p> @enderror
</div>
                {{-- Цена --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Цена (₽)</label>
                    <div class="relative">
                        <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 text-xs"></i>
                        <input type="number" name="price" value="{{ old('price', $dish->price ?? '') }}" 
                               class="w-full pl-11 pr-4 py-4 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all text-sm font-mono font-bold" 
                               placeholder="150" required>
                    </div>
                    @error('price') <p class="text-red-500 text-[10px] uppercase font-bold ml-2">{{ $message }}</p> @enderror
                </div>

                {{-- Вес --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Вес (г)</label>
                    <div class="relative">
                        <i class="fas fa-balance-scale absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 text-xs"></i>
                        <input type="number" name="weight" value="{{ old('weight', $dish->weight ?? '') }}" 
                               class="w-full pl-11 pr-4 py-4 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all text-sm font-mono font-bold" 
                               placeholder="250">
                    </div>
                </div>

                {{-- Описание --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Описание</label>
                    <textarea name="description" rows="3"
                           class="w-full px-4 py-4 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all placeholder:text-slate-700 text-sm font-bold resize-none" 
                           placeholder="Свежая выпечка...">{{ old('description', $dish->description ?? '') }}</textarea>
                </div>

                {{-- Порядок сортировки --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Порядок сортировки</label>
                    <div class="relative">
                        <i class="fas fa-sort-numeric-down absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 text-xs"></i>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $dish->sort_order ?? 0) }}" 
                               class="w-full pl-11 pr-4 py-4 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all text-sm font-mono font-bold">
                    </div>
                </div>

                {{-- Активно --}}
                <div class="flex items-center gap-3 ml-2 pt-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $dish->is_active ?? true) ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-white/10 bg-night/50 text-accent focus:ring-accent focus:ring-offset-night cursor-pointer">
                    <label for="is_active" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 cursor-pointer">
                        Отображать в меню
                    </label>
                </div>
            </div>

            {{-- Кнопки управления --}}
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
    .glass-panel {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
    }
</style>

@push('scripts')
<script>
function setCategory(name) {
    const input = document.getElementById('category-input');
    input.value = name;
    
    input.focus();
    input.classList.add('border-accent/50');
    setTimeout(() => {
        input.classList.remove('border-accent/50');
    }, 600);
}
</script>
@endpush

@endsection