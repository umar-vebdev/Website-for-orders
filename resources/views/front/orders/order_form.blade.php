@extends('layouts.front')

@section('title', 'Оформление заказа')

@section('content')

<h1 class="text-2xl md:text-3xl font-semibold mb-6">
    Оформление заказа
</h1>

<div class="max-w-md mx-auto p-6 bg-gray-900 rounded-xl shadow-md mt-6">

    <form
        action="{{ route('checkout.store') }}"
        method="POST"
        class="space-y-4"
    >
        @csrf

        {{-- Имя --}}
        <div>
            <label class="block mb-1 text-gray-300">Имя</label>
            <input
                type="text"
                name="name"
                required
                class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        {{-- Телефон --}}
        <div>
            <label class="block mb-1 text-gray-300">Телефон</label>
            <input
                type="number"
                name="phone"
                id="phone"
                required
                class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="+7"
            >
        </div>

        {{-- Адрес --}}
        <div>
            <label class="block mb-1 text-gray-300">Адрес</label>
            <input
                type="text"
                name="address"
                required
                class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        {{-- Комментарий --}}
        <div>
            <label class="block mb-1 text-gray-300">Комментарий к заказу</label>
            <textarea
                name="description"
                rows="4"
                placeholder="Например: без лука, позвонить перед доставкой"
                class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
            ></textarea>
        </div>

        {{-- Кнопка --}}
        <button
            type="submit"
            class="w-full py-2 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 text-white font-semibold rounded shadow-md transition"
        >
            Подтвердить заказ
        </button>

    </form>

</div>

@endsection
