@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Корзина</h1>

    @if(empty($cart))
        <p>Ваша корзина пуста.</p>
    @else
        <table class="w-full bg-white shadow rounded-lg overflow-hidden mb-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Фото</th>
                    <th class="p-2 text-left">Название</th>
                    <th class="p-2 text-left">Цена</th>
                    <th class="p-2 text-left">Вес</th>
                    <th class="p-2 text-left">Количество</th>
                    <th class="p-2 text-left">Сумма</th>
                    <th class="p-2 text-left">Действие</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $dishId => $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <tr class="border-t">
                        <td class="p-2">
                            @if($item['photo'])
                                <img src="{{ asset('storage/'.$item['photo']) }}" class="w-16 h-16 object-cover rounded">
                            @endif
                        </td>
                        <td class="p-2">{{ $item['name'] }}</td>
                        <td class="p-2">{{ $item['price'] }} ₽</td>
                        <td class="p-2">{{ $item['weight'] }} г</td>
                        <td class="p-2">{{ $item['quantity'] }}</td>
                        <td class="p-2">{{ $item['price'] * $item['quantity'] }} ₽</td>
                        <td class="p-2">
                            <form action="{{ route('cart.remove', $dishId) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 hover:underline">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="font-bold text-right mb-4">Итого: {{ $total }} ₽</div>

        <a href="{{ route('checkout.form') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Оформить заказ</a>
    @endif
    <form action="{{ route('cart.clear') }}" method="POST">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
            Очистить корзину
        </button>
    </form>
    
</div>
@endsection
