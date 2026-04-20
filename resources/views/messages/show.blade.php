<x-app-layout>
    <div style="background: white; height: calc(100vh - 70px); display: flex; flex-direction: column;">
        
        <!-- Chat Header -->
        <div style="background: white; border-bottom: 1px solid #e5e7eb; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; flex: 0 0 auto;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <a href="{{ route('messages.index') }}" style="font-size: 24px; color: #1040C0; text-decoration: none;">←</a>
                
                @if($otherUser->profile_image)
                    <img src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="{{ $otherUser->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                @else
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #1040C0 0%, #0D32A4 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 16px;">
                        {{ substr($otherUser->name, 0, 1) }}
                    </div>
                @endif
                
                <div>
                    <p style="font-weight: 700; color: #1f2937; margin: 0; font-size: 16px;">{{ $otherUser->name }}</p>
                    <p style="font-size: 12px; color: #9ca3af; margin: 2px 0 0 0;">{{ $otherUser->username }}</p>
                </div>
            </div>
            
            <a href="{{ route('profile.public', $otherUser) }}" style="padding: 8px 16px; background: #f3f4f6; color: #1040C0; border: 2px solid #1040C0; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 12px; transition: all 200ms ease;" onmouseover="this.style.background='#e5e7eb';" onmouseout="this.style.background='#f3f4f6';">
                View Profile
            </a>
        </div>

        <!-- Messages Area -->
        <div style="flex: 1; overflow-y: auto; padding: 24px; display: flex; flex-direction: column; gap: 16px; background: #f9fafb;" id="messages-container">
            @if($messages->count() > 0)
                @foreach($messages as $message)
                    @php
                        $isOwn = $message->sender_id === Auth::id();
                    @endphp
                    <div style="display: flex; justify-content: {{ $isOwn ? 'flex-end' : 'flex-start' }};">
                        <div style="max-width: 60%; display: flex; flex-direction: column; gap: 4px;">
                            @if($message->attachment)
                                <img src="{{ asset('storage/' . $message->attachment) }}" alt="Message attached image" style="max-width: 100%; border-radius: 12px; object-fit: cover; max-height: 400px;">
                            @endif
                            
                            @if($message->message)
                                <div style="background: {{ $isOwn ? '#1040C0' : '#e5e7eb' }}; color: {{ $isOwn ? 'white' : '#1f2937' }}; padding: 12px 16px; border-radius: 18px; word-wrap: break-word; font-size: 14px; line-height: 1.4;">
                                    {{ $message->message }}
                                </div>
                            @endif
                            
                            @if($message->userSkill)
                                <!-- Listing Card -->
                                <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px; max-width: 300px; display: flex; flex-direction: column; gap: 10px; margin-top: 8px;">
                                    <!-- Skill Icon/Image -->
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #1040C0 0%, #0D32A4 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 700; color: white; flex-shrink: 0;">
                                            @php
                                                $skillLetters = [
                                                    'Web Development' => 'W',
                                                    'PHP Development' => 'P',
                                                    'Digital Marketing' => 'D',
                                                    'Business Consulting' => 'B',
                                                    'API Development' => 'A',
                                                    'Graphic Design' => 'G',
                                                    'Content Writing' => 'C',
                                                    'Video Editing' => 'V',
                                                    'UI/UX Design' => 'U',
                                                    'Data Analysis' => 'DA',
                                                ];
                                                $skillName = $message->userSkill->skill->name;
                                                $letter = $skillLetters[$skillName] ?? substr($skillName, 0, 1);
                                            @endphp
                                            {{ $letter }}
                                        </div>
                                        <div style="flex: 1;">
                                            <p style="font-weight: 700; color: #1f2937; margin: 0 0 2px 0; font-size: 13px;">{{ $message->userSkill->skill->name }}</p>
                                            <p style="font-size: 11px; color: #9ca3af; margin: 0;">by {{ $message->userSkill->user->name }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Price and Level -->
                                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 8px; border-top: 1px solid #e5e7eb;">
                                        <div style="display: flex; align-items: baseline; gap: 4px;">
                                            <span style="font-size: 16px; font-weight: 700; color: #1040C0;">₹{{ number_format($message->userSkill->price, 0) }}</span>
                                            <span style="font-size: 10px; background: #f3f4f6; padding: 2px 6px; border-radius: 3px; color: #6b7280; text-transform: uppercase; font-weight: 600;">{{ ucfirst($message->userSkill->experience_level) }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- View Details Link -->
                                    <a href="{{ route('listings.show', $message->userSkill) }}" style="display: block; text-align: center; padding: 8px 12px; background: #1040C0; color: white; border: none; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 200ms ease;" onmouseover="this.style.background='#0D32A4';" onmouseout="this.style.background='#1040C0';">
                                        View Details
                                    </a>
                                </div>
                            @elseif($message->purchase)
                                <p style="font-size: 11px; color: #9ca3af; margin: 0; {{ $isOwn ? 'text-align: right;' : '' }}">
                                    Purchase: #{{ $message->purchase->id }}
                                </p>
                            @endif
                            
                            <p style="font-size: 11px; color: #bfcad3; margin: 0; {{ $isOwn ? 'text-align: right;' : '' }}">
                                {{ $message->created_at->setTimezone('Asia/Kathmandu')->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; color: #9ca3af; padding: 32px;">
                    <p style="margin: 0;">No messages yet. Start the conversation!</p>
                </div>
            @endif
        </div>

        <!-- Message Input -->
        <div style="background: white; border-top: 1px solid #e5e7eb; padding: 16px 24px; flex: 0 0 auto;">
            @if($errors->any())
                <div style="margin-bottom: 12px; padding: 12px; background: #fee2e2; border-left: 4px solid #dc2626; border-radius: 4px; color: #991b1b; font-size: 14px;">
                    @foreach($errors->all() as $error)
                        <p style="margin: 0 0 4px 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('messages.store') }}" enctype="multipart/form-data" style="display: flex; align-items: center; gap: 12px;" onsubmit="return validateMessage(event);">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                
                <!-- File Upload Input -->
                <input 
                    type="file" 
                    name="attachment" 
                    id="photo-input"
                    accept="image/*"
                    style="display: none;">
                <button 
                    type="button"
                    onclick="document.getElementById('photo-input').click()"
                    style="padding: 10px 16px; background: #f3f4f6; color: #1040C0; border: 2px solid #e5e7eb; border-radius: 20px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 200ms ease; flex: 0 0 auto; height: 40px; display: flex; align-items: center; justify-content: center;" 
                    onmouseover="this.style.background='#e5e7eb';" 
                    onmouseout="this.style.background='#f3f4f6';">
                    Photo
                </button>
                
                <textarea 
                    name="message" 
                    id="message-input"
                    placeholder="Aa"
                    style="flex: 1; padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 20px; font-size: 14px; font-family: inherit; resize: none; min-height: 40px; max-height: 160px; transition: all 200ms ease;" 
                    onfocus="this.style.borderColor='#1040C0'; this.style.boxShadow='0 0 0 3px rgba(16, 64, 192, 0.1)';" 
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"></textarea>
                
                <button 
                    type="submit"
                    style="padding: 10px 20px; background: #1040C0; color: white; border: none; border-radius: 20px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 200ms ease; flex: 0 0 auto; height: 40px; display: flex; align-items: center; justify-content: center;" 
                    onmouseover="this.style.background='#0D32A4'; this.style.transform='scale(1.05)';" 
                    onmouseout="this.style.background='#1040C0'; this.style.transform='scale(1)';">
                    Send
                </button>
            </form>

            <script>
                function validateMessage(event) {
                    const messageInput = document.getElementById('message-input');
                    const fileInput = document.getElementById('photo-input');
                    
                    const messageEmpty = !messageInput.value || messageInput.value.trim() === '';
                    const fileSelected = fileInput.files && fileInput.files.length > 0;
                    
                    if (messageEmpty && !fileSelected) {
                        event.preventDefault();
                        alert('Please enter a message or attach a photo');
                        messageInput.focus();
                        messageInput.style.borderColor = '#dc2626';
                        messageInput.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.1)';
                        setTimeout(() => {
                            messageInput.style.borderColor = '#e5e7eb';
                            messageInput.style.boxShadow = 'none';
                        }, 2000);
                        return false;
                    }
                    return true;
                }
            </script>
        </div>
    </div>

    <style>
        /* Custom scrollbar styling */
        #messages-container::-webkit-scrollbar {
            width: 8px;
        }

        #messages-container::-webkit-scrollbar-track {
            background: #f9fafb;
        }

        #messages-container::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        #messages-container::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>

    <script>
        // Auto-scroll to bottom on load
        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.getElementById('messages-container');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });

        // Load previous messages when scrolling to top
        const messagesContainer = document.getElementById('messages-container');
        if (messagesContainer) {
            messagesContainer.addEventListener('scroll', function() {
                if (this.scrollTop === 0 && this.scrollHeight > this.clientHeight) {
                    // User scrolled to top - can load more messages here if needed
                    console.log('Scrolled to top - ready to load more messages');
                }
            });
        }
    </script>
</x-app-layout>
