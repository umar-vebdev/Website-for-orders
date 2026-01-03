@extends('layouts.admin')

@section('title', 'Заказ №'.$order->id)

@section('content')
<div class="container mx-auto p-4 max-w-md sm:max-w-lg md:max-w-2xl">

    <div class="mb-4 text-slate-400 text-sm">Дата: {{ $order->created_at->format('d.m.Y H:i') }}</div>

    {{-- Кнопка для экспорта --}}
    <div class="mb-4">
        <a href="{{ route('admin.orders.export', $order->id) }}" 
           class="inline-block px-4 py-2 bg-green-600 hover:bg-green-500 text-white rounded shadow-md transition">
            Скачать Excel
        </a>
    </div>

    {{-- Позиции заказа --}}
    <h2 class="font-semibold text-white mb-2">Позиции заказа</h2>
    <div class="space-y-2">
        @foreach($order->items as $item)
            <div class="flex justify-between items-center p-3 bg-[#020617]/80 border border-slate-800 rounded-2xl hover:bg-[#020617] transition">
                <div class="flex-1 min-w-0">
                    <div class="text-white font-semibold truncate">{{ $item->dish->name }}</div>
                    <div class="text-slate-400 text-xs sm:text-sm">{{ $item->weight }} г × {{ $item->quantity }}</div>
                </div>
                <div class="text-white font-semibold ml-4">
                    {{ $item->price * $item->quantity }} ₽
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-right font-bold text-lg text-white mt-3 mb-4">
        Итог: {{ $order->total_price }} ₽
    </div>

    {{-- Контакты --}}
    <h2 class="font-semibold text-white mb-2">Контакты клиента</h2>
    <div class="space-y-1 mb-4 text-slate-300 text-sm">
        <div><strong>Имя:</strong> {{ $order->name }}</div>
        <div><strong>Телефон:</strong> {{ $order->phone }}</div>
        <div><strong>Адрес:</strong> {{ $order->address }}</div>
        @if($order->description)
            <div><strong>Комментарий:</strong> {{ $order->description }}</div>
        @endif
    </div>

    {{-- Статус заказа --}}
    <h2 class="font-semibold text-white mb-2">Статус заказа</h2>
    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex gap-2 mb-4">
        @csrf
        <select name="status" class="flex-1 bg-gray-800 text-white border border-slate-700 rounded px-2 py-1">
            @foreach(\App\Models\Order::getStatuses() as $key => $label)
                <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition">Обновить</button>
    </form>

     {{-- Форма удаления заказа --}}
     <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" 
            class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition">
            Удалить
        </button>
    </form>

    <a href="{{ route('admin.orders') }}" class="text-blue-400 hover:text-blue-300 text-sm">&laquo; Назад к списку заказов</a>

</div>
@endsection
