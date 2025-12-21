@extends('layouts.front')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <h1 class="text-2xl md:text-3xl font-semibold mb-2">
        Заказ №{{ $order->id }}
    </h1>

    <div class="text-slate-400 mb-6">
        {{ $order->created_at->format('d.m.Y H:i') }}
    </div>

    @php $total = 0; @endphp

    <div class="flex flex-col gap-3 mb-6">
        @foreach($order->items as $item)
            @php $total += $item->price * $item->quantity; @endphp

            <div class="flex items-center gap-4 p-4 rounded-2xl
                        bg-[#020617]/80 border border-slate-800">

                <img
                    src="{{ asset('storage/' . $item->dish->photo_path) }}"
                    alt="{{ $item->dish->name }}"
                    class="w-20 h-20 object-cover rounded-xl"
                >

                <div class="flex-1">
                    <div class="font-medium text-lg">
                        {{ $item->dish->name }}
                    </div>
                    <div class="text-slate-400 text-sm">
                        {{ number_format($item->price, 0, ',', ' ') }} сум
                    </div>
                </div>

                <div class="text-slate-300 font-medium">
                    × {{ $item->quantity }}
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-between items-center mb-6">
        <span class="text-lg text-slate-300">Итого</span>
        <span class="text-2xl font-semibold">
            {{ number_format($total, 0, ',', ' ') }} ₽
        </span>
    </div>

    <div class="bg-[#020617]/80 border border-slate-800 rounded-2xl p-4 text-sm text-slate-300 space-y-2">
        <div><span class="text-slate-400">Имя:</span> {{ $order->name }}</div>
        <div><span class="text-slate-400">Телефон:</span> {{ $order->phone }}</div>
        <div><span class="text-slate-400">Адрес:</span> {{ $order->address }}</div>

        @if($order->description)
            <div>
                <span class="text-slate-400">Комментарий:</span>
                {{ $order->description }}
            </div>
        @endif
    </div>

    <div class="mt-6">
        <a
            href="{{ route('my.orders') }}"
            class="text-blue-400 hover:text-blue-300 transition"
        >
            ← Назад к заказам
        </a>
    </div>

</div>
@endsection

