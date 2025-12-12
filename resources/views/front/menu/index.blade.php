@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">

        <h1 class="text-2xl font-bold mb-4">Меню</h1>

        <div class="space-y-4">

            @foreach($dishes as $dish)
                <div class="flex items-center gap-4 p-4 bg-white border rounded shadow-sm">

                    <img src="{{ asset('storage/' . $dish->photo_path) }}"
                         alt="{{ $dish->name }}"
                         class="w-20 h-20 object-cover rounded">

                    <div class="flex-1">
                        <div class="font-bold text-lg">{{ $dish->name }}</div>
                        <div class="text-gray-600">{{ $dish->price }} ₽</div>
                        <div class="text-gray-500">{{ $dish->weight }} г</div>
                    </div>

                    <form action="{{ route('cart.add', $dish->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded">
                            Добавить
                        </button>
                    </form>

                </div>
            @endforeach

        </div>

    </div>
@endsection
