@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Заказ №{{ $order->id }}</h1>
    <div class="mb-4 text-gray-600">Дата: {{ $order->created_at->format('d.m.Y H:i') }}</div>

    <h2 class="font-semibold mb-2">Позиции заказа</h2>
    <table class="w-full bg-white shadow rounded-lg overflow-hidden mb-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Блюдо</th>
                <th class="p-2 text-left">Цена</th>
                <th class="p-2 text-left">Вес</th>
                <th class="p-2 text-left">Количество</th>
                <th class="p-2 text-left">Сумма</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr class="border-t">
                <td class="p-2">{{ $item->dish->name }}</td>
                <td class="p-2">{{ $item->price }} ₽</td>
                <td class="p-2">{{ $item->weight }} г</td>
                <td class="p-2">{{ $item->quantity }}</td>
                <td class="p-2">{{ $item->price * $item->quantity }} ₽</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="font-bold text-right mb-4">Итого: {{ $order->total_price }} ₽</div>

    <a href="{{ route('my.orders') }}" class="text-blue-500 hover:underline">&laquo; Назад к списку заказов</a>
</div>
@endsection
