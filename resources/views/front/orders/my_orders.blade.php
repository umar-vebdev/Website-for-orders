@extends('layouts.front')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl md:text-3xl font-bold mb-6 text-white">
        Мои заказы
    </h1>

    @if($orders->isEmpty())
        <div class="text-slate-400 text-center mt-10">
            У вас пока нет заказов.
        </div>
    @else
        <ul class="flex flex-col gap-3">
            @foreach($orders as $order)
                <li>
                    <a href="{{ route('my.orders.show', $order->id) }}"
                       class="block p-4 rounded-2xl bg-[#020617]/80 border border-slate-800
                              hover:bg-[#020617] transition flex justify-between items-center">

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
                                     @endif
                                     ">
                            @if($order->status === 'new')
                                Новый
                            @elseif($order->status === 'processing')
                                В обработке
                            @elseif($order->status === 'done')
                                Завершён
                            @elseif($order->status === 'cancelled')
                                Отменён
                            @else
                                Новый
                            @endif
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

</div>
@endsection
