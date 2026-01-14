@extends('layouts.admin')

@section('title', 'Регистрация админа')

@section('content')
<div class="max-w-xl mx-auto pt-10 px-4">

    {{-- Заголовок --}}
    <div class="text-center mb-8">
        <h1 class="font-display text-2xl font-black tracking-tighter uppercase italic text-white">
            Новый <span class="text-accent text-outline">Администратор</span>
        </h1>
        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em] mt-2 text-center">
            Добавление пользователя с полным доступом
        </p>
    </div>

    {{-- Форма --}}
    <div class="glass-panel rounded-[40px] p-8 md:p-10 border-white/5 relative overflow-hidden">
        {{-- Декоративный элемент фона --}}
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-accent/10 blur-[80px] rounded-full"></div>

        <form action="{{ route('admin.register') }}" method="POST" class="space-y-6 relative">
            @csrf

            {{-- Поле: Имя --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-4">Публичное имя</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-accent transition-colors">
                        <i class="fas fa-user-shield text-[10px]"></i>
                    </div>
                    <input type="text" name="name" 
                           class="w-full pl-10 pr-4 py-4 rounded-2xl bg-night border border-white/5 text-white text-xs font-bold focus:outline-none focus:border-accent/50 transition-all placeholder:text-slate-700" 
                           required>
                </div>
            </div>

            {{-- Поле: Email --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-4">Email (Логин)</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-accent transition-colors">
                        <i class="fas fa-envelope text-[10px]"></i>
                    </div>
                    <input type="email" name="email" 
                           class="w-full pl-10 pr-4 py-4 rounded-2xl bg-night border border-white/5 text-white text-xs font-bold focus:outline-none focus:border-accent/50 transition-all placeholder:text-slate-700" 
                           placeholder="example@mail.com"
                           required>
                </div>
                @error('email')
                    <p class="text-red-500 text-[10px] font-bold uppercase tracking-tight mt-1 ml-4">{{ $message }}</p>
                @enderror
            </div>

            {{-- Поле: Пароль --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-4">Секретный пароль</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-accent transition-colors">
                        <i class="fas fa-lock text-[10px]"></i>
                    </div>
                    <input type="password" name="password" 
                           class="w-full pl-10 pr-4 py-4 rounded-2xl bg-night border border-white/5 text-white text-xs font-bold focus:outline-none focus:border-accent/50 transition-all placeholder:text-slate-700" 
                           placeholder="••••••••"
                           required>
                </div>
            </div>

            {{-- Кнопка --}}
            <div class="pt-4">
                <button type="submit" class="w-full py-5 bg-accent rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] text-white shadow-lg shadow-accent/20 hover:brightness-110 active:scale-95 transition-all">
                    Создать аккаунт
                </button>
            </div>
        </form>
    </div>

    {{-- Ссылка назад --}}
    <div class="mt-8 text-center">
        <a href="{{ route('admin.dashboard') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-600 hover:text-white transition-colors">
            <i class="fas fa-chevron-left mr-2 text-[8px]"></i> Вернуться в панель
        </a>
    </div>

</div>

<style>
    .text-outline {
        color: transparent;
        -webkit-text-stroke: 1px #FF4D00;
    }
</style>
@endsection