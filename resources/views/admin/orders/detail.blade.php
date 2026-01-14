@extends('layouts.admin')

@section('title', 'Заказ №'.$order->id)

@section('content')
<div class="max-w-4xl mx-auto px-2 pb-10">
    
    {{-- Верхняя панель управления --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.orders') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> Назад к списку
        </a>
        
        {{-- Кнопка EXCEL (Максимально заметная) --}}
        <a href="{{ route('admin.orders.export', $order->id) }}" 
           class="group relative overflow-hidden px-5 py-3 bg-emerald-600 rounded-2xl shadow-[0_10px_25px_rgba(16,185,129,0.3)] hover:shadow-[0_15px_35px_rgba(16,185,129,0.5)] transition-all active:scale-95 flex items-center gap-3 border border-emerald-400/30">
            <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-file-excel text-white"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-[8px] font-black uppercase tracking-[0.2em] text-emerald-100 leading-none mb-1">Выгрузка в таблицу</span>
                <span class="text-xs font-bold text-white uppercase italic leading-none">Скачать Excel</span>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        {{-- ЛЕВАЯ КОЛОНКА: Позиции заказа --}}
        <div class="lg:col-span-7 space-y-4">
            <div class="glass-panel rounded-[32px] overflow-hidden">
                <div class="p-6 border-b border-white/5 bg-white/[0.01]">
                    <h2 class="font-display text-lg font-black uppercase italic tracking-tighter text-white">
                        Состав <span class="text-accent text-outline">заказа</span>
                    </h2>
                    <p class="text-[9px] text-slate-500 font-bold uppercase mt-1 tracking-widest">
                        Дата: {{ $order->created_at->format('d.m.Y H:i') }}
                    </p>
                </div>

                <div class="p-4 space-y-2">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center p-4 bg-night/50 border border-white/5 rounded-2xl hover:border-accent/30 transition-all group">
                            <div class="flex-1 min-w-0">
                                <div class="text-white font-bold text-xs uppercase italic truncate group-hover:text-accent transition-colors">
                                    {{ $item->dish->name }}
                                </div>
                                <div class="text-slate-500 text-[10px] font-black uppercase tracking-tighter mt-1">
                                    <span class="text-white/20 mx-1">/</span> {{ $item->quantity }} шт
                                </div>
                            </div>
                            <div class="text-right ml-4">
                                <div class="text-white font-display font-black text-sm italic">
                                    {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-6 bg-accent/[0.03] border-t border-white/5 flex justify-between items-center">
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest italic">Итоговая сумма:</span>
                    <div class="font-display text-2xl font-black text-white italic tracking-tighter">
                        {{ number_format($order->total_price, 0, ',', ' ') }} <span class="text-accent text-outline">₽</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ПРАВАЯ КОЛОНКА: Данные и Статус --}}
        <div class="lg:col-span-5 space-y-4">
            
            {{-- Контакты --}}
            <div class="glass-panel rounded-[32px] p-6 shadow-xl">
                <h3 class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-4 flex items-center gap-2 italic">
                    <i class="fas fa-map-marker-alt text-accent text-[8px]"></i> Доставка и связь
                </h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-[8px] font-black text-slate-600 uppercase block mb-1">Получатель:</span>
                        <p class="text-xs font-bold text-white uppercase italic tracking-tight">{{ $order->name }}</p>
                    </div>
                    <div>
                        <span class="text-[8px] font-black text-slate-600 uppercase block mb-1">Телефон:</span>
                        <a href="tel:{{ $order->phone }}" class="text-sm font-bold text-accent font-mono">{{ $order->phone }}</a>
                    </div>
                    <div>
                        <span class="text-[8px] font-black text-slate-600 uppercase block mb-1">Адрес:</span>
                        <p class="text-[11px] text-slate-300 font-medium leading-relaxed uppercase">{{ $order->address }}</p>
                    </div>
                    @if($order->description)
                        <div class="p-3 bg-white/[0.02] rounded-xl border border-white/5 italic text-[10px] text-slate-400 leading-snug">
                            {{ $order->description }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Управление --}}
            <div class="glass-panel rounded-[32px] p-6 bg-white/[0.01]">
                <h3 class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-4 italic">Обновить статус</h3>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-2">
                    @csrf
                    <select name="status" class="w-full bg-night border border-white/10 rounded-xl text-[10px] font-black text-white uppercase px-4 py-3 focus:outline-none focus:border-accent transition-all appearance-none cursor-pointer">
                        @foreach(\App\Models\Order::getStatuses() as $key => $label)
                            <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }} class="bg-night text-white">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full py-3 bg-accent rounded-xl text-[10px] font-black uppercase text-white hover:brightness-110 transition-all active:scale-95 shadow-lg shadow-accent/20">
                        Сохранить статус
                    </button>
                </form>
            </div>

            {{-- Удаление --}}
            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Вы уверены? Это удалит заказ навсегда.')" class="pt-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-3 border border-red-500/20 rounded-xl text-[9px] font-black uppercase tracking-widest text-red-500/40 hover:bg-red-500 hover:text-white transition-all">
                    Удалить заказ
                </button>
            </form>

        </div>
    </div>
</div>

<style>
    .text-outline {
        color: transparent;
        -webkit-text-stroke: 1px #FF4D00;
    }
</style>
@endsection