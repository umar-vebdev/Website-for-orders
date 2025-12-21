@extends('layouts.admin')

@section('title', 'Все заказы')

@section('content')
<div class="container mx-auto p-4 max-w-md sm:max-w-xl md:max-w-3xl">

    @if($orders->isEmpty())
        <p class="text-gray-400">Заказов пока нет.</p>
    @else
        <div class="space-y-3">
            @foreach($orders as $order)
                @php
                    // Цвета статусов
                    $statusColors = [
                        'new' => 'bg-blue-600 text-white',
                        'processing' => 'bg-yellow-500 text-black',
                        'completed' => 'bg-green-600 text-white',
                        'cancelled' => 'bg-red-600 text-white',
                    ];
                @endphp

                <div class="flex flex-wrap items-center gap-2 p-3 bg-[#020617]/80 border border-slate-800 rounded-2xl hover:bg-[#020617] transition w-full overflow-hidden">

                    {{-- Иконка или фото --}}
                    <div class="w-14 h-14 flex-shrink-0 flex items-center justify-center bg-gray-800/50 rounded-xl text-white font-bold text-lg">
                        {{ $order->id }}
                    </div>

                    {{-- Информация --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="text-white font-semibold truncate text-sm sm:text-base">{{ $order->name }}</span>
                            {{-- Цветной бейдж статуса --}}
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-500 text-white' }}">
                                {{ \App\Models\Order::getStatuses()[$order->status] }}
                            </span>
                        </div>
                        <div class="text-xs sm:text-sm text-slate-400 truncate">
                            {{ $order->phone }} • {{ $order->created_at->format('d.m.Y H:i') }}
                        </div>
                        <div class="text-sm sm:text-lg font-semibold mt-1">{{ $order->total_price }} ₽</div>
                    </div>

                    {{-- Действия --}}
                    <div class="flex flex-wrap items-center gap-1 mt-2 sm:mt-0">
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="flex items-center gap-1 flex-shrink-0">
                            @csrf
                            <!-- если маршрут использует PUT -->
                            <!-- @method('PUT') -->
                        
                            <select name="status" class="bg-gray-800 text-white text-xs sm:text-sm rounded px-2 py-1 border border-slate-700">
                                @foreach(\App\Models\Order::getStatuses() as $key => $label)
                                    <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        
                            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white text-xs sm:text-sm rounded px-2 py-1 transition">
                                Сохранить
                            </button>
                        </form>
                        

                        <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-gray-700/50 hover:bg-gray-700 text-blue-400 hover:text-blue-300 text-xs sm:text-sm rounded px-2 py-1 transition flex-shrink-0">
                            Просмотр
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
