@extends('layouts.front')

@section('title', 'Меню')

@section('content')

{{-- Заголовок --}}
<div class="mb-4 px-2 flex items-center justify-between">
    <div class="flex items-center gap-2">
        <div class="w-0.5 h-4 bg-accent rounded-full"></div>
        <h1 class="font-display text-sm sm:text-base font-black tracking-widest uppercase italic text-white leading-none">
            Меню
        </h1>
    </div>
</div>

{{-- Фильтр категорий (2 горизонтальных ряда) --}}
<div class="mb-6 px-2 overflow-x-auto scrollbar-hide">
    <div class="grid grid-rows-2 grid-flow-col gap-2 w-max">
        @php
            $categories = ['Самса', 'Выпечка с мясом', 'Сытная выпечка', 'Сладкая выпечка', 'Большие пироги', 'Хлеб'];
            $currentCategory = request('category');
        @endphp

        <a href="{{ route('menu') }}" 
           class="px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center transition-all border whitespace-nowrap
           {{ !$currentCategory ? 'bg-accent border-accent text-white shadow-lg' : 'bg-white/5 border-white/5 text-slate-400' }}">
           Все
        </a>

        @foreach($categories as $cat)
            <a href="{{ route('menu', ['category' => $cat]) }}" 
               class="px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center transition-all border whitespace-nowrap
               {{ $currentCategory === $cat ? 'bg-white border-white text-black shadow-lg' : 'bg-white/5 border-white/5 text-slate-400' }}">
               {{ $cat }}
            </a>
        @endforeach
    </div>
</div>

{{-- Индикатор страниц --}}
<div class="mb-4 px-2 flex justify-end">
    <span class="text-[9px] font-black text-slate-600 uppercase tracking-tighter">
        Стр. {{ $dishes->currentPage() }} из {{ $dishes->lastPage() }}
    </span>
</div>

<div class="max-w-md mx-auto relative pb-20">
    <div id="menu-list" class="flex flex-col bg-white/[0.02] rounded-3xl overflow-hidden border border-white/5 shadow-2xl">
        @forelse($dishes as $dish)
            <div class="group flex items-start gap-3 p-4 border-b border-white/5 last:border-0 hover:bg-white/[0.05] transition-colors" data-id="{{ $dish->id }}">
                <div class="flex-1 min-w-0 pt-0.5">
                    <div class="flex flex-col gap-1">
                        <h2 class="font-bold text-[15px] text-white leading-tight break-words">
                            {{ $dish->name }}
                        </h2>
                        <span class="text-accent font-black text-[14px]">
                            {{ number_format($dish->price, 0, ',', ' ') }} ₽
                        </span>
                    </div>
                </div>

                <div class="flex items-center bg-white/5 rounded-full p-0.5 border border-white/5 shrink-0 self-center ml-2">
                    <button class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white" onclick="decrement('{{ $dish->id }}')">
                        <i class="fas fa-minus text-[10px]"></i>
                    </button>
                    <input id="qty-{{ $dish->id }}" value="0" type="number" inputmode="numeric" oninput="validateInput(this); updateFloatingButton();" class="w-10 text-center bg-transparent text-white font-bold text-sm focus:outline-none">
                    <button class="w-8 h-8 flex items-center justify-center text-accent" onclick="increment('{{ $dish->id }}')">
                        <i class="fas fa-plus text-[10px]"></i>
                    </button>
                </div>
            </div>
        @empty
            <div class="p-10 text-center">
                <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Ничего не найдено</p>
            </div>
        @endforelse
    </div>

    {{-- Навигация --}}
    @if($dishes->hasPages())
        <div class="mt-8 flex items-center justify-center gap-8">
            <a href="{{ $dishes->appends(request()->query())->previousPageUrl() }}" class="w-12 h-12 rounded-full border border-accent/30 flex items-center justify-center {{ $dishes->onFirstPage() ? 'opacity-10 pointer-events-none' : '' }}">
                <i class="fas fa-chevron-left text-accent"></i>
            </a>
            <span class="font-display font-black text-sm text-white/80 tracking-widest">{{ $dishes->currentPage() }}</span>
            <a href="{{ $dishes->appends(request()->query())->nextPageUrl() }}" class="w-12 h-12 rounded-full border border-accent/30 flex items-center justify-center {{ !$dishes->hasMorePages() ? 'opacity-10 pointer-events-none' : '' }}">
                <i class="fas fa-chevron-right text-accent"></i>
            </a>
        </div>
    @endif
</div>

{{-- Кнопка корзины --}}
<div class="fixed bottom-6 left-0 w-full flex justify-center z-[90] px-6">
    <button id="add-all-to-cart" class="group w-full max-w-md py-4 bg-accent rounded-2xl shadow-[0_15px_35px_rgba(255,77,0,0.4)] flex items-center justify-center gap-3 transition-all active:scale-95 opacity-0 translate-y-20 pointer-events-none">
        <span class="font-display font-black text-white text-sm uppercase tracking-widest">В корзину</span>
        <div class="bg-white/20 px-2 py-0.5 rounded-lg">
            <i class="fas fa-shopping-cart text-white text-[10px]"></i>
        </div>
    </button>
</div>

@push('scripts')
<script>
function validateInput(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
    if (input.value.length > 1 && input.value[0] === '0') {
        input.value = parseInt(input.value);
    }
    if (parseInt(input.value) > 999) input.value = 999;
}

function increment(id) {
    const input = document.getElementById('qty-' + id);
    let val = parseInt(input.value) || 0;
    input.value = val + 1;
    updateFloatingButton();
}

function decrement(id) {
    const input = document.getElementById('qty-' + id);
    let val = parseInt(input.value) || 0;
    if (val > 0) input.value = val - 1;
    updateFloatingButton();
}

function updateFloatingButton() {
    let total = 0;
    document.querySelectorAll('input[id^="qty-"]').forEach(i => {
        total += parseInt(i.value || 0);
    });
    
    const btn = document.getElementById('add-all-to-cart');
    if (total > 0) {
        btn.classList.remove('opacity-0', 'translate-y-20', 'pointer-events-none');
        btn.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
    } else {
        btn.classList.add('opacity-0', 'translate-y-20', 'pointer-events-none');
        btn.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
    }
}

document.getElementById('add-all-to-cart').addEventListener('click', function () {
    const items = [];
    document.querySelectorAll('[data-id]').forEach(item => {
        const id = item.getAttribute('data-id');
        const qty = parseInt(document.getElementById('qty-' + id).value);
        if (qty > 0) {
            items.push({ dish_id: id, quantity: qty });
        }
    });

    if (items.length === 0) return;

    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span class="ml-2 uppercase text-[10px] tracking-widest">Обработка...</span>';
    this.disabled = true;

    fetch('/cart/add-multiple', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ items })
    })
    .then(res => res.ok ? window.location.href = '{{ route("cart.index") }}' : location.reload())
    .catch(() => location.reload());
});
</script>
@endpush

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
</style>

@endsection