@extends('layouts.front')

@section('title', 'Меню')

@section('content')

<h1 class="text-2xl md:text-3xl font-semibold mb-4">Меню</h1>

<div id="menu-list" class="flex flex-col gap-2">

    @foreach($dishes as $dish)
    <div
        class="flex items-center gap-3 p-2 rounded-xl bg-[#020617]/90 border border-slate-800 hover:bg-[#020617] transition w-full"
        data-id="{{ $dish->id }}"
    >
        {{-- Фото --}}
        <img
            src="{{ asset('storage/' . $dish->photo_path) }}"
            alt="{{ $dish->name }}"
            class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-lg flex-shrink-0"
        >

        {{-- Информация --}}
        <div class="flex-1 flex flex-col justify-between min-w-0">
            <div>
                <h2 class="text-base sm:text-lg font-medium truncate">{{ $dish->name }}</h2>
                <div class="text-sm text-slate-400 mt-0.5">{{ $dish->weight }} г</div>
            </div>
            <div class="mt-1 text-base font-semibold text-white">{{ number_format($dish->price,0,',',' ') }} ₽</div>
        </div>

        {{-- Счётчик --}}
        <div class="flex items-center bg-[#020617] border border-slate-700 rounded-xl overflow-hidden">
            <button
                class="w-8 h-8 flex items-center justify-center text-white bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 transition text-lg"
                onclick="decrement('{{ $dish->id }}')"
            >−</button>
            <input
                id="qty-{{ $dish->id }}"
                value="0"
                readonly
                class="w-10 text-center bg-transparent text-white text-sm focus:outline-none"
            >
            <button
                class="w-8 h-8 flex items-center justify-center text-white bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 transition text-lg"
                onclick="increment('{{ $dish->id }}')"
            >+</button>
        </div>
    </div>
    @endforeach

</div>

{{-- Фиксированная кнопка "+" --}}
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
    if (parseInt(input.value) > 0) input.value = parseInt(input.value) - 1;
}
document.getElementById('add-all-to-cart').addEventListener('click', function () {
    const menuItems = document.querySelectorAll('#menu-list > div');
    const payload = [];
    menuItems.forEach(item => {
        const id = item.dataset.id;
        const quantity = parseInt(document.getElementById('qty-' + id).value);
        if (quantity > 0) payload.push({ dish_id: id, quantity });
    });
    if (!payload.length) return;
    fetch('/cart/add-multiple', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ items: payload })
    }).then(() => { window.location.href = '/cart'; });
});
</script>
@endpush

@endsection
