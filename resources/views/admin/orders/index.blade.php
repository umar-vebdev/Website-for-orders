@extends('layouts.admin')

@section('title', 'Заказы')

@section('content')

{{-- Заголовок и кнопка очистки --}}
<div class="mb-6 px-2 flex flex-col gap-4">
    <div class="flex justify-between items-center">
        <h1 class="font-display text-xl font-black tracking-tighter uppercase italic text-white leading-none">
            Лента <span class="text-accent text-outline">заказов</span>
        </h1>

        {{-- Заметная кнопка очистки --}}
        <form action="{{ route('admin.orders.destroyAll') }}" method="POST" onsubmit="return confirm('ВНИМАНИЕ! Это безвозвратно удалит ВСЕ заказы из базы. Продолжить?')">
            @csrf @method('DELETE')
            <button type="submit" class="flex items-center gap-2 px-3 py-2 rounded-xl border border-red-500/30 bg-red-500/5 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300">
                <i class="fas fa-trash-alt text-[10px]"></i>
                <span class="text-[9px] font-black uppercase tracking-widest">Очистить</span>
            </button>
        </form>
    </div>

    {{-- Фильтрация по статусам (Скролл-меню) --}}
    <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
        <a href="{{ route('admin.orders') }}" 
           class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest whitespace-nowrap transition-all 
           {{ !request('status') ? 'bg-accent text-white shadow-[0_5px_15px_rgba(255,77,0,0.3)]' : 'bg-white/5 text-slate-400 border border-white/5' }}">
           Все
        </a>
        @foreach(\App\Models\Order::getStatuses() as $key => $name)
            <a href="{{ route('admin.orders', ['status' => $key]) }}" 
               class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest whitespace-nowrap transition-all 
               {{ request('status') === $key ? 'bg-white text-black shadow-lg' : 'bg-white/5 text-slate-400 border border-white/5' }}">
               {{ $name }}
            </a>
        @endforeach
    </div>
</div>

<div id="orders-list" class="flex flex-col gap-3">
    @forelse($orders as $order)
        @php
            $statusStyles = [
                'new' => 'bg-blue-600',
                'processing' => 'bg-yellow-500 !text-black',
                'done' => 'bg-green-600',
                'cancelled' => 'bg-slate-700',
            ];
            $statusColor = $statusStyles[$order->status] ?? 'bg-slate-500';
        @endphp

        <div class="glass-panel rounded-2xl p-4 border-white/5 hover:border-accent/20 transition-all duration-300 relative overflow-hidden group">
            {{-- Полоска статуса сбоку --}}
            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $statusColor }}"></div>

            <div class="flex flex-col gap-3">
                
                {{-- ID, Имя и Статус --}}
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-3">
                        <span class="font-display font-black text-accent text-sm italic">#{{ $order->id }}</span>
                        <h3 class="text-sm font-bold text-white uppercase truncate max-w-[150px]">{{ $order->name }}</h3>
                    </div>
                    <div class="px-2 py-0.5 rounded-md {{ $statusColor }} text-[8px] font-black uppercase tracking-wider shadow-sm">
                        {{ \App\Models\Order::getStatuses()[$order->status] }}
                    </div>
                </div>

                {{-- Инфо и Действие --}}
                <div class="flex items-center justify-between border-t border-white/5 pt-3">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-phone text-slate-600 text-[8px]"></i>
                            <span class="text-[11px] text-slate-300 font-mono tracking-tighter">{{ $order->phone }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-slate-600 text-[8px]"></i>
                            <span class="text-[9px] text-slate-500 font-bold uppercase">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-[8px] text-slate-500 uppercase font-black mb-0.5">Сумма</p>
                            <span class="text-sm font-display font-black text-white italic tracking-tight">{{ number_format($order->total_price, 0, ',', ' ') }} ₽</span>
                        </div>
                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl bg-accent/10 text-accent group-hover:bg-accent group-hover:text-white transition-all duration-300 shadow-lg">
                            <i class="fas fa-eye text-[12px]"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    @empty
        <div class="py-20 flex flex-col items-center opacity-30">
            <i class="fas fa-inbox text-4xl mb-4"></i>
            <p class="text-center text-white text-[10px] font-black uppercase tracking-widest">Заказов в этой категории нет</p>
        </div>
    @endforelse
</div>

{{-- Пагинация, если есть --}}
@if(method_exists($orders, 'links'))
    <div class="mt-6 px-2">
        {{ $orders->appends(request()->query())->links() }}
    </div>
@endif

<style>
    .text-outline {
        color: transparent;
        -webkit-text-stroke: 1px #FF4D00;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

@endsection