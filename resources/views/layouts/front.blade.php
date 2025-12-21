<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') Delivery от печи</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
</head>

<body class="bg-[#020617] text-slate-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="sticky top-0 z-50 bg-[#020617] border-b border-slate-800">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">

        <a href="{{ route('menu') }}" class="text-xl font-semibold tracking-wide">
            Delivery от печи
        </a>

        <!-- Десктопное меню -->
        <nav class="hidden md:flex items-center gap-4 text-sm md:text-base">
            <a href="{{ route('menu') }}" class="text-slate-300 hover:text-white transition">Меню</a>
            <a href="{{ route('cart.index') }}" class="text-slate-300 hover:text-white transition">Корзина</a>
            <a href="{{ route('my.orders') }}" class="text-slate-300 hover:text-white transition">Мои заказы</a>
            <a href="{{ route('admin.login') }}" class="text-slate-300 hover:text-white transition font-semibold">
                Вход для админа
            </a>
        </nav>

        <!-- Кнопка бургер -->
        <button id="burger-btn" class="md:hidden text-slate-300 text-2xl focus:outline-none relative z-50">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<!-- Мобильное меню (выдвижное с левой стороны, всегда поверх) -->
<div id="mobile-menu" class="fixed top-0 left-0 h-full w-64 bg-[#020617] shadow-lg transform -translate-x-full transition-transform duration-300 z-50">
    <div class="p-6 flex justify-between items-center border-b border-slate-800">
        <span class="text-xl font-semibold text-white">Меню</span>
        <button id="close-menu" class="text-white text-2xl focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <nav class="flex flex-col gap-4 p-4">
        <a href="{{ route('menu') }}" class="text-slate-300 hover:text-white transition">Меню</a>
        <a href="{{ route('cart.index') }}" class="text-slate-300 hover:text-white transition">Корзина</a>
        <a href="{{ route('my.orders') }}" class="text-slate-300 hover:text-white transition">Мои заказы</a>
        <a href="{{ route('admin.login') }}" class="text-slate-300 hover:text-white transition font-semibold">Вход для админа</a>
    </nav>
</div>

<!-- Контент -->
<main class="flex-1 max-w-6xl mx-auto px-4 py-6">
    @yield('content')
</main>

<!-- Footer -->
<footer class="border-t border-slate-800 text-slate-500 text-sm text-center py-4">
    © {{ date('Y') }} Delivery от печи. Все права защищены.
</footer>


@stack('scripts')
<script>
    const burgerBtn = document.getElementById('burger-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeBtn = document.getElementById('close-menu');

    burgerBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('-translate-x-full');
    });

    closeBtn.addEventListener('click', () => {
        mobileMenu.classList.add('-translate-x-full');
    });

    // Закрытие по клику вне меню
    document.addEventListener('click', (e) => {
        if (!mobileMenu.contains(e.target) && !burgerBtn.contains(e.target)) {
            mobileMenu.classList.add('-translate-x-full');
        }
    });
</script>

</body>
</html>
