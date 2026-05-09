

<?php $__env->startSection('title', 'Панель админа'); ?>

<?php $__env->startSection('content'); ?>

    
    <form method="GET" action="<?php echo e(route('admin.dashboard')); ?>" class="glass-panel rounded-2xl p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 mb-2">Период</label>
                <select name="period" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-accent/40 text-white text-sm focus:outline-none focus:border-accent">
                    <option value="today" <?php echo e($period === 'today' ? 'selected' : ''); ?> class="bg-white text-black">Сегодня</option>
                    <option value="7d" <?php echo e($period === '7d' ? 'selected' : ''); ?> class="bg-white text-black">7 дней</option>
                    <option value="30d" <?php echo e($period === '30d' ? 'selected' : ''); ?> class="bg-white text-black">30 дней</option>
                    <option value="all" <?php echo e($period === 'all' ? 'selected' : ''); ?> class="bg-white text-black">Всё время</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 mb-2">Показывать панели</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-slate-200">
                    <label class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/5 px-3 py-2 hover:border-accent/40 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 accent-[#FF4D00]" name="show[]" value="total_orders" <?php echo e($visiblePanels['total_orders'] ? 'checked' : ''); ?>>
                        <span>Всего заказов</span>
                    </label>
                    <label class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/5 px-3 py-2 hover:border-accent/40 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 accent-[#FF4D00]" name="show[]" value="period_orders" <?php echo e($visiblePanels['period_orders'] ? 'checked' : ''); ?>>
                        <span>Заказы (<?php echo e($periodLabel); ?>)</span>
                    </label>
                    <label class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/5 px-3 py-2 hover:border-accent/40 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 accent-[#FF4D00]" name="show[]" value="period_revenue" <?php echo e($visiblePanels['period_revenue'] ? 'checked' : ''); ?>>
                        <span>Выручка (<?php echo e($periodLabel); ?>)</span>
                    </label>
                    <label class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/5 px-3 py-2 hover:border-accent/40 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 accent-[#FF4D00]" name="show[]" value="new_orders" <?php echo e($visiblePanels['new_orders'] ? 'checked' : ''); ?>>
                        <span>Новые заказы</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="mt-4 flex gap-2">
            <button type="submit" class="px-4 py-2 rounded-xl bg-accent text-white text-xs font-bold uppercase tracking-wider">Применить</button>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-4 py-2 rounded-xl bg-white/10 text-slate-200 text-xs font-bold uppercase tracking-wider">Сброс</a>
        </div>
    </form>

    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <?php if($visiblePanels['total_orders']): ?>
            <div class="glass-panel rounded-2xl p-4">
                <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">Всего заказов</div>
                <div class="text-2xl font-display font-black text-white"><?php echo e($ordersTotal); ?></div>
            </div>
        <?php endif; ?>

        <?php if($visiblePanels['period_orders']): ?>
            <div class="glass-panel rounded-2xl p-4">
                <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">Заказы <?php echo e($periodLabel); ?></div>
                <div class="text-2xl font-display font-black text-white"><?php echo e($ordersInPeriod); ?></div>
            </div>
        <?php endif; ?>

        <?php if($visiblePanels['period_revenue']): ?>
            <div class="glass-panel rounded-2xl p-4">
                <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">Выручка <?php echo e($periodLabel); ?></div>
                <div class="text-2xl font-display font-black text-accent"><?php echo e(number_format($revenueInPeriod, 0, ',', ' ')); ?> ₽</div>
            </div>
        <?php endif; ?>

        <?php if($visiblePanels['new_orders']): ?>
            <div class="glass-panel rounded-2xl p-4">
                <div class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">Новые заказы</div>
                <div class="text-2xl font-display font-black text-white"><?php echo e($newOrdersCount); ?></div>
            </div>
        <?php endif; ?>
    </div>

    <?php if($newOrdersCount > 0): ?>
        <div class="mb-6">
            <a href="<?php echo e(route('admin.orders.index', ['status' => 'new'])); ?>"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 hover:bg-red-500/20 transition-colors">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                <span class="text-sm font-bold"><?php echo e($newOrdersCount); ?> новых заказов</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    <?php endif; ?>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <a href="<?php echo e(route('admin.dishes')); ?>" class="group relative p-6 glass-panel rounded-[24px] overflow-hidden transition-all hover:border-accent/50 hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 text-white/5 group-hover:text-accent/10 transition-colors"><i class="fas fa-utensils text-7xl"></i></div>
            <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center text-accent mb-4 group-hover:scale-110 transition-transform"><i class="fas fa-pizza-slice text-xl"></i></div>
            <h3 class="font-display text-sm font-black uppercase tracking-wider text-white italic">Блюда</h3>
            <p class="text-xs text-slate-500 mt-1 uppercase font-bold tracking-tighter">Редактирование меню</p>
        </a>

        <a href="<?php echo e(route('admin.orders.index')); ?>" class="group relative p-6 glass-panel rounded-[24px] overflow-hidden transition-all hover:border-green-500/50 hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 text-white/5 group-hover:text-green-500/10 transition-colors"><i class="fas fa-receipt text-7xl"></i></div>
            <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center text-green-500 mb-4 group-hover:scale-110 transition-transform"><i class="fas fa-shopping-bag text-xl"></i></div>
            <h3 class="font-display text-sm font-black uppercase tracking-wider text-white italic">Заказы</h3>
            <p class="text-xs text-slate-500 mt-1 uppercase font-bold tracking-tighter">Обработка заявок</p>
        </a>

        <a href="<?php echo e(route('admin.register')); ?>" class="group relative p-6 glass-panel rounded-[24px] overflow-hidden transition-all hover:border-purple-500/50 hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 text-white/5 group-hover:text-purple-500/10 transition-colors"><i class="fas fa-user-plus text-7xl"></i></div>
            <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-500 mb-4 group-hover:scale-110 transition-transform"><i class="fas fa-shield-halved text-xl"></i></div>
            <h3 class="font-display text-sm font-black uppercase tracking-wider text-white italic">Админ</h3>
            <p class="text-xs text-slate-500 mt-1 uppercase font-bold tracking-tighter">Новый доступ</p>
        </a>
    </div>

    <?php if($topDishes->count() > 0): ?>
        <div class="glass-panel rounded-[32px] overflow-hidden mb-8">
            <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                <div>
                    <h2 class="text-sm font-black uppercase tracking-[0.2em] text-white">Топ-5 блюд</h2>
                    <p class="text-[10px] text-slate-500 uppercase mt-1 font-bold">Самые популярные позиции</p>
                </div>
                <i class="fas fa-trophy text-accent"></i>
            </div>
            <div class="divide-y divide-white/5">
                <?php $__currentLoopData = $topDishes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between items-center px-8 py-4 hover:bg-white/[0.02] transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-lg bg-accent/10 flex items-center justify-center text-accent font-black text-sm"><?php echo e($index + 1); ?></div>
                            <div>
                                <div class="text-sm font-bold text-white"><?php echo e($item->dish?->name ?? 'Неизвестно'); ?></div>
                                <div class="text-[10px] text-slate-500 uppercase"><?php echo e($item->total_quantity); ?> шт. продано</div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="glass-panel rounded-[32px] overflow-hidden">
        <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
            <div>
                <h2 class="text-sm font-black uppercase tracking-[0.2em] text-white">Команда админов</h2>
                <p class="text-[10px] text-slate-500 uppercase mt-1 font-bold">Управление правами доступа</p>
            </div>
            <i class="fas fa-users-gear text-slate-700"></i>
        </div>

        <div class="divide-y divide-white/5">
            <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex justify-between items-center px-8 py-4 hover:bg-white/[0.02] transition-colors group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-night border border-white/10 flex items-center justify-center text-[10px] font-black text-slate-400 group-hover:border-accent/40 group-hover:text-accent transition-all">
                            <?php echo e(strtoupper(substr($admin->name, 0, 2))); ?>

                        </div>
                        <div>
                            <div class="text-sm font-bold text-white"><?php echo e($admin->name); ?></div>
                            <div class="text-[11px] text-slate-500 font-medium"><?php echo e($admin->email); ?></div>
                        </div>
                    </div>

                    <form action="<?php echo e(route('admin.delete', $admin->id)); ?>" method="POST" onsubmit="return confirm('Удалить этого администратора?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-500/5 text-red-500 hover:bg-red-500 hover:text-white transition-all active:scale-90">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </form>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="mt-8 md:hidden">
        <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="w-full py-4 glass-panel rounded-2xl text-red-500 font-black uppercase text-[10px] tracking-[0.2em]">
                Выйти из системы
            </button>
        </form>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\food-project\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>