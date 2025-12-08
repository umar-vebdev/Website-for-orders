@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Добавить блюдо</h1>

    <form action="{{ route('admin.dishes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <input name="name" placeholder="Название" class="border p-2 w-full" required>
        <input name="price" placeholder="Цена" class="border p-2 w-full" required>
        <input name="weight" placeholder="Вес (г)" class="border p-2 w-full" required>
        <input type="file" name="image" class="border p-2 w-full">

        <button class="bg-blue-500 text-white px-4 py-2 rounded">Сохранить</button>
    </form>
</div>
@endsection
