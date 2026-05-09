

<?php $__env->startSection('title', 'Мои заказы'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-6 px-2">
    <h1 class="font-display text-2xl font-black tracking-tighter uppercase italic text-white flex items-center gap-2">
        <span class="w-1 h-6 bg-accent rounded-full"></span>
        Мои <span class="text-accent text-outline">заказы</span>
    </h1>
</div>

<div class="max-w-md mx-auto relative px-2">
    <?php if($orders->isEmpty()): ?>
        <div class="py-20 text-center bg-white/[0.02] rounded-[32px] border border-white/5">
            <i class="fas fa-receipt text-4xl text-white/10 mb-4"></i>
            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">У вас пока нет заказов</p>
            <a href="<?php echo e(route('menu')); ?>" class="inline-block mt-4 text-accent font-bold text-sm border-b border-accent/30 hover:border-accent transition">Заказать что-нибудь</a>
        </div>
    <?php else: ?>
        <div class="flex flex-col bg-white/[0.02] rounded-3xl overflow-hidden border border-white/5 shadow-2xl">
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $statusConfig = match($order->status) {
                        'new' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-400', 'icon' => 'fa-bell'],
                        'processing' => ['bg' => 'bg-orange-500/10', 'text' => 'text-orange-400', 'icon' => 'fa-fire'],
                        'done' => ['bg' => 'bg-green-500/10', 'text' => 'text-green-400', 'icon' => 'fa-check-circle'],
                        'cancelled' => ['bg' => 'bg-red-500/10', 'text' => 'text-red-400', 'icon' => 'fa-times-circle'],
                        default => ['bg' => 'bg-slate-500/10', 'text' => 'text-slate-400', 'icon' => 'fa-info-circle'],
                    };
                ?>

                <a href="<?php echo e(route('my.orders.show', $order->id)); ?>"
                   class="group flex items-center gap-4 p-4 border-b border-white/5 last:border-0 hover:bg-white/[0.05] transition-all"
                   id="order-status-container-<?php echo e($order->id); ?>"
                   data-order-id="<?php echo e($order->id); ?>">
                    
                    
                    <div id="icon-bg-<?php echo e($order->id); ?>" class="w-12 h-12 <?php echo e($statusConfig['bg']); ?> <?php echo e($statusConfig['text']); ?> rounded-full flex items-center justify-center shrink-0 transition-all duration-500 group-hover:scale-110">
                        
                        <i id="icon-i-<?php echo e($order->id); ?>" class="fas <?php echo e($statusConfig['icon']); ?> text-sm transition-all duration-500"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start mb-1">
                            <h2 class="font-bold text-[15px] text-white uppercase tracking-tight">
                                Заказ №<?php echo e($order->id); ?>

                            </h2>
                            <span class="text-[11px] font-medium text-slate-500 italic">
                                <?php echo e($order->created_at->format('d.m H:i')); ?>

                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-[13px] font-black text-white/90">
                                <?php echo e(number_format($order->total_price, 0, ',', ' ')); ?> ₽
                            </span>

                            
                            <span class="status-label text-[10px] font-black uppercase tracking-widest <?php echo e($statusConfig['text']); ?> transition-colors duration-500"
                                  id="status-label-<?php echo e($order->id); ?>">
                                <?php echo e(\App\Models\Order::getStatuses()[$order->status] ?? $order->status); ?>

                            </span>
                        </div>
                    </div>

                    <i class="fas fa-chevron-right text-[10px] text-white/10 group-hover:text-accent group-hover:translate-x-1 transition-all"></i>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .text-outline {
        color: transparent;
        -webkit-text-stroke: 1px #FF4D00;
    }
</style>

<?php $__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/front.js']); ?>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\food-project\resources\views/front/orders/my_orders.blade.php ENDPATH**/ ?>