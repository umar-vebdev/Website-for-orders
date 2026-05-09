@extends('layouts.admin')

@section('title', 'Панель админа')

@section('content')

    {{-- Метрики --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="glass-panel rounded-2xl p-4">
            <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">Заказы сегодня</div>
            <div class="text-2xl font-display font-black text-white">{{ $ordersToday }}</div>
        </div>
        <div class="glass-panel rounded-2xl p-4">
            <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">За неделю</div>
            <div class="text-2xl font-display font-black text-white">{{ $ordersWeek }}</div>
        </div>
        <div class="glass-panel rounded-2xl p-4">
            <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">Выручка сегодня</div>
            <div class="text-2xl font-display font-black text-accent">{{ number_format($revenueToday, 0, ',', ' ') }} ₽</div>
        </div>
        <div class="glass-panel rounded-2xl p-4">
            <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">За неделю</div>
            <div class="text-2xl font-display font-black text-accent">{{ number_format($revenueWeek, 0, ',', ' ') }} ₽</div>
        </div>
    </div>

    {{-- Новые заказы badge --}}
    @if ($newOrdersCount > 0)
        <div class="mb-6">
            <a href="{{ route('admin.orders', ['status' => 'new']) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 hover:bg-red-500/20 transition-colors">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                <span class="text-sm font-bold">{{ $newOrdersCount }} новых заказов</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    @endif

    {{-- Сетка быстрых действий --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        {{-- Управление блюдами --}}
        <a href="{{ route('admin.dishes') }}"
            class="group relative p-6 glass-panel rounded-[24px] overflow-hidden transition-all hover:border-accent/50 hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 text-white/5 group-hover:text-accent/10 transition-colors">
                <i class="fas fa-utensils text-7xl"></i>
            </div>
            <div
                class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center text-accent mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-pizza-slice text-xl"></i>
            </div>
            <h3 class="font-display text-sm font-black uppercase tracking-wider text-white italic">Блюда</h3>
            <p class="text-xs text-slate-500 mt-1 uppercase font-bold tracking-tighter">Редактирование меню</p>
        </a>

        {{-- Управление заказами --}}
        <a href="{{ route('admin.orders') }}"
            class="group relative p-6 glass-panel rounded-[24px] overflow-hidden transition-all hover:border-green-500/50 hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 text-white/5 group-hover:text-green-500/10 transition-colors">
                <i class="fas fa-receipt text-7xl"></i>
            </div>
            <div
                class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center text-green-500 mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-shopping-bag text-xl"></i>
            </div>
            <h3 class="font-display text-sm font-black uppercase tracking-wider text-white italic">Заказы</h3>
            <p class="text-xs text-slate-500 mt-1 uppercase font-bold tracking-tighter">Обработка заявок</p>
        </a>

        {{-- Добавить администратора --}}
        <a href="{{ route('admin.register') }}"
            class="group relative p-6 glass-panel rounded-[24px] overflow-hidden transition-all hover:border-purple-500/50 hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 text-white/5 group-hover:text-purple-500/10 transition-colors">
                <i class="fas fa-user-plus text-7xl"></i>
            </div>
            <div
                class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-500 mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-shield-halved text-xl"></i>
            </div>
            <h3 class="font-display text-sm font-black uppercase tracking-wider text-white italic">Админ</h3>
            <p class="text-xs text-slate-500 mt-1 uppercase font-bold tracking-tighter">Новый доступ</p>
        </a>

    </div>

    {{-- Топ-5 блюд --}}
    @if ($topDishes->count() > 0)
        <div class="glass-panel rounded-[32px] overflow-hidden mb-8">
            <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                <div>
                    <h2 class="text-sm font-black uppercase tracking-[0.2em] text-white">Топ-5 блюд</h2>
                    <p class="text-[10px] text-slate-500 uppercase mt-1 font-bold">Самые популярные позиции</p>
                </div>
                <i class="fas fa-trophy text-accent"></i>
            </div>
            <div class="divide-y divide-white/5">
                @foreach ($topDishes as $index => $item)
                    <div class="flex justify-between items-center px-8 py-4 hover:bg-white/[0.02] transition-colors">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-8 h-8 rounded-lg bg-accent/10 flex items-center justify-center text-accent font-black text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-white">{{ $item->dish?->name ?? 'Неизвестно' }}</div>
                                <div class="text-[10px] text-slate-500 uppercase">{{ $item->total_quantity }} шт. продано
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Список администраторов --}}
    <div class="glass-panel rounded-[32px] overflow-hidden">
        <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
            <div>
                <h2 class="text-sm font-black uppercase tracking-[0.2em] text-white">Команда админов</h2>
                <p class="text-[10px] text-slate-500 uppercase mt-1 font-bold">Управление правами доступа</p>
            </div>
            <i class="fas fa-users-gear text-slate-700"></i>
        </div>

        <div class="divide-y divide-white/5">
            @foreach ($admins as $admin)
                <div class="flex justify-between items-center px-8 py-4 hover:bg-white/[0.02] transition-colors group">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-night border border-white/10 flex items-center justify-center text-[10px] font-black text-slate-400 group-hover:border-accent/40 group-hover:text-accent transition-all">
                            {{ strtoupper(substr($admin->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">{{ $admin->name }}</div>
                            <div class="text-[11px] text-slate-500 font-medium">{{ $admin->email }}</div>
                        </div>
                    </div>

                    <form action="{{ route('admin.delete', $admin->id) }}" method="POST"
                        onsubmit="return confirm('Удалить этого администратора?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-500/5 text-red-500 hover:bg-red-500 hover:text-white transition-all active:scale-90">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Компактная кнопка выхода для мобильных --}}
    <div class="mt-8 md:hidden">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full py-4 glass-panel rounded-2xl text-red-500 font-black uppercase text-[10px] tracking-[0.2em]">
                Выйти из системы
            </button>
        </form>
    </div>

@endsection
