@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidth = [
    'sm' => 'max-width: 24rem;',
    'md' => 'max-width: 28rem;',
    'lg' => 'max-width: 32rem;',
    'xl' => 'max-width: 36rem;',
    '2xl' => 'max-width: 42rem;',
][$maxWidth];
@endphp

<div id="modal-{{ $name }}" class="modal-overlay" style="position: fixed; inset: 0; overflow-y: auto; padding: 1.5rem; z-index: 50; display: {{ $show ? 'flex' : 'none' }}; align-items: center; justify-content: center;">
    <div class="modal-backdrop" style="position: fixed; inset: 0; background-color: rgba(0, 0, 0, 0.5); z-index: -1;"></div>

    <div class="modal-content" style="background-color: white; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); transform: scale(1); transition: all 300ms ease-out; {{ $maxWidth }} width: 100%;">
        {{ $slot }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modal-{{ $name }}');
        
        if (!modal) return;
        
        function openModal() {
            modal.style.display = 'flex';
            document.body.style.overflowY = 'hidden';
        }
        
        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflowY = 'auto';
        }
        
        // Listen for custom events
        window.addEventListener('open-modal-{{ $name }}', openModal);
        window.addEventListener('close-modal-{{ $name }}', closeModal);
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.style.display === 'flex') {
                closeModal();
            }
        });
        
        // Close on backdrop click
        const backdrop = modal.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.addEventListener('click', closeModal);
        }
    });
</script>
