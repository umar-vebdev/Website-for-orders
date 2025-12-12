@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Оформление заказа</h1>

    @if(session('error'))
        <p class="text-red-500 mb-2">{{ session('error') }}</p>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold mb-1">Имя</label>
            <input type="text" name="name" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Телефон</label>
            <input type="text" name="phone" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Адрес</label>
            <input type="text" name="address" class="border p-2 w-full" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Отправить заказ</button>
    </form>
</div>
@endsection
