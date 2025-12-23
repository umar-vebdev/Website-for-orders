@extends('layouts.front')

@section('title', 'Корзина')

@section('content')

<h1 class="text-2xl md:text-3xl font-semibold mb-2">
    Корзина
</h1>

<div class="w-full overflow-x-hidden px-2">

    @if(count($cart) === 0)
        <div class="text-slate-400 text-center mt-10 px-2">
            Ваша корзина пуста
        </div>
    @else

    {{-- Контейнер карточек с фиксированной высотой и скроллом --}}
    <div class="flex flex-col gap-2 mb-4 px-0 max-h-[60vh] overflow-y-auto">
        @foreach($cart as $id => $item)
            <div
                class="flex items-center justify-between gap-2 p-2 rounded-2xl
                       bg-[#020617]/80 border border-slate-800
                       hover:bg-[#020617] transition w-full"
            >
                {{-- Фото + информация --}}
                <div class="flex items-center gap-2 min-w-0 flex-1">
                    <img
                        src="{{ asset('storage/' . $item['photo']) }}"
                        alt="{{ $item['name'] }}"
                        class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-xl flex-shrink-0"
                    >
                    <div class="flex flex-col justify-center min-w-0">
                        <h2 class="text-base md:text-lg font-medium truncate">
                            {{ $item['name'] }}
                        </h2>
                        <div class="flex flex-col mt-1 text-sm text-slate-400">
                            <span>{{ $item['weight'] }} г</span>
                            <span class="text-white font-semibold">{{ number_format($item['price'],0,',',' ') }} ₽</span>
                        </div>
                    </div>
                </div>

                {{-- Счетчик + удалить (вертикально, одинаковая ширина) --}}
                <div class="flex flex-col items-center gap-1 flex-shrink-0">
                    {{-- Горизонтальный счетчик --}}
                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center w-24 bg-[#020617] border border-slate-700 rounded-xl overflow-hidden">
                        @csrf
                        @method('POST')
                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                            class="w-8 h-8 flex items-center justify-center text-white bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 transition">−</button>
                        <input type="text" value="{{ $item['quantity'] }}" readonly class="w-8 text-center bg-transparent text-white text-sm">
                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                            class="w-8 h-8 flex items-center justify-center text-white bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 transition">+</button>
                    </form>

                    {{-- Удалить --}}
                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="w-24">
                        @csrf
                        @method('DELETE')
                        <button class="w-full h-8 flex items-center justify-center bg-red-600/20 hover:bg-red-600/40 text-red-400 rounded-xl transition" title="Удалить">
                            <i class="fa-solid fa-trash text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Кнопки после контейнера --}}
    <div class="flex gap-2 mb-4 px-0">
        <form action="{{ route('cart.clear') }}" method="POST" class="flex-1">
            @csrf
            <button type="submit"
                class="w-full py-2 bg-gradient-to-r from-red-600 to-red-800 hover:from-red-500 hover:to-red-700 text-white text-base sm:text-lg font-medium rounded-xl shadow transition">
                Очистить корзину
            </button>
        </form>

        <a href="{{ route('checkout.form') }}" class="flex-1 py-2 flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 text-white text-base sm:text-lg font-medium rounded-xl shadow transition">
            Оформить заказ
        </a>
    </div>

    @endif

</div>

@endsection
