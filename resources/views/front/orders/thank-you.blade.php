@extends('layouts.front')

@section('title', 'Заказ принят')

@section('content')

<div class="max-w-md mx-auto relative pb-10">
    {{-- Заголовок --}}
    <div class="mb-8 text-center">
        <div class="w-16 h-16 bg-accent/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-check text-accent text-2xl"></i>
        </div>
        <h1 class="font-display text-2xl font-black tracking-tighter uppercase italic text-white mb-2">
            Спасибо, <span class="text-accent">{{ $order->name }}</span>!
        </h1>
        <p class="text-slate-400 text-sm">Ваш заказ успешно принят</p>
    </div>

    {{-- Номер заказа и статус --}}
    <div class="bg-white/[0.02] rounded-3xl border border-white/5 p-6 mb-6">
        <div class="flex items-center justify-between mb-4 pb-4 border-b border-white/5">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Номер заказа</span>
            <span class="font-display font-black text-xl text-white">#{{ $order->id }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Статус</span>
            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                @if($order->status === 'new') bg-yellow-500/20 text-yellow-400
                @elseif($order->status === 'processing') bg-blue-500/20 text-blue-400
                @elseif($order->status === 'done') bg-green-500/20 text-green-400
                @elseif($order->status === 'cancelled') bg-red-500/20 text-red-400
                @endif">
                {{ \App\Models\Order::getStatuses()[$order->status] ?? $order->status }}
            </span>
        </div>
    </div>

    {{-- Состав заказа --}}
    <div class="bg-white/[0.02] rounded-3xl border border-white/5 overflow-hidden mb-6">
        <div class="p-4 border-b border-white/5">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Состав заказа</span>
        </div>
        <div class="divide-y divide-white/5">
            @foreach($order->items as $item)
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-night rounded-full flex items-center justify-center border border-white/10">
                        <i class="fas fa-pizza-slice text-accent text-[10px]"></i>
                    </div>
                    <div>
                        <p class="font-bold text-white text-sm">{{ $item->dish?->name ?? 'Блюдо недоступно' }}</p>
                        <p class="text-[10px] text-slate-500">{{ $item->quantity }} шт.</p>
                    </div>
                </div>
                <span class="text-accent font-black text-sm">
                    {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽
                </span>
            </div>
            @endforeach
        </div>
        <div class="p-4 border-t border-white/5 flex justify-between items-center">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Итого</span>
            <span class="text-xl font-black text-accent">{{ number_format($order->total_price, 0, ',', ' ') }} ₽</span>
        </div>
    </div>

    {{-- Контактная информация --}}
    <div class="bg-white/[0.02] rounded-3xl border border-white/5 p-6 mb-6">
        <div class="mb-4">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 block mb-1">Телефон</span>
            <span class="text-white font-medium">{{ $order->phone }}</span>
        </div>
        @if($order->address)
        <div class="mb-4">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 block mb-1">Адрес</span>
            <span class="text-white">{{ $order->address }}</span>
        </div>
        @endif
        @if($order->description)
        <div>
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 block mb-1">Комментарий</span>
            <span class="text-white text-sm">{{ $order->description }}</span>
        </div>
        @endif
    </div>

    {{-- Кнопки действий --}}
    <div class="flex flex-col gap-3">
        <form action="{{ route('order.reorder', $order) }}" method="POST">
            @csrf
            <button type="submit" class="group relative w-full py-4 bg-accent rounded-2xl shadow-[0_15px_35px_rgba(255,77,0,0.4)] overflow-hidden transition-transform active:scale-95">
                <span class="relative font-display font-black text-white text-sm uppercase tracking-widest flex items-center justify-center gap-2">
                    <i class="fas fa-redo text-[10px]"></i> Повторить заказ
                </span>
            </button>
        </form>

        <a href="{{ route('menu') }}" class="text-center py-4 text-slate-500 hover:text-white text-[10px] font-black uppercase tracking-[0.2em] transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> Вернуться в меню
        </a>
    </div>
</div>

@endsection
