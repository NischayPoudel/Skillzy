@props(['size' => 'md', 'color' => null])

@php
    $sizes = [
        'sm' => 'card-sm',
        'md' => 'card-md',
        'base' => 'card',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $colorClass = $color ? 'border-' . $color : '';
@endphp

<div {{ $attributes->merge(['class' => "{$sizeClass} {$colorClass} relative"]) }}>
    {{ $slot }}
</div>
