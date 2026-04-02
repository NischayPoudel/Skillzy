@props(['variant' => 'primary', 'size' => 'base', 'disabled' => false])

@php
    $baseClasses = 'btn transition-bauhaus active-press';
    
    $variants = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'accent' => 'btn-accent',
        'outline' => 'btn-outline',
        'ghost' => 'btn-ghost',
    ];
    
    $sizes = [
        'sm' => 'btn-sm',
        'base' => '',
        'lg' => 'btn-lg',
    ];
    
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? '';
@endphp

<button 
    {{ $attributes->merge(['class' => "{$baseClasses} {$variantClass} {$sizeClass}", 'disabled' => $disabled]) }}
>
    {{ $slot }}
</button>
