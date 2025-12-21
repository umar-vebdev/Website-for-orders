@extends('layouts.front')

@section('title', 'Корзина')

@section('content')

<h1 class="text-2xl md:text-3xl font-semibold mb-6">
    Корзина
</h1>

@if(count($cart) === 0)
    <div class="text-slate-400 text-center mt-10">
        Ваша корзина пуста
    </div>
@else

<div class="flex flex-col gap-3 mb-24">

    @foreach($cart as $id => $item)
        <div
            class="flex items-center gap-4 p-3 rounded-2xl
                   bg-[#020617]/80 border border-slate-800
                   hover:bg-[#020617] transition"
        >

            {{-- Фото --}}
            <img
                src="{{ asset('storage/' . $item['photo']) }}"
                alt="{{ $item['name'] }}"
                class="w-20 h-20 md:w-24 md:h-24 object-cover rounded-xl flex-shrink-0"
            >

            {{-- Инфо --}}
            <div class="flex-1 min-w-0">
                <h2 class="text-lg md:text-xl font-medium truncate">
                    {{ $item['name'] }}
                </h2>

                <div class="text-sm text-slate-400 mt-1">
                    {{ $item['weight'] }} г
                </div>

                <div class="mt-1 text-lg font-semibold text-white">
                    {{ number_format($item['price'], 0, ',', ' ') }} ₽
                </div>
            </div>

            {{-- Управление количеством и удаление --}}
            <div class="flex items-center gap-1">

                {{-- Кол-во --}}
                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center bg-[#020617] border border-slate-700 rounded-xl overflow-hidden">
                    @csrf
                    @method('POST')

                    <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                        class="w-8 h-8 flex items-center justify-center text-white bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 transition">
                        −
                    </button>

                    <input type="text" value="{{ $item['quantity'] }}" readonly class="w-8 text-center bg-transparent text-white text-sm">

                    <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                        class="w-8 h-8 flex items-center justify-center text-white bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 transition">
                        +
                    </button>
                </form>

                {{-- Удалить --}}
                <form action="{{ route('cart.remove', $id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="w-8 h-8 flex items-center justify-center bg-red-600/20 hover:bg-red-600/40 text-red-400 rounded-xl transition" title="Удалить">
                        <i class="fa-solid fa-trash text-sm"></i>
                    </button>
                </form>

            </div>
        </div>
    @endforeach

</div>

{{-- Фиксированная кнопка оформления --}}
<div class="fixed bottom-4 right-4 z-50">
    <a href="{{ route('checkout.form') }}"
       class="px-6 py-3 flex items-center justify-center
              bg-gradient-to-r from-blue-600 to-blue-800
              hover:from-blue-500 hover:to-blue-700
              text-white text-lg font-medium rounded-2xl shadow-lg transition"
       title="Оформить заказ">
        Оформить заказ
    </a>
</div>

@endif

@endsection
