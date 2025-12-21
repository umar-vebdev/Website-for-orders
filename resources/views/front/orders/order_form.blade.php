@extends('layouts.front')

@section('title', 'Оформление заказа')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">

    <h1 class="text-2xl md:text-3xl font-semibold mb-6">
        Оформление заказа
    </h1>

    <form
        action="{{ route('checkout.store') }}"
        method="POST"
        class="space-y-4"
    >
        @csrf

        {{-- Имя --}}
        <div>
            <label class="block text-sm text-slate-400 mb-1">Имя</label>
            <input
                type="text"
                name="name"
                required
                class="w-full px-4 py-3 rounded-xl
                       bg-[#020617] border border-slate-700
                       text-white focus:outline-none focus:border-blue-600"
            >
        </div>

        {{-- Телефон --}}
        <div>
            <label class="block text-sm text-slate-400 mb-1">Телефон</label>
            <input
                type="text"
                name="phone"
                required
                class="w-full px-4 py-3 rounded-xl
                       bg-[#020617] border border-slate-700
                       text-white focus:outline-none focus:border-blue-600"
            >
        </div>

        {{-- Адрес --}}
        <div>
            <label class="block text-sm text-slate-400 mb-1">Адрес</label>
            <input
                type="text"
                name="address"
                required
                class="w-full px-4 py-3 rounded-xl
                       bg-[#020617] border border-slate-700
                       text-white focus:outline-none focus:border-blue-600"
            >
        </div>

        {{-- Комментарий --}}
        <div>
            <label class="block text-sm text-slate-400 mb-1">
                Комментарий к заказу
            </label>
            <textarea
                name="description"
                rows="4"
                placeholder="Например: без лука, позвонить перед доставкой"
                class="w-full px-4 py-3 rounded-xl
                       bg-[#020617] border border-slate-700
                       text-white placeholder-slate-500
                       focus:outline-none focus:border-blue-600 resize-none"
            ></textarea>
        </div>

        {{-- Кнопка --}}
        <button
            type="submit"
            class="w-full mt-4 py-4 rounded-xl
                   bg-gradient-to-r from-blue-600 to-blue-800
                   hover:from-blue-500 hover:to-blue-700
                   text-white font-medium transition"
        >
            Подтвердить заказ
        </button>

    </form>

</div>
@endsection
