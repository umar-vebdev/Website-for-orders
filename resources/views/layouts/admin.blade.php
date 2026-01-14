<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') – Control Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;800&family=Unbounded:wght@700;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        accent: '#FF4D00', // Наш фирменный оранжевый
                        night: '#020617',
                    },
                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                        display: ['Unbounded', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        .sidebar-link.active {
            background: rgba(255, 77, 0, 0.1);
            color: #FF4D00;
            border-right: 3px solid #FF4D00;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        /* Кастомный скроллбар */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #020617; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #FF4D00; }
    </style>
</head>
<body class="min-h-screen bg-night text-gray-100 font-sans">

    <button id="burgerBtn" class="fixed top-4 right-4 z-[60] w-12 h-12 flex items-center justify-center bg-accent text-white rounded-2xl md:hidden shadow-lg shadow-accent/20">
        <i class="fas fa-bars"></i>
    </button>

    <aside id="sidebar" class="fixed top-0 left-0 h-full w-72 bg-night border-r border-white/5 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 flex flex-col">
        
        <div class="p-8 mb-4">
            <div class="font-display text-xl font-black uppercase italic tracking-tighter">
                Admin<span class="text-accent text-outline">Panel</span>
            </div>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em] mt-1">Management System</p>
        </div>

        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <div class="text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] mb-4 ml-4">Меню управления</div>
            
            <x-admin-nav-link href="{{ route('admin.dashboard') }}" icon="fa-chart-pie" label="Панель" />
            <x-admin-nav-link href="{{ route('admin.dishes') }}" icon="fa-utensils" label="Блюда" />
            <x-admin-nav-link href="{{ route('admin.orders') }}" icon="fa-receipt" label="Заказы" />
            
            <div class="pt-6 border-t border-white/5 mt-6">
                <div class="text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] mb-4 ml-4">Безопасность</div>
                <x-admin-nav-link href="{{ route('admin.register') }}" icon="fa-user-shield" label="Регистрация" />
            </div>
        </nav>

        <div class="p-6 border-t border-white/5 bg-white/[0.01]">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-3 py-3 rounded-2xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all font-bold text-xs uppercase tracking-widest">
                    <i class="fas fa-sign-out-alt"></i> Выйти
                </button>
            </form>
        </div>
    </aside>

    <main id="mainContent" class="flex-1 transition-all duration-300 md:ml-72 min-h-screen">
        
        <header class="h-20 border-b border-white/5 flex items-center justify-between px-8 sticky top-0 bg-night/80 backdrop-blur-md z-40">
            <div>
                <h2 class="font-display text-sm font-black uppercase italic tracking-widest text-white/50">
                    @yield('title', 'Dashboard')
                </h2>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('menu') }}" target="_blank" class="text-xs font-bold text-slate-500 hover:text-accent transition flex items-center gap-2 uppercase tracking-tighter">
                    <i class="fas fa-external-link-alt text-[10px]"></i> На сайт
                </a>
                <div class="w-8 h-8 rounded-full bg-accent flex items-center justify-center text-[10px] font-black text-white">
                    AD
                </div>
            </div>
        </header>

        <div class="p-8">
            <div class="max-w-6xl mx-auto">
                @yield('content')
            </div>
        </div>
    </main>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[45] hidden transition-opacity md:hidden"></div>

    <script>
        const burgerBtn = document.getElementById('burgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        burgerBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Закрытие при нажатии ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                toggleSidebar();
            }
        });
    </script>

    @vite('resources/js/admin.js')
</body>
</html>