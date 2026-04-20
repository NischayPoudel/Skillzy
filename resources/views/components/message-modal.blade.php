@props([
    'listing' => null,
    'purchase' => null,
    'receiverId' => null,
    'receiverName' => null,
    'user' => null,
])

@php
    $authUser = Auth::user();
    
    // Check if owner
    $isOwner = false;
    if ($authUser && $listing) {
        $isOwner = $listing->user_id === $authUser->id;
    }
    
    // If 'user' prop is provided (from profile page), set receiverId
    if ($user && !$receiverId) {
        $receiverId = $user->id;
        $receiverName = $user->name;
    }
    
    // Determine if message button should be shown
    $canMessage = $authUser && !$isOwner && ($receiverId ? $authUser->id !== $receiverId : true);
    
    $uniqueId = uniqid('message-modal-');
@endphp

@if($canMessage)
    <!-- Message Button -->
    <button 
        type="button"
        onclick="toggleMessageModal('{{ $uniqueId }}')"
        style="padding: 8px 16px; background: #1040C0; color: white; border: none; border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 200ms ease-out; width: 100%;"
        onmouseover="this.style.background='#0D32A4'; this.style.transform='translateY(-1px)';"
        onmouseout="this.style.background='#1040C0'; this.style.transform='translateY(0)';">
        Message
    </button>

    <!-- Message Modal -->
    <div id="{{ $uniqueId }}" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 12px; padding: 32px; max-width: 500px; width: 90%; box-shadow: 0 20px 25px rgba(0,0,0,0.15); position: relative;" onclick="event.stopPropagation();">
            <!-- Close Button -->
            <button 
                type="button"
                onclick="toggleMessageModal('{{ $uniqueId }}')"
                style="position: absolute; top: 16px; right: 16px; background: none; border: none; font-size: 24px; cursor: pointer; color: #9ca3af;">
                ×
            </button>

            <!-- Title -->
            <h2 style="margin: 0 0 8px 0; font-size: 20px; font-weight: 700; color: #1f2937;">
                Send Message
            </h2>
            <p style="margin: 0 0 24px 0; font-size: 14px; color: #6b7280;">
                @if($listing)
                    Message @if($listing->user->name){{ $listing->user->name }}@endif about their {{ $listing->skill->name }} skill
                @elseif($receiverName)
                    Message {{ $receiverName }}
                @else
                    Message the user
                @endif
            </p>

            <!-- Message Form -->
            <form method="POST" action="{{ route('messages.store') }}" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 16px;" onsubmit="return validateModalMessage(this, '{{ $uniqueId }}');">
                @csrf

                <!-- Hidden Fields -->
                @if($listing)
                    <input type="hidden" name="user_skill_id" value="{{ $listing->id }}">
                    <input type="hidden" name="receiver_id" value="{{ $listing->user_id }}">
                @elseif($purchase)
                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                @elseif($receiverId)
                    <input type="hidden" name="receiver_id" value="{{ $receiverId }}">
                @endif

                <!-- Photo Upload -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 14px; font-weight: 600; color: #1f2937;">Attach Photo (Optional)</label>
                    <input 
                        type="file" 
                        name="attachment" 
                        id="photo-upload-{{ $uniqueId }}"
                        accept="image/*"
                        class="modal-file-input"
                        style="padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 13px; cursor: pointer; transition: all 200ms ease-out;"
                        onchange="previewImage(this, '{{ $uniqueId }}');">
                    <div id="photo-preview-{{ $uniqueId }}" style="display: none; margin-top: 12px;">
                        <img id="preview-img-{{ $uniqueId }}" src="" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px; object-fit: cover;">
                        <button type="button" onclick="clearImage('{{ $uniqueId }}')" style="margin-top: 8px; padding: 6px 12px; background: #fee2e2; color: #dc2626; border: none; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer;">Remove Photo</button>
                    </div>
                </div>

                <!-- Message Textarea -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 14px; font-weight: 600; color: #1f2937;">Your Message (Optional)</label>
                    <textarea 
                        name="message" 
                        id="modal-message-{{ $uniqueId }}"
                        class="modal-message-input"
                        placeholder="Type your message here..."
                        style="padding: 12px 14px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-family: inherit; resize: vertical; min-height: 100px; transition: all 200ms ease-out;"
                        onfocus="this.style.borderColor='#1040C0'; this.style.boxShadow='0 0 0 3px rgba(16, 64, 192, 0.08)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"></textarea>
                </div>

                <!-- Error Messages -->
                @if($errors->has('message'))
                    <div style="padding: 12px; background: #fee2e2; border-left: 4px solid #dc2626; border-radius: 4px; color: #991b1b; font-size: 14px;">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                
                <div id="modal-error-{{ $uniqueId }}" style="display: none; padding: 12px; background: #fee2e2; border-left: 4px solid #dc2626; border-radius: 4px; color: #991b1b; font-size: 14px;"></div>

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

        function previewImage(input, uniqueId) {
            const preview = document.getElementById('photo-preview-' + uniqueId);
            const previewImg = document.getElementById('preview-img-' + uniqueId);
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function clearImage(uniqueId) {
            const input = document.getElementById('photo-upload-' + uniqueId);
            const preview = document.getElementById('photo-preview-' + uniqueId);
            input.value = '';
            preview.style.display = 'none';
        }

        function validateModalMessage(form, uniqueId) {
            const messageInput = document.getElementById('modal-message-' + uniqueId);
            const fileInput = document.getElementById('photo-upload-' + uniqueId);
            const errorDiv = document.getElementById('modal-error-' + uniqueId);
            
            const messageEmpty = !messageInput.value || messageInput.value.trim() === '';
            const fileSelected = fileInput.files && fileInput.files.length > 0;
            
            if (messageEmpty && !fileSelected) {
                errorDiv.textContent = 'Please enter a message or attach a photo';
                errorDiv.style.display = 'block';
                messageInput.style.borderColor = '#dc2626';
                messageInput.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.1)';
                messageInput.focus();
                setTimeout(() => {
                    messageInput.style.borderColor = '#e5e7eb';
                    messageInput.style.boxShadow = 'none';
                    errorDiv.style.display = 'none';
                }, 3000);
                return false;
            }
            return true;
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
