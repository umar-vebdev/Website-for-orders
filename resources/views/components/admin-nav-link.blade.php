@props(['href', 'icon', 'label'])

@php
    // Проверяем, активна ли ссылка прямо сейчас
    $active = request()->fullUrlIs($href) || request()->url() == $href;
    
    $classes = $active 
        ? 'flex items-center gap-3 px-4 py-3 rounded-2xl bg-accent/10 text-accent border-r-4 border-accent transition-all shadow-[inset_0_0_20px_rgba(255,77,0,0.05)]' 
        : 'flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-400 hover:bg-white/5 hover:text-white transition-all';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    <i class="fas {{ $icon }} w-5 text-center transition-transform {{ $active ? 'scale-110' : '' }}"></i>
    <span class="text-[11px] font-black uppercase tracking-[0.15em]">{{ $label }}</span>
</a>