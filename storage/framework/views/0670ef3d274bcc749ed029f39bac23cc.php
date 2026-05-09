<?php $__env->startSection('title', 'Меню'); ?>

<?php $__env->startSection('content'); ?>

    
    <div class="mb-4 px-2 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-0.5 h-4 bg-accent rounded-full"></div>
            <h1
                class="font-display text-sm sm:text-base font-black tracking-widest uppercase italic text-white leading-none">
                Меню
            </h1>
        </div>
    </div>

    
    <div class="mb-6 px-2 overflow-x-auto scrollbar-hide">
        <div class="grid grid-rows-2 grid-flow-col gap-2 w-max">
            <?php
                $categories = ['Самса', 'Выпечка с мясом', 'Сытная выпечка', 'Сладкая выпечка', 'Пироги', 'Хлеб'];
                $currentCategory = request('category');
            ?>

            <a href="<?php echo e(route('menu')); ?>"
                class="px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center transition-all border whitespace-nowrap
           <?php echo e(!$currentCategory ? 'bg-accent border-accent text-white shadow-lg' : 'bg-white/5 border-white/5 text-slate-400'); ?>">
                Все
            </a>

            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('menu', ['category' => $cat])); ?>"
                    class="px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center transition-all border whitespace-nowrap
               <?php echo e($currentCategory === $cat ? 'bg-white border-white text-black shadow-lg' : 'bg-white/5 border-white/5 text-slate-400'); ?>">
                    <?php echo e($cat); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="mb-4 px-2 flex justify-end">
        <span class="text-[9px] font-black text-slate-600 uppercase tracking-tighter">
            Стр. <?php echo e($dishes->currentPage()); ?> из <?php echo e($dishes->lastPage()); ?>

        </span>
    </div>

    <div class="max-w-md mx-auto relative pb-28">
        <div id="menu-list"
            class="flex flex-col bg-white/[0.02] rounded-3xl overflow-hidden border border-white/5 shadow-2xl">
            <?php $__empty_1 = true; $__currentLoopData = $dishes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="group flex items-start gap-3 p-4 border-b border-white/5 last:border-0 hover:bg-white/[0.05] transition-colors"
                    data-id="<?php echo e($dish->id); ?>">
                    <div class="flex-1 min-w-0 pt-0.5">
                        <div class="flex flex-col gap-1">
                            <h2 class="font-bold text-[15px] text-white leading-tight break-words">
                                <?php echo e($dish->name); ?>

                            </h2>
                            <div class="flex items-center gap-2">
                                <span class="text-accent font-black text-[14px]">
                                    <?php echo e(number_format($dish->price, 0, ',', ' ')); ?> ₽
                                </span>
                                <?php if($dish->weight): ?>
                                    <span class="text-[10px] text-slate-500 font-medium"><?php echo e($dish->weight); ?> г</span>
                                <?php endif; ?>
                            </div>
                            <?php if($dish->description): ?>
                                <p class="text-[11px] text-slate-400 leading-snug mt-1 line-clamp-2"
                                    id="desc-<?php echo e($dish->id); ?>">
                                    <?php echo e($dish->description); ?>

                                </p>
                                <?php if(strlen($dish->description) > 60): ?>
                                    <button onclick="toggleDesc(<?php echo e($dish->id); ?>)"
                                        class="text-[9px] text-accent uppercase font-bold tracking-wider text-left mt-0.5"
                                        id="desc-btn-<?php echo e($dish->id); ?>">
                                        Подробнее
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="flex items-center bg-white/5 rounded-full p-0.5 border border-white/5 shrink-0 self-center ml-2">
                        <button
                            class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white disabled:opacity-30 disabled:cursor-not-allowed"
                            onclick="decrementDish('<?php echo e($dish->id); ?>')"
                            id="btn-minus-<?php echo e($dish->id); ?>"
                            disabled>
                            <i class="fas fa-minus text-[10px]"></i>
                        </button>
                        <span id="qty-<?php echo e($dish->id); ?>"
                            class="w-10 text-center text-white font-bold text-sm select-none">0</span>
                        <button class="w-8 h-8 flex items-center justify-center text-accent"
                            onclick="incrementDish('<?php echo e($dish->id); ?>')">
                            <i class="fas fa-plus text-[10px]"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-10 text-center">
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Ничего не найдено</p>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if($dishes->hasPages()): ?>
            <div class="mt-8 flex items-center justify-center gap-8">
                <a href="<?php echo e($dishes->appends(request()->query())->previousPageUrl()); ?>"
                    class="w-12 h-12 rounded-full border border-accent/30 flex items-center justify-center <?php echo e($dishes->onFirstPage() ? 'opacity-10 pointer-events-none' : ''); ?>">
                    <i class="fas fa-chevron-left text-accent"></i>
                </a>
                <span class="font-display font-black text-sm text-white/80 tracking-widest"><?php echo e($dishes->currentPage()); ?></span>
                <a href="<?php echo e($dishes->appends(request()->query())->nextPageUrl()); ?>"
                    class="w-12 h-12 rounded-full border border-accent/30 flex items-center justify-center <?php echo e(!$dishes->hasMorePages() ? 'opacity-10 pointer-events-none' : ''); ?>">
                    <i class="fas fa-chevron-right text-accent"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>

    
    <div id="cart-bar" class="fixed bottom-[70px] left-0 w-full flex justify-center z-[89] px-6 pointer-events-none">
        <button id="add-all-to-cart"
            class="w-full max-w-md py-4 bg-accent rounded-2xl shadow-[0_15px_35px_rgba(255,77,0,0.5)]
                   flex items-center justify-center gap-3 transition-all duration-300 active:scale-95
                   opacity-0 translate-y-10 pointer-events-none">
            <span class="font-display font-black text-white text-sm uppercase tracking-widest">В корзину</span>
            <div class="bg-white/25 px-2.5 py-0.5 rounded-lg flex items-center gap-1.5">
                <span id="cart-btn-count" class="text-white font-black text-sm">0</span>
                <i class="fas fa-shopping-cart text-white text-[10px]"></i>
            </div>
        </button>
    </div>

    
    <div id="cart-toast"
        class="fixed top-24 left-1/2 -translate-x-1/2 z-[200] opacity-0 -translate-y-5
               transition-all duration-300 pointer-events-none">
        <div class="bg-green-500 text-white px-6 py-3 rounded-2xl shadow-2xl text-center
                    font-display font-black uppercase text-[10px] tracking-widest flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>Товары добавлены в корзину ✓</span>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        const DRAFT_KEY = 'menu_draft';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ── LocalStorage helpers ────────────────────────────────────────
        function getDraft() {
            try { return JSON.parse(localStorage.getItem(DRAFT_KEY)) || {}; } catch { return {}; }
        }
        function saveDraft(d) { localStorage.setItem(DRAFT_KEY, JSON.stringify(d)); }
        function clearDraft()  { localStorage.removeItem(DRAFT_KEY); }

        function totalDraftCount() {
            return Object.values(getDraft()).reduce((s, q) => s + q, 0);
        }

        // ── Render a single dish qty ────────────────────────────────────
        function renderQty(id, qty) {
            const span  = document.getElementById('qty-' + id);
            const minus = document.getElementById('btn-minus-' + id);
            if (!span) return;
            span.textContent = qty;
            if (minus) minus.disabled = qty === 0;
        }

        // ── Floating button state ───────────────────────────────────────
        function updateFloatingButton() {
            const total = totalDraftCount();
            const btn   = document.getElementById('add-all-to-cart');
            const bar   = document.getElementById('cart-bar');
            document.getElementById('cart-btn-count').textContent = total;

            if (total > 0) {
                btn.classList.remove('opacity-0', 'translate-y-10', 'pointer-events-none');
                btn.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                bar.classList.replace('pointer-events-none', 'pointer-events-auto');
            } else {
                btn.classList.add('opacity-0', 'translate-y-10', 'pointer-events-none');
                btn.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                bar.classList.replace('pointer-events-auto', 'pointer-events-none');
            }
        }

        // ── +/- ─────────────────────────────────────────────────────────
        function incrementDish(id) {
            const d = getDraft();
            d[id] = (d[id] || 0) + 1;
            saveDraft(d);
            renderQty(id, d[id]);
            updateFloatingButton();
        }

        function decrementDish(id) {
            const d = getDraft();
            if (!d[id]) return;
            d[id]--;
            if (d[id] <= 0) delete d[id];
            saveDraft(d);
            renderQty(id, d[id] || 0);
            updateFloatingButton();
        }

        // ── Description toggle ──────────────────────────────────────────
        function toggleDesc(id) {
            const desc = document.getElementById('desc-' + id);
            const btn  = document.getElementById('desc-btn-' + id);
            const collapsed = desc.classList.toggle('line-clamp-2');
            btn.textContent = collapsed ? 'Подробнее' : 'Свернуть';
        }

        // ── Toast ───────────────────────────────────────────────────────
        function showToast() {
            const t = document.getElementById('cart-toast');
            t.classList.remove('opacity-0', '-translate-y-5');
            t.classList.add('opacity-100', 'translate-y-0');
            setTimeout(() => {
                t.classList.add('opacity-0', '-translate-y-5');
                t.classList.remove('opacity-100', 'translate-y-0');
            }, 3000);
        }

        // ── Update cart badge everywhere ────────────────────────────────
        function updateCartBadges(count) {
            document.querySelectorAll('.cart-badge').forEach(el => {
                el.textContent = count;
                el.classList.toggle('hidden', count === 0);
            });
        }

        // ── "В корзину" click ───────────────────────────────────────────
        document.getElementById('add-all-to-cart').addEventListener('click', function () {
            const draft = getDraft();
            if (!Object.keys(draft).length) return;

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin text-white"></i>' +
                            '<span class="ml-2 font-display font-black text-white text-xs uppercase tracking-widest">Добавляем...</span>';

            fetch('/cart/add-bulk', {
                method : 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body   : JSON.stringify({ items: draft })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    clearDraft();
                    document.querySelectorAll('[id^="qty-"]').forEach(el => {
                        renderQty(el.id.replace('qty-', ''), 0);
                    });
                    updateFloatingButton();
                    updateCartBadges(data.cart_count);
                    showToast();
                }
            })
            .catch(() => {})
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML =
                    '<span class="font-display font-black text-white text-sm uppercase tracking-widest">В корзину</span>' +
                    '<div class="bg-white/25 px-2.5 py-0.5 rounded-lg flex items-center gap-1.5">' +
                    '<span id="cart-btn-count" class="text-white font-black text-sm">0</span>' +
                    '<i class="fas fa-shopping-cart text-white text-[10px]"></i></div>';
                updateFloatingButton();
            });
        });

        // ── Init ────────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', function () {
            const draft = getDraft();
            document.querySelectorAll('[data-id]').forEach(el => {
                const id = el.getAttribute('data-id');
                renderQty(id, draft[id] || 0);
            });
            updateFloatingButton();
        });
    </script>
    <?php $__env->stopPush(); ?>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\food-project\resources\views/front/menu/index.blade.php ENDPATH**/ ?>