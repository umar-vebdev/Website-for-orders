<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['href', 'icon', 'label']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['href', 'icon', 'label']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Проверяем, активна ли ссылка прямо сейчас
    $active = request()->fullUrlIs($href) || request()->url() == $href;
    
    $classes = $active 
        ? 'flex items-center gap-3 px-4 py-3 rounded-2xl bg-accent/10 text-accent border-r-4 border-accent transition-all shadow-[inset_0_0_20px_rgba(255,77,0,0.05)]' 
        : 'flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-400 hover:bg-white/5 hover:text-white transition-all';
?>

<a href="<?php echo e($href); ?>" <?php echo e($attributes->merge(['class' => $classes])); ?>>
    <i class="fas <?php echo e($icon); ?> w-5 text-center transition-transform <?php echo e($active ? 'scale-110' : ''); ?>"></i>
    <span class="text-[11px] font-black uppercase tracking-[0.15em]"><?php echo e($label); ?></span>
</a><?php /**PATH C:\Users\user\food-project\resources\views/components/admin-nav-link.blade.php ENDPATH**/ ?>