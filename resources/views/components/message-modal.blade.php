@props([
    'listing' => null,
    'purchase' => null,
    'receiverId' => null,
    'receiverName' => null,
])

@php
    $user = Auth::user();
    $isOwner = $listing ? $listing->user_id === $user->id : false;
    $uniqueId = uniqid('message-modal-');
@endphp

@if(!$isOwner)
    <!-- Message Button -->
    <button 
        type="button"
        onclick="toggleMessageModal('{{ $uniqueId }}')"
        style="padding: 8px 16px; background: #1040C0; color: white; border: none; border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 200ms ease-out; width: 100%;"
        onmouseover="this.style.background='#0D32A4'; this.style.transform='translateY(-1px)';"
        onmouseout="this.style.background='#1040C0'; this.style.transform='translateY(0)';">
        ✉️ Message
    </button>

    <!-- Message Modal -->
    <div id="{{ $uniqueId }}" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 12px; padding: 32px; max-width: 500px; width: 90%; box-shadow: 0 20px 25px rgba(0,0,0,0.15); position: relative;" onclick="event.stopPropagation();">
            <!-- Close Button -->
            <button 
                type="button"
                onclick="toggleMessageModal('{{ $uniqueId }}')"
                style="position: absolute; top: 16px; right: 16px; background: none; border: none; font-size: 24px; cursor: pointer; color: #9ca3af;">
                ✕
            </button>

            <!-- Title -->
            <h2 style="margin: 0 0 8px 0; font-size: 20px; font-weight: 700; color: #1f2937;">
                Send Message
            </h2>
            <p style="margin: 0 0 24px 0; font-size: 14px; color: #6b7280;">
                @if($listing)
                    Message @if($listing->user->name){{ $listing->user->name }}@endif about their {{ $listing->skill->name }} skill
                @else
                    Message the user
                @endif
            </p>

            <!-- Message Form -->
            <form method="POST" action="{{ route('messages.store') }}" style="display: flex; flex-direction: column; gap: 16px;">
                @csrf

                <!-- Hidden Fields -->
                @if($listing)
                    <input type="hidden" name="user_skill_id" value="{{ $listing->id }}">
                    <input type="hidden" name="receiver_id" value="{{ $listing->user_id }}">
                @elseif($purchase)
                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                @else
                    @if($receiverId)
                        <input type="hidden" name="receiver_id" value="{{ $receiverId }}">
                    @endif
                @endif

                <!-- Message Textarea -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 14px; font-weight: 600; color: #1f2937;">Your Message</label>
                    <textarea 
                        name="message" 
                        placeholder="Type your message here..."
                        required
                        style="padding: 12px 14px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-family: inherit; resize: vertical; min-height: 120px; transition: all 200ms ease-out;"
                        onfocus="this.style.borderColor='#1040C0'; this.style.boxShadow='0 0 0 3px rgba(16, 64, 192, 0.08)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"></textarea>
                </div>

                <!-- Error Messages -->
                @if($errors->has('message'))
                    <div style="padding: 12px; background: #fee2e2; border-left: 4px solid #dc2626; border-radius: 4px; color: #991b1b; font-size: 14px;">
                        {{ $errors->first('message') }}
                    </div>
                @endif

                <!-- Buttons -->
                <div style="display: flex; gap: 12px; margin-top: 8px;">
                    <button 
                        type="button"
                        onclick="toggleMessageModal('{{ $uniqueId }}')"
                        style="flex: 1; padding: 12px 16px; background: #f3f4f6; color: #1f2937; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 200ms ease-out;"
                        onmouseover="this.style.background='#e5e7eb';"
                        onmouseout="this.style.background='#f3f4f6';">
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        style="flex: 1; padding: 12px 16px; background: #1040C0; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 200ms ease-out;"
                        onmouseover="this.style.background='#0D32A4'; this.style.transform='translateY(-1px)';"
                        onmouseout="this.style.background='#1040C0'; this.style.transform='translateY(0)';">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Toggle Script -->
    <script>
        function toggleMessageModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.style.display === 'none' || modal.style.display === '') {
                modal.style.display = 'flex';
                if (modal.querySelector('textarea')) {
                    modal.querySelector('textarea').focus();
                }
            } else {
                modal.style.display = 'none';
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('[id^="message-modal-"]');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
@endif
