@extends('layouts.front')

@section('title', "Заказ №{$order->id}")

@section('content')

<div class="space-y-6">

    <h1 class="text-2xl md:text-3xl font-bold text-white">
        Заказ №{{ $order->id }}
    </h1>

    {{-- Контейнер для WebSocket --}}
    <div id="order-status-container"
         data-order-id="{{ $order->id }}"
         class="p-4 rounded-2xl bg-[#020617]/80 border border-slate-800">

        <div class="text-slate-400 text-sm mb-2">
            Статус заказа
        </div>

        <span id="status-label"
              class="px-3 py-1 rounded-xl font-medium
                 @if($order->status === 'new') bg-blue-600/30 text-blue-300
                 @elseif($order->status === 'processing') bg-yellow-600/30 text-yellow-300
                 @elseif($order->status === 'done') bg-green-600/30 text-green-300
                 @elseif($order->status === 'cancelled') bg-red-600/30 text-red-300
                 @else bg-blue-600/30 text-blue-300
                 @endif">
            {{ \App\Models\Order::getStatuses()[$order->status] ?? $order->status }}
        </span>
    </div>

    {{-- Информация по заказу --}}
    <div class="p-4 rounded-2xl bg-[#020617]/80 border border-slate-800 space-y-3">
        <div class="text-slate-300">
            Имя: <span class="text-white font-medium">{{ $order->name }}</span>
        </div>

        <div class="text-slate-300">
            Телефон: <span class="text-white font-medium">{{ $order->phone }}</span>
        </div>

        <div class="text-slate-300">
            Сумма: <span class="text-white font-medium">{{ $order->total_price }} ₽</span>
        </div>

        <div class="text-slate-300">
            Дата: <span class="text-white font-medium">{{ $order->created_at->format('d.m.Y H:i') }}</span>
        </div>
    </div>

</div>

@push('scripts')
    @vite(['resources/js/front.js'])
@endpush

@endsection
