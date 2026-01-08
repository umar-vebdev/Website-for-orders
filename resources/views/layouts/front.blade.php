<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title') – Delivery от печи</title>

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

@vite(['resources/js/front.js'])
</head>

<body class="bg-[#020617] text-slate-100 min-h-screen flex flex-col">

<header class="sticky top-0 z-50 bg-[#020617] border-b border-slate-800">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="{{ route('menu') }}" class="text-xl font-semibold tracking-wide flex items-center gap-2">
            <i class="fas fa-pizza-slice"></i>
            <span>Delivery от печи</span>
        
            <img
                src="{{ asset('images/halal.png') }}"
                alt="Halal"
                class="w-7 h-7 object-contain"
            >
        </a>
        

        <nav class="hidden md:flex items-center gap-4 text-sm md:text-base">
            <a href="{{ route('menu') }}" class="flex items-center gap-1 text-slate-300 hover:text-white transition"><i class="fas fa-utensils"></i> Меню</a>
            <a href="{{ route('cart.index') }}" class="flex items-center gap-1 text-slate-300 hover:text-white transition"><i class="fas fa-shopping-cart"></i> Корзина</a>
            <a href="{{ route('my.orders') }}" class="flex items-center gap-1 text-slate-300 hover:text-white transition"><i class="fas fa-receipt"></i> Мои заказы</a>
            <a href="{{ route('admin.login') }}" class="flex items-center gap-1 text-slate-300 hover:text-white transition font-semibold"><i class="fas fa-user-shield"></i> Вход для админа</a>
        </nav>

        <button id="burger-btn" class="md:hidden text-slate-300 text-2xl focus:outline-none relative z-50">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<div id="mobile-menu" class="fixed top-0 left-0 h-full w-64 bg-[#020617] shadow-lg transform -translate-x-full transition-transform duration-300 z-50">
    <div class="p-6 flex justify-between items-center border-b border-slate-800">
        <span class="text-xl font-semibold text-white">Меню</span>
        <button id="close-menu" class="text-white text-2xl focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <nav class="flex flex-col gap-4 p-4">
        <a href="{{ route('menu') }}" class="flex items-center gap-2 text-slate-300 hover:text-white transition"><i class="fas fa-utensils"></i> Меню</a>
        <a href="{{ route('cart.index') }}" class="flex items-center gap-2 text-slate-300 hover:text-white transition"><i class="fas fa-shopping-cart"></i> Корзина</a>
        <a href="{{ route('my.orders') }}" class="flex items-center gap-2 text-slate-300 hover:text-white transition"><i class="fas fa-receipt"></i> Мои заказы</a>
        <a href="{{ route('admin.login') }}" class="flex items-center gap-2 text-slate-300 hover:text-white transition font-semibold"><i class="fas fa-user-shield"></i> Вход для админа</a>
    </nav>
</div>

<main class="flex-1 px-4 py-6">
    <div class="w-full">
        @yield('content')
    </div>
</main>

<footer class="border-t border-slate-800 text-slate-500 text-sm text-center py-4">
    © {{ date('Y') }} Delivery от печи. Все права защищены.
</footer>

@stack('scripts')

<script>
const burgerBtn = document.getElementById('burger-btn');
const mobileMenu = document.getElementById('mobile-menu');
const closeBtn = document.getElementById('close-menu');

burgerBtn.addEventListener('click', () => mobileMenu.classList.remove('-translate-x-full'));
closeBtn.addEventListener('click', () => mobileMenu.classList.add('-translate-x-full'));

document.addEventListener('click', e => {
    if (!mobileMenu.contains(e.target) && !burgerBtn.contains(e.target)) {
        mobileMenu.classList.add('-translate-x-full');
    }
});
</script>

</body>
</html>
