@extends('layouts.front')

@section('title', 'Мои заказы')

@section('content')

<h1 class="text-2xl md:text-3xl font-bold text-white mb-6">
    Мои заказы
</h1>

@if($orders->isEmpty())
    <div class="text-slate-400">
        У вас пока нет заказов.
    </div>
@else
    <div class="space-y-4">
        @foreach($orders as $order)
        <a href="{{ route('my.orders.show', $order->id) }}"
           class="block p-4 rounded-2xl bg-[#020617]/80 border border-slate-800 hover:bg-slate-900/60"
           id="order-status-container-{{ $order->id }}"
           data-order-id="{{ $order->id }}">

            <div class="flex justify-between items-center">
                <div class="text-white font-medium">
                    Заказ №{{ $order->id }}
                </div>

                <div class="text-slate-400 text-sm">
                    {{ $order->created_at->format('d.m.Y H:i') }}
                </div>
            </div>

            <div class="mt-2 flex items-center gap-4">
                {{-- Сумма --}}
                <div class="text-slate-300">
                    Сумма: <span class="text-white">{{ $order->total_price }} ₽</span>
                </div>

                {{-- Статус --}}
                <span
                    class="status-label px-3 py-1 rounded-xl text-sm font-medium
                        @if($order->status === 'new') bg-blue-600/30 text-blue-300
                        @elseif($order->status === 'processing') bg-yellow-600/30 text-yellow-300
                        @elseif($order->status === 'done') bg-green-600/30 text-green-300
                        @elseif($order->status === 'cancelled') bg-red-600/30 text-red-300
                        @else bg-slate-600/30 text-slate-300
                        @endif"
                    id="status-label-{{ $order->id }}"
                    data-order-id="{{ $order->id }}">
                    {{ \App\Models\Order::getStatuses()[$order->status] ?? $order->status }}
                </span>
            </div>
        </a>
        @endforeach
    </div>
@endif
@push('scripts')
    @vite(['resources/js/front.js'])
@endpush

@endsection
