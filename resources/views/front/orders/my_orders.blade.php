@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Мои заказы</h1>

    @if($orders->isEmpty())
        <p>У вас пока нет заказов.</p>
    @else
        <ul class="space-y-2">
            @foreach($orders as $order)
                <li>
                    <a href="{{ route('my.orders.show', $order->id) }}" 
                        class="block p-4 bg-gray-100 rounded-lg shadow hover:bg-gray-200">
                        Заказ №{{ $order->id }} — {{ $order->created_at->format('d.m.Y H:i') }}
                        <span class="ml-2 px-2 py-1 bg-blue-200 text-blue-900 rounded text-sm">
                            @switch($order->status)
                                @case('new') Новый @break
                                @case('processing') В обработке @break
                                @case('completed') Завершён @break
                                @case('canceled') Отменён @break
                                @default Неизвестно
                            @endswitch
                        </span>
                        
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
