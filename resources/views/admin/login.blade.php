@extends('layouts.front')

@section('title', 'Вход для админа')

@section('content')

<div class="mb-8 px-2 text-center">
    <h1 class="font-display text-2xl font-black tracking-tighter uppercase italic text-white">
        Admin <span class="text-accent">Access</span>
    </h1>
    <div class="w-10 h-1 bg-accent mx-auto mt-2 rounded-full"></div>
</div>

<div class="max-w-md mx-auto relative px-2">

    {{-- Ошибки --}}
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold uppercase tracking-widest leading-relaxed shadow-lg shadow-red-500/5">
            <div class="flex items-center gap-2 mb-1">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Ошибка доступа:</span>
            </div>
            <ul class="list-disc list-inside opacity-80 font-medium normal-case tracking-normal">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white/[0.02] border border-white/5 rounded-[32px] p-8 shadow-2xl relative overflow-hidden">
        {{-- Декор на фоне --}}
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-accent/5 rounded-full blur-3xl"></div>
        
        <form action="{{ route('admin.login') }}" method="POST" class="space-y-6 relative z-10">
            @csrf

            {{-- Email --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Электронная почта</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 text-xs"></i>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full pl-11 pr-4 py-4 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all placeholder:text-slate-700 text-sm"
                           placeholder="admin@example.com"
                           required autofocus>
                </div>
            </div>

            {{-- Пароль --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Секретный пароль</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 text-xs"></i>
                    <input type="password" name="password"
                           class="w-full pl-11 pr-4 py-4 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all placeholder:text-slate-700 text-sm"
                           placeholder="••••••••"
                           required>
                </div>
            </div>

            {{-- Кнопка входа --}}
            <div class="pt-2">
                <button type="submit"
                        class="group relative w-full py-4 bg-accent rounded-2xl shadow-[0_15px_35px_rgba(255,77,0,0.3)] overflow-hidden transition-all active:scale-95">
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <span class="relative font-display font-black text-white text-sm uppercase tracking-widest flex items-center justify-center gap-3">
                        Авторизация <i class="fas fa-sign-in-alt text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('menu') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-600 hover:text-white transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> На главную
        </a>
    </div>
</div>

@endsection