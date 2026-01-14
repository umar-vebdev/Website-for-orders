@extends('layouts.front')

@section('title', 'Корзина')

@section('content')

<div class="mb-6 px-2">
    <h1 class="font-display text-2xl font-black tracking-tighter uppercase italic text-white flex items-center gap-2">
        <span class="w-1 h-6 bg-accent rounded-full"></span>
        Ваша <span class="text-accent text-outline">корзина</span>
    </h1>
</div>

<div class="max-w-md mx-auto relative px-2">

    @if(empty($cart))
        <div class="py-20 text-center bg-white/[0.02] rounded-[32px] border border-white/5">
            <i class="fas fa-shopping-basket text-4xl text-white/10 mb-4"></i>
            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Корзина пуста</p>
            <a href="{{ route('menu') }}" class="inline-block mt-4 text-accent font-bold text-sm border-b border-accent/30 hover:border-accent transition">Вернуться в меню</a>
        </div>
    @else

    <div class="flex flex-col bg-white/[0.02] rounded-3xl overflow-hidden border border-white/5 mb-6">
        @foreach($cart as $id => $item)
            <div class="flex items-center gap-3 p-3 border-b border-white/5 last:border-0 hover:bg-white/[0.04] transition-colors">
                
                <div class="w-10 h-10 bg-night rounded-full flex items-center justify-center border border-white/10 shrink-0">
                    <i class="fas fa-pizza-slice text-accent text-xs"></i>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex flex-col">
                        <h2 class="font-bold text-[14px] text-white leading-tight uppercase break-words">
                            {{ $item['name'] }}
                        </h2>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-[12px] font-black text-accent">
                                {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} ₽
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Управление количеством --}}
                <div class="flex items-center gap-1 shrink-0">
                    <div class="flex items-center bg-white/5 rounded-full p-0.5 border border-white/10">
                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center" id="form-{{ $id }}">
                            @csrf
                            {{-- Минус (теперь type="button" + JS для надежности) --}}
                            <button type="button" 
                                onclick="updateQty('{{ $id }}', {{ $item['quantity'] - 1 }})"
                                class="w-8 h-8 flex items-center justify-center text-slate-400 active:scale-90 transition-transform">
                                <i class="fas fa-minus text-[9px]"></i>
                            </button>
                            
                            <input 
                                type="number" 
                                id="input-{{ $id }}"
                                name="quantity_manual" 
                                value="{{ $item['quantity'] }}" 
                                onchange="this.form.submit()"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-8 text-center bg-transparent text-white font-bold text-[13px] focus:outline-none appearance-none"
                            >
                            
                            {{-- Плюс (теперь type="button" + JS для надежности) --}}
                            <button type="button" 
                                onclick="updateQty('{{ $id }}', {{ $item['quantity'] + 1 }})"
                                class="w-8 h-8 flex items-center justify-center text-accent active:scale-90 transition-transform">
                                <i class="fas fa-plus text-[9px]"></i>
                            </button>

                            {{-- Скрытое поле, чтобы контроллер поймал значение --}}
                            <input type="hidden" name="quantity" id="hidden-{{ $id }}" value="{{ $item['quantity'] }}">
                        </form>
                    </div>

                    {{-- Удалить --}}
                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-700 hover:text-red-500 transition-colors">
                            <i class="fa-solid fa-trash-can text-[11px]"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    @php
        $totalPrice = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    @endphp

    <div class="px-4 py-4 mb-6 bg-white/[0.02] rounded-2xl border border-dashed border-white/10 flex justify-between items-center">
        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Итого к оплате</span>
        <span class="text-xl font-black text-accent">{{ number_format($totalPrice, 0, ',', ' ') }} ₽</span>
    </div>

    <div class="flex flex-col gap-3">
        <a href="{{ route('checkout.form') }}" 
           class="group relative flex items-center justify-center py-5 bg-accent rounded-2xl shadow-[0_15px_35px_rgba(255,77,0,0.4)] transition-all active:scale-95">
            <span class="font-display font-black text-white text-base uppercase tracking-widest">Оформить заказ</span>
        </a>

        <form action="{{ route('cart.clear') }}" method="POST" class="w-full text-center">
            @csrf
            <button type="submit" class="text-slate-600 hover:text-red-500 text-[10px] font-black uppercase tracking-[0.2em] transition-colors py-2">
                <i class="fas fa-times mr-1"></i> Очистить корзину
            </button>
        </form>
    </div>

    @endif
</div>

<script>
    // Функция для работы кнопок + и -
    function updateQty(id, newVal) {
        if (newVal < 0) return; // Не уходим в минус
        const input = document.getElementById('input-' + id);
        const hidden = document.getElementById('hidden-' + id);
        const form = document.getElementById('form-' + id);
        
        input.value = newVal;
        hidden.value = newVal;
        form.submit(); // Отправляем форму
    }
</script>

<style>
    .text-outline {
        color: transparent;
        -webkit-text-stroke: 1px #FF4D00;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

@endsection