<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') – Delivery от печи</title>

    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;700;900&family=Manrope:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                        display: ['Unbounded', 'sans-serif']
                    },
                    colors: {
                        accent: '#FF4D00',
                        night: '#080808',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #080808;
            color: #efefef;
            overflow-x: hidden;
        }
        /* padding-bottom on mobile so bottom-nav doesn't cover content */
        @media (max-width: 767px) {
            body { padding-bottom: 70px; }
        }
        .blob {
            position: fixed;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(255,77,0,0.1) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
            filter: blur(60px);
        }
        .header-glass {
            background: rgba(8,8,8,0.7);
            backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        /* Drawer */
        #drawer {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        #drawer.open { transform: translateX(0); }
        #drawer-overlay {
            opacity: 0; pointer-events: none;
            transition: opacity 0.3s ease;
        }
        #drawer-overlay.open { opacity: 1; pointer-events: auto; }
        /* Search bar slide */
        #search-bar {
            max-width: 0; overflow: hidden; opacity: 0;
            transition: max-width 0.3s ease, opacity 0.3s ease;
        }
        #search-bar.open { max-width: 220px; opacity: 1; }
        a { text-decoration: none; }
    </style>
</head>

<body class="antialiased flex flex-col min-h-screen">

    <!-- Background blobs -->
    <div class="blob -top-20 -left-20"></div>
    <div class="blob top-1/2 -right-20 opacity-50"></div>

    <!-- Session Alerts (Success & Error) -->
    <div class="fixed top-24 left-1/2 -translate-x-1/2 z-[200] w-full max-w-xs space-y-3 pointer-events-none">
        @if(session('success'))
            <div id="success-alert" class="bg-accent text-white px-6 py-4 rounded-2xl shadow-[0_15px_35px_rgba(255,77,0,0.5)] text-center font-display font-black uppercase text-[10px] tracking-widest animate-bounce pointer-events-auto">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div id="error-alert" class="bg-red-500 text-white px-6 py-4 rounded-2xl shadow-[0_15px_35px_rgba(239,68,68,0.5)] text-center font-display font-black uppercase text-[10px] tracking-widest animate-pulse pointer-events-auto">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            </div>
        @endif
        
        @if($errors->any())
             <div id="validation-alert" class="bg-amber-500 text-white px-6 py-4 rounded-2xl shadow-[0_15px_35px_rgba(245,158,11,0.5)] text-center font-display font-black uppercase text-[10px] tracking-widest pointer-events-auto">
                <i class="fas fa-edit mr-2"></i> Ошибка в форме
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = ['success-alert', 'error-alert', 'validation-alert'];
            alerts.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    setTimeout(() => {
                        el.style.transition = 'all 0.5s ease';
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(-20px)';
                        setTimeout(() => el.remove(), 500);
                    }, 5000);
                }
            });
        });
    </script>

    <!-- ═══════════════════════════════ HEADER ═══════════════════════════════ -->
    <header class="header-glass sticky top-0 z-[100]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center gap-3">

            <!-- Logo -->
            <a href="{{ route('menu') }}" class="flex items-center gap-2 group shrink-0 mr-auto">
                <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center rotate-[-15deg] group-hover:rotate-0 transition-all duration-500 shadow-[0_0_20px_rgba(255,77,0,0.4)] shrink-0">
                    <i class="fas fa-pizza-slice text-white text-base"></i>
                </div>
                <div class="flex flex-col border-r border-white/10 pr-3">
                    <span class="font-display text-sm font-black tracking-tighter leading-none uppercase text-white">Delivery</span>
                    <span class="font-display text-sm font-black tracking-tighter leading-none uppercase text-accent italic">от печи</span>
                </div>
                <!-- Halal badge -->
                <img src="{{ asset('images/halal.png') }}"
                     class="h-12 w-auto object-contain brightness-125 contrast-125 drop-shadow-[0_0_15px_rgba(255,255,255,0.3)] hidden sm:block"
                     alt="Halal">
            </a>

            <!-- Search (desktop — expands inline) -->
            <div class="hidden md:flex items-center gap-1">
                <div id="search-bar" class="inline-flex">
                    <input id="search-input" type="text" placeholder="Найти блюдо..."
                        class="bg-white/10 text-white text-sm px-3 py-1.5 rounded-xl border border-white/10 focus:outline-none focus:border-accent/50 w-48"
                        onkeydown="if(event.key==='Enter')doSearch()"
                        onblur="closeSearch()">
                </div>
                <button id="search-toggle"
                    class="w-9 h-9 flex items-center justify-center rounded-xl border border-white/10 hover:border-accent/50 transition-all group"
                    onclick="toggleSearch()">
                    <i class="fas fa-search text-xs opacity-60 group-hover:opacity-100 group-hover:text-accent"></i>
                </button>
            </div>

            <!-- Cart icon + badge -->
            <a href="{{ route('cart.index') }}"
                class="relative w-9 h-9 flex items-center justify-center rounded-xl border border-white/10 hover:border-accent/50 transition-all group">
                <i class="fas fa-shopping-basket text-xs opacity-60 group-hover:opacity-100 group-hover:text-accent"></i>
                <span class="cart-badge hidden absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] bg-accent text-white text-[10px] font-black rounded-full flex items-center justify-center px-1"></span>
            </a>

            <!-- Profile icon -->
            @auth
                <a href="{{ route('admin.dashboard') }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl border border-accent/30 bg-accent/10 hover:bg-accent/20 transition-all">
                    <i class="fas fa-user-gear text-accent text-xs"></i>
                </a>
            @else
                <a href="{{ route('admin.login') }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl border border-white/10 hover:border-accent/50 transition-all group">
                    <i class="fas fa-user text-xs opacity-50 group-hover:opacity-100 group-hover:text-accent"></i>
                </a>
            @endauth

            <!-- Mobile search icon -->
            <a href="{{ route('menu') }}?search=" class="md:hidden w-9 h-9 flex items-center justify-center rounded-xl border border-white/10 hover:border-accent/50 transition-all group">
                <i class="fas fa-search text-xs opacity-60 group-hover:opacity-100"></i>
            </a>

            <!-- Burger (mobile) -->
            <button id="burger-btn"
                class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-accent shadow-[0_4px_15px_rgba(255,77,0,0.3)]"
                onclick="openDrawer()">
                <i class="fas fa-bars-staggered text-white text-base"></i>
            </button>
        </div>
    </header>

    <!-- ═══════════════════════════════ DRAWER (mobile) ═══════════════════════ -->
    <!-- Overlay -->
    <div id="drawer-overlay"
        class="fixed inset-0 z-[120] bg-black/60 md:hidden"
        onclick="closeDrawer()"></div>

    <!-- Drawer panel -->
    <div id="drawer"
        class="fixed top-0 left-0 h-full z-[130] md:hidden flex flex-col"
        style="width: min(75vw, 300px); background: #1a1a1a; border-right: 1px solid #2a2a2a;">

        <!-- Drawer header -->
        <div class="flex items-center justify-between px-5 py-5 border-b border-white/5">
            <span class="font-display text-sm font-black uppercase text-accent italic">Меню</span>
            <button onclick="closeDrawer()"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white/5 hover:bg-white/10 transition-all">
                <i class="fas fa-times text-white text-sm"></i>
            </button>
        </div>

        <!-- Drawer links -->
        <nav class="flex-1 flex flex-col gap-1 px-3 py-4">
            <a href="{{ route('menu') }}" onclick="closeDrawer()"
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all hover:bg-white/5 {{ Request::is('/') || Request::is('menu*') ? 'bg-accent/10 text-accent' : 'text-white/80' }}">
                <span class="text-lg">🍕</span>
                <span class="font-bold text-sm">Меню</span>
            </a>
            <a href="{{ route('cart.index') }}" onclick="closeDrawer()"
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all hover:bg-white/5 {{ Request::is('cart*') ? 'bg-accent/10 text-accent' : 'text-white/80' }}">
                <span class="text-lg">🛒</span>
                <span class="font-bold text-sm">Корзина</span>
                <span class="cart-badge hidden ml-auto min-w-[20px] h-5 bg-accent text-white text-[10px] font-black rounded-full inline-flex items-center justify-center px-1"></span>
            </a>
            <a href="{{ route('my.orders') }}" onclick="closeDrawer()"
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all hover:bg-white/5 {{ Request::is('my-orders*') ? 'bg-accent/10 text-accent' : 'text-white/80' }}">
                <span class="text-lg">📋</span>
                <span class="font-bold text-sm">Мои заказы</span>
            </a>
            @auth
            <a href="{{ route('admin.dashboard') }}" onclick="closeDrawer()"
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all hover:bg-white/5 {{ Request::is('admin*') ? 'bg-accent/10 text-accent' : 'text-white/80' }}">
                <span class="text-lg">⚙️</span>
                <span class="font-bold text-sm">Панель</span>
            </a>
            @endauth
        </nav>
    </div>

    <!-- ═══════════════════════════════ MAIN ═══════════════════════════════════ -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 py-8">
        @yield('content')
    </main>

    <!-- ═══════════════════════════════ FOOTER ═════════════════════════════════ -->
    <footer class="py-10 border-t border-white/5 mt-16 hidden md:block">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="font-display font-black text-2xl italic opacity-20">DELIVERY ОТ ПЕЧИ</div>
            <div class="text-white/20 text-[10px] font-bold uppercase">
                &copy; {{ date('Y') }} Все права защищены
            </div>
        </div>
    </footer>

    <!-- ═══════════════════════════════ BOTTOM TAB BAR (mobile) ════════════════ -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-[100] flex items-stretch"
        style="height:60px; background:#111; border-top:1px solid #2a2a2a;">
        @php
            $tab = fn($cond) => $cond ? '#FF4D00' : '#6b7280';
            $isMenu    = Request::is('/') || Request::is('menu*');
            $isCart    = Request::is('cart*');
            $isOrders  = Request::is('my-orders*');
            $isProfile = Request::is('admin*');
        @endphp

        <a href="{{ route('menu') }}"
            class="flex-1 flex flex-col items-center justify-center gap-0.5 transition-all"
            style="color: {{ $isMenu ? '#FF4D00' : '#6b7280' }}">
            <span class="text-lg leading-none">🍕</span>
            <span class="text-[10px] font-black uppercase tracking-wider">Меню</span>
        </a>

        <a href="{{ route('cart.index') }}"
            class="flex-1 flex flex-col items-center justify-center gap-0.5 relative transition-all"
            style="color: {{ $isCart ? '#FF4D00' : '#6b7280' }}">
            <span class="relative">
                <span class="text-lg leading-none">🛒</span>
                <span class="cart-badge hidden absolute -top-1 -right-2 min-w-[16px] h-4 bg-accent text-white text-[9px] font-black rounded-full inline-flex items-center justify-center px-0.5"></span>
            </span>
            <span class="text-[10px] font-black uppercase tracking-wider">Корзина</span>
        </a>

        <a href="{{ route('my.orders') }}"
            class="flex-1 flex flex-col items-center justify-center gap-0.5 transition-all"
            style="color: {{ $isOrders ? '#FF4D00' : '#6b7280' }}">
            <span class="text-lg leading-none">📋</span>
            <span class="text-[10px] font-black uppercase tracking-wider">Заказы</span>
        </a>

        <a href="{{ Auth::check() ? route('admin.dashboard') : route('admin.login') }}"
            class="flex-1 flex flex-col items-center justify-center gap-0.5 transition-all"
            style="color: {{ $isProfile ? '#FF4D00' : '#6b7280' }}">
            <span class="text-lg leading-none">👤</span>
            <span class="text-[10px] font-black uppercase tracking-wider">Профиль</span>
        </a>
    </nav>

    @stack('scripts')

    <script>
        // ── Drawer ──────────────────────────────────────────────────────
        function openDrawer() {
            document.getElementById('drawer').classList.add('open');
            document.getElementById('drawer-overlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeDrawer() {
            document.getElementById('drawer').classList.remove('open');
            document.getElementById('drawer-overlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        // ── Search (desktop) ────────────────────────────────────────────
        let searchOpen = false;
        function toggleSearch() {
            searchOpen = !searchOpen;
            const bar = document.getElementById('search-bar');
            bar.classList.toggle('open', searchOpen);
            if (searchOpen) {
                setTimeout(() => document.getElementById('search-input').focus(), 310);
            }
        }
        function closeSearch() {
            // small delay so click on toggle button doesn't immediately re-close
            setTimeout(() => {
                if (!document.getElementById('search-input').value) {
                    searchOpen = false;
                    document.getElementById('search-bar').classList.remove('open');
                }
            }, 200);
        }
        function doSearch() {
            const q = document.getElementById('search-input').value.trim();
            if (q) window.location.href = '/menu?search=' + encodeURIComponent(q);
        }

        // ── Cart badge from server ──────────────────────────────────────
        function updateCartBadges(count) {
            document.querySelectorAll('.cart-badge').forEach(el => {
                el.textContent = count;
                el.classList.toggle('hidden', count === 0);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            fetch('/cart/count')
                .then(r => r.json())
                .then(d => updateCartBadges(d.count))
                .catch(() => {});
        });
    </script>
</body>
</html>