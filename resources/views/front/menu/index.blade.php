@extends('layouts.front')

@section('title', 'Меню')

@section('content')

<h1 class="text-2xl md:text-3xl font-semibold mb-4">
    Меню
</h1>

<div id="menu-list" class="flex flex-col gap-2 w-full overflow-x-hidden">

    @foreach($dishes as $dish)
        <div
            class="flex items-center gap-2 p-2 rounded-xl
                   bg-[#020617]/90 border border-slate-800
                   hover:bg-[#020617] transition
                   w-full overflow-hidden"
            data-id="{{ $dish->id }}"
        >

            {{-- Фото --}}
            <img
                src="{{ asset('storage/' . $dish->photo_path) }}"
                alt="{{ $dish->name }}"
                class="w-16 h-16 sm:w-20 sm:h-20
                       object-cover rounded-lg flex-shrink-0"
            >

            {{-- Информация --}}
            <div class="flex-1 min-w-0">
                <h2 class="text-sm sm:text-base font-medium truncate">
                    {{ $dish->name }}
                </h2>
                <div class="text-xs sm:text-sm text-slate-400">
                    {{ $dish->weight }} г
                </div>
                <div class="mt-0.5 text-sm sm:text-base font-semibold text-white">
                    {{ number_format($dish->price, 0, ',', ' ') }} ₽
                </div>
            </div>

            {{-- Счётчик --}}
            <div
                class="flex items-center flex-shrink-0
                       bg-[#020617] border border-slate-700
                       rounded-xl overflow-hidden"
            >
                <button
                    class="w-7 h-7 flex items-center justify-center
                           text-white bg-gradient-to-br
                           from-blue-600 to-blue-800
                           hover:from-blue-500 hover:to-blue-700 transition"
                    onclick="decrement('{{ $dish->id }}')"
                >
                    −
                </button>

                <input
                    id="qty-{{ $dish->id }}"
                    value="0"
                    readonly
                    class="w-8 text-center bg-transparent
                           text-white text-xs focus:outline-none"
                >

                <button
                    class="w-7 h-7 flex items-center justify-center
                           text-white bg-gradient-to-br
                           from-blue-600 to-blue-800
                           hover:from-blue-500 hover:to-blue-700 transition"
                    onclick="increment('{{ $dish->id }}')"
                >
                    +
                </button>
            </div>

        </div>
    @endforeach

</div>

{{-- Фиксированная кнопка добавления --}}
<div class="fixed bottom-4 right-4 z-50">
    <button
        id="add-all-to-cart"
        class="w-12 h-12 flex items-center justify-center
               bg-gradient-to-r from-blue-600 to-blue-800
               hover:from-blue-500 hover:to-blue-700
               text-white text-2xl rounded-full shadow-lg transition"
        title="Добавить выбранные блюда в корзину"
    >
        <i class="fas fa-plus"></i>
    </button>
</div>

@push('scripts')
<script>
function increment(id) {
    const input = document.getElementById('qty-' + id);
    input.value = parseInt(input.value) + 1;
}

function decrement(id) {
    const input = document.getElementById('qty-' + id);
    if (parseInt(input.value) > 0) {
        input.value = parseInt(input.value) - 1;
    }
}

document.getElementById('add-all-to-cart').addEventListener('click', function () {
    const items = [];
    document.querySelectorAll('#menu-list > div').forEach(item => {
        const id = item.dataset.id;
        const qty = parseInt(document.getElementById('qty-' + id).value);
        if (qty > 0) {
            items.push({ dish_id: id, quantity: qty });
        }
    });

    if (!items.length) return;

    fetch('/cart/add-multiple', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ items })
    }).then(() => {
        window.location.href = '/cart';
    });
});
</script>
@endpush

@endsection
