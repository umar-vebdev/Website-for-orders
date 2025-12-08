@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Редактировать блюдо</h1>

    <form action="{{ route('admin.dishes.update', $dish->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <input name="name" value="{{ $dish->name }}" class="border p-2 w-full" required>
        <input name="price" value="{{ $dish->price }}" class="border p-2 w-full" required>
        <input name="weight" value="{{ $dish->weight }}" class="border p-2 w-full" required>

        @if($dish->image)
            <img src="{{ asset('storage/' . $dish->image) }}" class="h-16">
        @endif

        <input type="file" name="image" class="border p-2 w-full">

        <button class="bg-blue-500 text-white px-4 py-2 rounded">Сохранить</button>
    </form>
</div>
@endsection
