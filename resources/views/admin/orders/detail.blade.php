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

    <div class="font-bold text-right mb-4">
        Итог: {{ $order->total_price }} ₽
    </div>

    <h2 class="font-semibold mb-2">Контакты клиента</h2>
    <div class="mb-4">
        <div><strong>Имя:</strong> {{ $order->name }}</div>
        <div><strong>Телефон:</strong> {{ $order->phone }}</div>
        <div><strong>Адрес:</strong> {{ $order->address }}</div>
        @if($order->description)
            <div><strong>Комментарий:</strong> {{ $order->description }}</div>
        @endif
    </div>

    <h2 class="font-semibold mb-2">Статус заказа</h2>
    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mb-4">
        @csrf
        <select name="status" class="border p-2 rounded">
            @foreach(\App\Models\Order::getStatuses() as $key => $label)
                <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Обновить</button>
    </form>

    <a href="{{ route('admin.orders') }}" class="text-blue-500 hover:underline">&laquo; Назад к списку заказов</a>
</div>
@endsection
