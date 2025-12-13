@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Все заказы</h1>

    @if($orders->isEmpty())
        <p>Заказов пока нет.</p>
    @else
        <table class="w-full bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">#</th>
                    <th class="p-2 text-left">Клиент</th>
                    <th class="p-2 text-left">Телефон</th>
                    <th class="p-2 text-left">Дата</th>
                    <th class="p-2 text-left">Сумма</th>
                    <th class="p-2 text-left">Статус</th>
                    <th class="p-2 text-left">Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border-t">
                    <td class="p-2">{{ $order->id }}</td>
                    <td class="p-2">{{ $order->name }}</td>
                    <td class="p-2">{{ $order->phone }}</td>
                    <td class="p-2">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td class="p-2">{{ $order->total_price }} ₽</td>
                    <td class="p-2">
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                            @csrf
                            <select name="status">
                                @foreach(\App\Models\Order::getStatuses() as $key => $label)
                                    <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded ml-1">Сохранить</button>
                        </form>
                    </td>
                    <td class="p-2">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-500 hover:underline">Просмотр</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
