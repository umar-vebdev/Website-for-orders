@extends('layouts.front')

@section('title', 'Заказ №'.$order->id)

@section('content')
{{-- Дата заказа --}}
<div class="mb-4 text-slate-400 text-sm">
    Дата: {{ $order->created_at->format('d.m.Y H:i') }}
</div>

<div class="container mx-auto p-4 max-w-md sm:max-w-lg md:max-w-2xl">

    {{-- Позиции заказа --}}
    <h2 class="font-semibold text-white mb-2">Позиции заказа</h2>
    <div class="space-y-2">
        @foreach($order->items as $item)
            <div class="flex justify-between items-center p-3 bg-[#020617]/80 border border-slate-800 rounded-2xl hover:bg-[#020617] transition">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <img src="{{ asset('storage/' . $item->dish->photo_path) }}" 
                         alt="{{ $item->dish->name }}" 
                         class="w-16 h-16 object-cover rounded-xl flex-shrink-0">

                    <div class="min-w-0">
                        <div class="text-white font-semibold truncate">{{ $item->dish->name }}</div>
                        <div class="text-slate-400 text-xs sm:text-sm">{{ $item->weight }} г × {{ $item->quantity }}</div>
                    </div>
                </div>

                <div class="text-white font-semibold ml-4">
                    {{ $item->price * $item->quantity }} ₽
                </div>
            </div>
        @endforeach
    </div>

    {{-- Итог --}}
    <div class="text-right font-bold text-lg text-white mt-3 mb-4">
        Итог: {{ $order->total_price }} ₽
    </div>

    {{-- Контакты --}}
    <h2 class="font-semibold text-white mb-2">Контакты клиента</h2>
    <div class="space-y-1 mb-4 text-slate-300 text-sm bg-[#020617]/80 border border-slate-800 p-4 rounded-2xl">
        <div><strong>Имя:</strong> {{ $order->name }}</div>
        <div><strong>Телефон:</strong> {{ $order->phone }}</div>
        <div><strong>Адрес:</strong> {{ $order->address }}</div>
        @if($order->description)
            <div><strong>Комментарий:</strong> {{ $order->description }}</div>
        @endif
    </div>

    {{-- Статус заказа (если хочешь, можно добавить, как у админа) --}}
    <h2 class="font-semibold text-white mb-2">Статус заказа</h2>
    @php
        $statusColors = [
            'new' => 'bg-blue-600 text-white',
            'processing' => 'bg-yellow-500 text-black',
            'completed' => 'bg-green-600 text-white',
            'cancelled' => 'bg-red-600 text-white',
        ];
    @endphp
    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$order->status] ?? 'bg-gray-500 text-white' }}">
        {{ \App\Models\Order::getStatuses()[$order->status] }}
    </span>

    {{-- Ссылка назад --}}
    <div class="mt-6">
        <a href="{{ route('my.orders') }}" class="text-blue-400 hover:text-blue-300 transition">
            ← Назад к заказам
        </a>
    </div>

</div>
@endsection
