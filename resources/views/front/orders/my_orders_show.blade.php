@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Заказ №{{ $order->id }}</h1>
    <div class="mb-4 text-gray-600">{{ $order->created_at->format('d.m.Y H:i') }}</div>

    @php $total = 0; @endphp
    @foreach($order->items as $item)
        @php $total += $item->price * $item->quantity; @endphp
        <div class="flex items-center justify-between mb-2 p-2 bg-white rounded shadow-sm">
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/' . $item->dish->photo_path) }}" alt="{{ $item->dish->name }}" class="w-16 h-16 object-cover rounded">
                <div>
                    <div class="font-semibold">{{ $item->dish->name }}</div>
                    <div class="text-gray-600">{{ $item->price }} ₽</div>
                </div>
            </div>
            <div class="font-semibold">{{ $item->quantity }} шт</div>
        </div>
    @endforeach

    <div class="mt-2 font-bold text-right text-lg">
        Итог: {{ $total }} ₽
    </div>

    <div class="mt-2 text-gray-700 text-sm">
        <div><strong>Имя:</strong> {{ $order->name }}</div>
        <div><strong>Телефон:</strong> {{ $order->phone }}</div>
        <div><strong>Адрес:</strong> {{ $order->address }}</div>
    </div>

    <div class="mt-4">
        <a href="{{ route('my.orders') }}" class="text-blue-500 hover:underline">&laquo; Назад к списку заказов</a>
    </div>
</div>
@endsection
