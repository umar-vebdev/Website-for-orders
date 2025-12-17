@extends('layouts.app')

@section('title', 'Меню')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-white">Меню</h1>

<div class="space-y-6 bg-gray-900 p-4 rounded-lg">
    @foreach($dishes as $dish)
        <div class="flex items-center gap-4 p-4 bg-gray-800 border border-gray-700 rounded-lg shadow-md">

            <!-- Фото блюда -->
            <img src="{{ asset('storage/' . $dish->photo_path) }}"
                 alt="{{ $dish->name }}"
                 class="w-24 h-24 object-cover rounded-lg">

            <!-- Информация о блюде -->
            <div class="flex-1">
                <div class="font-bold text-xl text-white">{{ $dish->name }}</div>
                <div class="text-blue-400 font-semibold">{{ $dish->price }} ₽</div>
                <div class="text-gray-400">{{ $dish->weight }} г</div>
            </div>

            <!-- Счётчик -->
            <div class="flex items-center gap-2">
                <button class="px-3 py-1 bg-gray-700 text-white rounded-l hover:bg-blue-500 transition" onclick="decreaseQty({{ $dish->id }})">-</button>
                <input type="text" id="qty-{{ $dish->id }}" value="1" class="w-12 text-center bg-gray-900 border border-gray-600 text-white rounded-none">
                <button class="px-3 py-1 bg-gray-700 text-white rounded-r hover:bg-blue-500 transition" onclick="increaseQty({{ $dish->id }})">+</button>
            </div>

            <!-- Добавить в корзину -->
            <form action="{{ route('cart.add', $dish->id) }}" method="POST" class="ml-4">
                @csrf
                <input type="hidden" name="quantity" id="form-qty-{{ $dish->id }}" value="1">
                <button class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded hover:from-blue-600 hover:to-blue-800 transition">
                    Добавить
                </button>
            </form>

        </div>
    @endforeach
</div>

<!-- JS для счётчиков -->
<script>
function increaseQty(id) {
    let input = document.getElementById('qty-' + id);
    let formInput = document.getElementById('form-qty-' + id);
    input.value = parseInt(input.value) + 1;
    formInput.value = input.value;
}

function decreaseQty(id) {
    let input = document.getElementById('qty-' + id);
    let formInput = document.getElementById('form-qty-' + id);
    if(parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        formInput.value = input.value;
    }
}
</script>
@endsection
