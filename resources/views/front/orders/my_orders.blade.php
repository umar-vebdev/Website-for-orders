@extends('layouts.front')

@section('title', 'Мои заказы')

@section('content')

<h1 class="text-2xl md:text-3xl font-bold text-white mb-6">
    Мои заказы
</h1>

@if(!$orders->isEmpty())
    <div class="flex justify-end mb-4">
        <form action="{{ route('my.orders.clear') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium transition">
                Удалить все заказы
            </button>
        </form>
    </div>
@endif


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
                @php
                    $statusClasses = match($order->status) {
                        'new' => 'bg-blue-600/30 text-blue-300',
                        'processing' => 'bg-yellow-600/30 text-yellow-300',
                        'done' => 'bg-green-600/30 text-green-300',
                        'cancelled' => 'bg-red-600/30 text-red-300',
                        default => 'bg-slate-600/30 text-slate-300',
                    };
                @endphp
                <span
                    class="status-label px-3 py-1 rounded-xl text-sm font-medium {{ $statusClasses }}"
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
