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
                        accent: '#FF4D00', // Агрессивный оранжевый
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
        /* Декоративные пятна на фоне */
        .blob {
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 77, 0, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
            filter: blur(60px);
        }
        .header-glass {
            background: rgba(8, 8, 8, 0.7);
            backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        /* Убираем стандартные подчеркивания */
        a { text-decoration: none; }
    </style>
</head>

<body class="antialiased flex flex-col min-h-screen">

    {{-- ВСТАВЛЯЙТЕ СЮДА --}}
    @if(session('success'))
        <div id="success-alert" class="fixed top-24 left-1/2 -translate-x-1/2 z-[110] w-full max-w-xs transition-all duration-500">
            <div class="bg-accent text-white px-6 py-3 rounded-2xl shadow-[0_10px_30px_rgba(255,77,0,0.5)] text-center font-display font-black uppercase text-[10px] tracking-widest animate-bounce">
                {{ session('success') }}
            </div>
        </div>

        <script>
            // Автоматическое исчезновение через 3 секунды
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translate(-50%, -20px)';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 3000);
        </script>
    @endif
    
    <div class="blob -top-20 -left-20"></div>
    <div class="blob top-1/2 -right-20 opacity-50"></div>

    <header class="header-glass sticky top-0 z-[100]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            
            {{-- Логотип и Название --}}
            <a href="{{ route('menu') }}" class="flex items-center gap-2 sm:gap-4 group shrink-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-accent rounded-full flex items-center justify-center rotate-[-15deg] group-hover:rotate-0 transition-all duration-500 shadow-[0_0_20px_rgba(255,77,0,0.4)] shrink-0">
                    <i class="fas fa-pizza-slice text-white text-base sm:text-xl"></i>
                </div>
                
                <div class="flex flex-col border-r border-white/10 pr-2 sm:pr-4">
                    <h1 class="font-display text-sm sm:text-lg font-black tracking-tighter leading-none uppercase text-white">
                        Delivery
                    </h1>
                    <h1 class="font-display text-sm sm:text-lg font-black tracking-tighter leading-none uppercase text-accent italic">
                        от печи
                    </h1>
                </div>
    
                {{-- Знак Халяль --}}
                <div class="shrink-0 flex items-center ml-auto sm:ml-0">
                    <img src="{{ asset('images/halal.png') }}" 
                        class="h-14 sm:h-20 w-auto object-contain brightness-125 contrast-125 drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]" 
                         alt="Halal Certificate">
                </div>
            </a>
    
            {{-- Навигация (Desktop) --}}
            <nav class="hidden lg:flex items-center bg-white/5 border border-white/10 p-1.5 rounded-2xl mx-4">
                <a href="{{ route('menu') }}" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-white/10 @if(Request::is('menu*')) bg-accent text-white @endif">Меню</a>
                <a href="{{ route('cart.index') }}" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-white/10 @if(Request::is('cart*')) bg-accent text-white @endif">Корзина</a>
                <a href="{{ route('my.orders') }}" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-white/10 @if(Request::is('orders*')) bg-accent text-white @endif">Заказы</a>
            </nav>
    
            {{-- Правый блок --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.login') }}" class="w-10 h-10 flex items-center justify-center rounded-full border border-white/10 hover:border-accent/50 transition-all group">
                    <i class="fas fa-user-gear text-xs opacity-50 group-hover:opacity-100 group-hover:text-accent"></i>
                </a>
                <button id="burger-btn" class="lg:hidden w-11 h-11 flex items-center justify-center rounded-xl bg-accent shadow-[0_4px_15px_rgba(255,77,0,0.3)]">
                    <i class="fas fa-bars-staggered text-white text-base"></i>
                </button>
            </div>
        </div>
    </header>

    {{-- Мобильное меню --}}
    <div id="mobile-nav" class="fixed inset-0 z-[110] bg-night translate-y-full transition-transform duration-500 ease-[cubic-bezier(0.85,0,0.15,1)]">
        <div class="p-6 h-full flex flex-col">
            <div class="flex justify-end">
                <button id="close-btn" class="w-14 h-14 flex items-center justify-center rounded-full bg-white/5">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div class="flex-1 flex flex-col justify-center gap-8">
                <a href="{{ route('menu') }}" class="font-display text-5xl font-black hover:text-accent transition uppercase">Меню</a>
                <a href="{{ route('cart.index') }}" class="font-display text-5xl font-black hover:text-accent transition uppercase">Корзина</a>
                <a href="{{ route('my.orders') }}" class="font-display text-5xl font-black hover:text-accent transition uppercase">Заказы</a>
            </div>
        </div>
    </div>

    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 py-8">
        @yield('content')
    </main>

    <footer class="py-12 border-t border-white/5 mt-20">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="font-display font-black text-2xl italic opacity-20">DELIVERY ОТ ПЕЧИ</div>
            <div class="text-white/20 text-[10px] font-bold uppercase">
                &copy; {{ date('Y') }} Все права защищены
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        const burgerBtn = document.getElementById('burger-btn');
        const closeBtn = document.getElementById('close-btn');
        const mobileNav = document.getElementById('mobile-nav');
        const mobileLinks = mobileNav.querySelectorAll('a');

        const toggleMenu = (open) => {
            mobileNav.style.transform = open ? 'translateY(0)' : 'translateY(100%)';
            document.body.style.overflow = open ? 'hidden' : '';
        };

        burgerBtn.addEventListener('click', () => toggleMenu(true));
        closeBtn.addEventListener('click', () => toggleMenu(false));
        
        // Закрытие меню при клике на ссылку
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => toggleMenu(false));
        });
    </script>
</body>
</html>