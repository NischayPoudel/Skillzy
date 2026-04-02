@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'padding: 0.25rem 0; background-color: white;'])

@php
$alignmentStyles = match ($align) {
    'left' => 'left: 0;',
    'top' => '',
    default => 'right: 0;',
};

$widthStyle = match ($width) {
    '48' => 'width: 12rem;',
    default => '',
};
@endphp

<div style="position: relative;">
    <div class="dropdown-trigger">
        {{ $trigger }}
    </div>

    <div class="dropdown-menu" style="position: absolute; z-index: 50; margin-top: 0.5rem; {{ $widthStyle }} border-radius: 0.375rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); display: none; {{ $alignmentStyles }}">
        <div style="border-radius: 0.375rem; border: 1px solid rgba(0, 0, 0, 0.05); {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdowns = document.querySelectorAll('div > .dropdown-trigger');
        
        dropdowns.forEach(trigger => {
            const container = trigger.parentElement;
            const menu = container.querySelector('.dropdown-menu');
            
            if (!trigger || !menu) return;
            
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                // Close other dropdowns
                document.querySelectorAll('.dropdown-menu').forEach(m => {
                    if (m !== menu) m.style.display = 'none';
                });
                menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
            });
            
            menu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
        
        document.addEventListener('click', function(e) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        });
    });
</script>
