@extends('layouts.front')

@section('title', 'Мои заказы')

@section('content')

<h1 class="text-2xl md:text-3xl font-bold mb-6 text-white px-4">
    Мои заказы
</h1>

<div class="w-full flex flex-col gap-3 px-0"> {{-- родитель без ограничений ширины, gap для вертикальных отступов --}}
    @if($orders->isEmpty())
        <div class="text-slate-400 text-center mt-10">
            У вас пока нет заказов.
        </div>
    @else
        @foreach($orders as $order)
            <a href="{{ route('my.orders.show', $order->id) }}"
               class="flex justify-between items-center w-full p-4
                      bg-[#020617]/80 border border-slate-800
                      rounded-2xl hover:bg-[#020617] transition mx-0">
                <div>
                    <span class="font-medium text-white">Заказ №{{ $order->id }}</span>
                    <div class="text-sm text-slate-400 mt-1">
                        {{ $order->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>

                <span class="px-3 py-1 text-sm font-medium rounded-xl 
                             @if($order->status === 'new') bg-blue-600/30 text-blue-300
                             @elseif($order->status === 'processing') bg-yellow-600/30 text-yellow-300
                             @elseif($order->status === 'done') bg-green-600/30 text-green-300
                             @elseif($order->status === 'cancelled') bg-red-600/30 text-red-300
                             @else bg-blue-600/30 text-blue-300
                             @endif">
                    {{ \App\Models\Order::getStatuses()[$order->status] ?? 'Новый' }}
                </span>
            </a>
        @endforeach
    @endif
</div>

@endsection

