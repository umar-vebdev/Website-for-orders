@extends('layouts.front')

@section('title', 'Оформление заказа')

@section('content')

{{-- Заголовок с фиксом горизонтального скролла --}}
<div class="mb-6 px-4">
    <h1 class="font-display text-xl sm:text-2xl font-black tracking-tighter uppercase italic text-white flex items-start gap-3 leading-tight">
        <span class="w-1 h-8 bg-accent rounded-full shrink-0 mt-1"></span>
        <span class="block">
            Оформление 
            <span class="text-accent text-outline break-words">заказа</span>
        </span>
    </h1>
</div>

<div class="max-w-md mx-auto relative px-2 pb-10">

    <div class="bg-white/[0.02] border border-white/5 rounded-[32px] p-6 shadow-2xl">
        <form action="{{ route('checkout.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Имя --}}
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Ваше имя</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 text-xs"></i>
                    <input
                        type="text"
                        name="name"
                        required
                        class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all placeholder:text-slate-700 text-sm"
                    >
                </div>
            </div>

            {{-- Телефон --}}
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Телефон</label>
                <div class="relative">
                    <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 text-xs"></i>
                    <input
                        type="tel"
                        name="phone"
                        id="phone"
                        required
                        placeholder="+7 (___) ___-__-__"
                        class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all placeholder:text-slate-700 text-sm font-mono"
                    >
                </div>
            </div>

            {{-- Адрес --}}
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Адрес доставки</label>
                <div class="relative">
                    <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 text-xs"></i>
                    <input
                        type="text"
                        name="address"
                        required
                        class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all placeholder:text-slate-700 text-sm"
                    >
                </div>
            </div>

            {{-- Комментарий --}}
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Комментарий</label>
                <textarea
                    name="description"
                    rows="3"
                    class="w-full px-4 py-3.5 rounded-2xl bg-night/50 text-white border border-white/5 focus:border-accent/50 focus:outline-none transition-all placeholder:text-slate-700 text-sm resize-none"
                ></textarea>
            </div>

            {{-- Кнопка --}}
            <div class="pt-4">
                <button
                    type="submit"
                    class="group relative w-full py-4 bg-accent rounded-2xl shadow-[0_15px_35px_rgba(255,77,0,0.4)] overflow-hidden transition-transform active:scale-95"
                >
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <span class="relative font-display font-black text-white text-sm uppercase tracking-widest flex items-center justify-center gap-2">
                        Подтвердить заказ <i class="fas fa-check text-[10px]"></i>
                    </span>
                </button>
            </div>
        </form>
    </div>
    
    <div class="mt-6 text-center">
        <a href="{{ route('cart.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-600 hover:text-accent transition">
            <i class="fas fa-arrow-left mr-1"></i> Вернуться в корзину
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

@push('scripts')
<script>
// Ваша логика маски телефона остается без изменений, она отличная
const phoneInput = document.getElementById('phone');

phoneInput.addEventListener('input', function () {
    let digits = this.value.replace(/\D/g, '');

    if (digits.startsWith('8')) {
        digits = '7' + digits.slice(1);
    }

    if (!digits.startsWith('7') && digits.length > 0) {
        digits = '7' + digits;
    }

    digits = digits.slice(0, 11);

    let formatted = '+7';

    if (digits.length > 1) {
        formatted += ' (' + digits.slice(1, 4);
    }
    if (digits.length >= 5) {
        formatted += ') ' + digits.slice(4, 7);
    }
    if (digits.length >= 8) {
        formatted += '-' + digits.slice(7, 9);
    }
    if (digits.length >= 10) {
        formatted += '-' + digits.slice(9, 11);
    }

    this.value = digits.length > 0 ? formatted : '';
});
</script>
@endpush