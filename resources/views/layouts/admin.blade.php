<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title') – Панель админа</title>

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
<body class="flex min-h-screen bg-[#020617] text-gray-100">

<!-- Бургер -->
<button id="burgerBtn" class="fixed top-4 right-4 z-50 p-2 bg-gray-800/90 text-gray-100 rounded-md md:hidden transition">
    <i class="fas fa-bars fa-lg"></i>
</button>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-[#020617] text-gray-100 transform -translate-x-full md:translate-x-0 transition-transform z-40 shadow-lg">
    <div class="p-6 text-2xl font-bold border-b border-gray-700 flex justify-between items-center">
        Админка
        <button id="closeSidebar" class="md:hidden p-1 text-gray-100"><i class="fas fa-times"></i></button>
    </div>

    <nav class="p-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-800/70 transition"><i class="fas fa-home"></i> Панель</a>
        <a href="{{ route('admin.dishes') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-800/70 transition"><i class="fas fa-utensils"></i> Блюда</a>
        <a href="{{ route('admin.orders') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-800/70 transition"><i class="fas fa-receipt"></i> Заказы</a>
        <a href="{{ route('admin.register') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-800/70 transition"><i class="fas fa-user-plus"></i> Добавить админа</a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 p-2 rounded hover:bg-red-700 transition text-red-400">
                <i class="fas fa-sign-out-alt"></i> Выйти
            </button>
        </form>
    </nav>
</aside>

<!-- Main content -->
<div id="mainContent" class="flex-1 p-6 md:ml-64 transition-all">
    <h1 class="text-2xl font-bold mb-4">@yield('title')</h1>
    @yield('content')
</div>

<script>
const burgerBtn = document.getElementById('burgerBtn');
const sidebar = document.getElementById('sidebar');
const closeSidebar = document.getElementById('closeSidebar');

burgerBtn.addEventListener('click', () => {
    sidebar.classList.remove('-translate-x-full');
    burgerBtn.classList.add('hidden');
});

closeSidebar.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    burgerBtn.classList.remove('hidden');
});
</script>

</body>
</html>

@vite('resources/js/admin.js')
