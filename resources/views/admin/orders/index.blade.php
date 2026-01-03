@extends('layouts.admin')

@section('title', 'Все заказы')

@section('content')
<div class="w-full py-4 flex flex-col gap-4">

    {{-- Кнопка удаления всех заказов --}}
    <form action="{{ route('admin.orders.destroyAll') }}" method="POST" class="flex justify-end mb-4">
        @csrf
        @method('DELETE')
        <button type="submit" 
            class="py-2 px-4 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-xl shadow-md transition">
            Удалить все заказы
        </button>
    </form>
    

    {{-- Список заказов --}}
    <div id="orders-list" class="space-y-3">
        @forelse($orders as $order)
            @php
                $statusColors = [
                    'new' => 'bg-blue-600 text-white',
                    'processing' => 'bg-yellow-500 text-black',
                    'done' => 'bg-green-600 text-white',
                    'cancelled' => 'bg-red-600 text-white',
                ];
            @endphp

            <div class="order-card bg-[#020617]/80 border border-slate-800 rounded-2xl hover:bg-[#020617] transition p-3 w-full">
                {{-- Верх: иконка и информация --}}
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 flex items-center justify-center bg-gray-800/50 rounded-xl text-white font-bold text-lg flex-shrink-0">
                        {{ $order->id }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="text-white font-semibold truncate text-sm sm:text-base">{{ $order->name }}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-500 text-white' }}">
                                {{ \App\Models\Order::getStatuses()[$order->status] }}
                            </span>
                        </div>
                        <div class="text-xs sm:text-sm text-slate-400 truncate">
                            {{ $order->phone }} • {{ $order->created_at->format('d.m.Y H:i') }}
                        </div>
                        <div class="text-sm sm:text-lg font-semibold mt-1">{{ $order->total_price }} ₽</div>
                    </div>
                </div>

                {{-- Нижний блок действий --}}
                <div class="flex items-center gap-2 mt-3">
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="flex items-center gap-1">
                        @csrf
                        <select name="status" class="bg-gray-800 text-white text-xs rounded px-2 py-1 border border-slate-700">
                            @foreach(\App\Models\Order::getStatuses() as $key => $label)
                                <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white text-xs rounded px-2 py-1 transition">
                            Сохранить
                        </button>
                    </form>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-gray-700/50 hover:bg-gray-700 text-blue-400 hover:text-blue-300 text-xs rounded px-2 py-1 transition flex items-center justify-center">
                        Просмотр
                    </a>
                </div>
            </div>
        @empty
            <p id="no-orders-message" class="text-gray-400">Заказов пока нет.</p>
        @endforelse
    </div>
</div>
@endsection
