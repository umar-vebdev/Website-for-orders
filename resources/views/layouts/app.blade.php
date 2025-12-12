<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Общепит</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">

    <!-- Header -->
    <header class="bg-white shadow p-4 fixed top-0 w-full z-10">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="font-bold text-xl">Общепит</a>
            <a href="{{ route('cart.index') }}" class="bg-blue-500 text-white px-3 py-1 rounded">Корзина</a>
        </div>
    </header>

    <!-- Content -->
    <main class="pt-20 pb-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow p-4 text-center text-gray-500 fixed bottom-0 w-full">
        &copy; {{ date('Y') }} Общепит
    </footer>

</body>
</html>
