<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Общепит')</title>

    <!-- Tailwind через CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 font-sans">

    <!-- Навигация -->
    <nav class="bg-gray-800 shadow-md">
        <div class="container mx-auto flex justify-between items-center p-4">
            <div class="text-xl font-bold text-white">Общепит</div>
            <ul class="flex gap-6">
                <li><a href="{{ route('menu') }}" class="hover:text-blue-400 transition">Меню</a></li>
                <li><a href="{{ route('cart.index') }}" class="hover:text-blue-400 transition">Корзина</a></li>
                <li><a href="{{ route('my.orders') }}" class="hover:text-blue-400 transition">Мои заказы</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mx-auto p-4">
        @yield('content')
    </main>

</body>
</html>
