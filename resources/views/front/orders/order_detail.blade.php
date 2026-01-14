@extends('layouts.front')

@section('title', 'Заказ №'.$order->id)

@section('content')

{{-- Шапка страницы --}}
<div class="mb-6 px-2 flex justify-between items-end">
    <div>
        <h1 class="font-display text-2xl font-black tracking-tighter uppercase italic text-white leading-none">
            Заказ <span class="text-accent">#{{ $order->id }}</span>
        </h1>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mt-2">
            {{ $order->created_at->format('d.m.Y H:i') }}
        </p>
    </div>
    
    {{-- Кнопка копирования в стиле "Action" --}}
    <button onclick="copyOrderItems()" class="w-10 h-10 flex items-center justify-center bg-white/5 border border-white/10 rounded-xl text-accent hover:bg-accent hover:text-white transition-all shadow-lg active:scale-90">
        <i class="fas fa-copy text-sm"></i>
    </button>
</div>

<div class="max-w-md mx-auto relative px-2 pb-20">

    {{-- Статус заказа --}}
    <div class="mb-6">
        @php
            $statusData = match($order->status) {
                'new' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-400', 'label' => 'Новый'],
                'processing' => ['bg' => 'bg-orange-500/10', 'text' => 'text-orange-400', 'label' => 'Готовится'],
                'done' => ['bg' => 'bg-green-500/10', 'text' => 'text-green-400', 'label' => 'Доставлен'],
                'cancelled' => ['bg' => 'bg-red-500/10', 'text' => 'text-red-400', 'label' => 'Отменен'],
                default => ['bg' => 'bg-slate-500/10', 'text' => 'text-slate-400', 'label' => $order->status],
            };
        @endphp
        <div class="flex items-center gap-3 p-4 {{ $statusData['bg'] }} border border-white/5 rounded-2xl transition-all">
            <div class="w-2 h-2 rounded-full {{ str_replace('text-', 'bg-', $statusData['text']) }} animate-pulse"></div>
            <span class="text-[11px] font-black uppercase tracking-[0.2em] {{ $statusData['text'] }}">
                Статус: {{ \App\Models\Order::getStatuses()[$order->status] }}
            </span>
        </div>
    </div>

    {{-- Состав заказа --}}
    <div class="mb-6">
        <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-3 ml-2">Позиции заказа</h2>
        <div class="flex flex-col bg-white/[0.02] rounded-[28px] overflow-hidden border border-white/5">
            @foreach($order->items as $item)
                <div class="order-item flex items-center gap-3 p-4 border-b border-white/5 last:border-0"
                     data-name="{{ $item->dish->name }}" data-qty="{{ $item->quantity }}">
                    
                    <div class="w-10 h-10 bg-night border border-white/5 rounded-full flex items-center justify-center shrink-0">
                        <i class="fas fa-pizza-slice text-accent text-xs"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-sm text-white truncate pr-2 uppercase italic leading-tight">{{ $item->dish->name }}</h3>
                            <span class="text-white font-black text-sm whitespace-nowrap">{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽</span>
                        </div>
                        <p class="text-[10px] font-bold text-slate-500 mt-1 uppercase">{{ $item->quantity }}шт</p>
                    </div>
                </div>
            @endforeach
            
            {{-- Итог --}}
            <div class="bg-white/[0.03] p-5 flex justify-between items-center border-t border-white/5">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Итого к оплате</span>
                <span class="text-xl font-display font-black text-accent italic">{{ number_format($order->total_price, 0, ',', ' ') }} ₽</span>
            </div>
        </div>
    </div>

    {{-- Информация о доставке --}}
    <div class="mb-8">
        <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-3 ml-2">Детали доставки</h2>
        <div class="p-5 bg-white/[0.02] border border-white/5 rounded-[28px] space-y-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-user text-accent text-xs mt-1 w-4"></i>
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase">Получатель</p>
                    <p class="text-sm text-white font-medium">{{ $order->name }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-phone text-accent text-xs mt-1 w-4"></i>
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase">Телефон</p>
                    <p class="text-sm text-white font-medium">{{ $order->phone }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <i class="fas fa-map-marker-alt text-accent text-xs mt-1 w-4"></i>
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase">Адрес</p>
                    <p class="text-sm text-white font-medium">{{ $order->address }}</p>
                </div>
            </div>
            @if($order->description)
            <div class="flex items-start gap-3">
                <i class="fas fa-comment text-slate-500 text-xs mt-1 w-4"></i>
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase">Комментарий</p>
                    <p class="text-sm text-slate-300 italic">«{{ $order->description }}»</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Кнопка Повторить заказ --}}
<div class="px-2 mb-3">
    <form action="{{ route('order.reorder', $order->id) }}" method="POST">
        @csrf
        <button type="submit" class="group relative w-full flex items-center justify-center gap-3 py-5 bg-accent rounded-2xl shadow-[0_15px_35px_rgba(255,77,0,0.3)] transition-all active:scale-95 overflow-hidden">
            {{-- Эффект свечения при наведении --}}
            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            
            <i class="fas fa-redo-alt text-white text-sm group-hover:rotate-180 transition-transform duration-500"></i>
            <span class="font-display font-black text-white text-xs uppercase tracking-widest">Повторить заказ</span>
        </button>
    </form>
</div>

    {{-- Кнопка назад --}}
    <div class="px-2">
        <a href="{{ route('my.orders') }}" class="flex items-center justify-center gap-2 py-4 bg-white/5 border border-white/10 rounded-2xl text-slate-400 font-bold text-xs uppercase tracking-widest hover:text-accent hover:border-accent/30 transition-all">
            <i class="fas fa-arrow-left text-[10px]"></i> Назад к списку
        </a>
    </div>

</div>

{{-- Улучшенный скрипт копирования --}}
<script>
function copyOrderItems() {
    const items = document.querySelectorAll('.order-item');
    let text = 'Заказ №{{ $order->id }}\n----------\n';

    items.forEach(item => {
        text += `${item.dataset.name} — ${item.dataset.qty}шт.\n`;
    });
    
    navigator.clipboard.writeText(text).then(() => {
        // Заменяем alert на более современное уведомление, если нужно, 
        // но оставим для простоты логики
        alert('Заказ скопирован в буфер обмена');
    });
}
</script>

<style>
    .font-display { font-family: 'Unbounded', sans-serif; }
</style>

@endsection