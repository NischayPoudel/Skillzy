<x-app-layout>
    <div style="background: #f0f2f5; min-height: calc(100vh - 70px);">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0; display: grid; grid-template-columns: 360px 1fr; height: calc(100vh - 70px); gap: 0;">
            
            <!-- Conversations Sidebar -->
            <div style="background: white; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; overflow: hidden;">
                
                <!-- Header -->
                <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
                    <h2 style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">Messages</h2>
                </div>

                <!-- Conversations List -->
                <div style="flex: 1; overflow-y: auto;">
                    @if($conversations->count() > 0)
                        @foreach($conversations as $message)
                            @php
                                $otherUser = $message->sender_id === Auth::id() ? $message->receiver : $message->sender;
                                $isUnread = $message->receiver_id === Auth::id() && !$message->is_read;
                            @endphp
                            <a href="{{ route('messages.show', $otherUser->id) }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 12px; border-bottom: 1px solid #e5e7eb; text-decoration: none; transition: background 200ms ease; background: {{ $isUnread ? '#f0f8ff' : 'white' }};" onmouseover="this.style.background='#f3f4f6';" onmouseout="this.style.background='{{ $isUnread ? '#f0f8ff' : 'white' }}';">
                                
                                <!-- User Avatar -->
                                @if($otherUser->profile_image)
                                    <img src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="{{ $otherUser->name }}" style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb; flex: 0 0 auto;">
                                @else
                                    <div style="width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #1040C0 0%, #0D32A4 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 20px; flex: 0 0 auto;">
                                        {{ substr($otherUser->name, 0, 1) }}
                                    </div>
                                @endif
                                
                                <!-- User Info -->
                                <div style="flex: 1; min-width: 0;">
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                        <p style="font-weight: {{ $isUnread ? '700' : '600' }}; color: #1f2937; margin: 0; font-size: 14px;">{{ $otherUser->name }}</p>
                                        @if($isUnread)
                                            <span style="width: 10px; height: 10px; background: #1040C0; border-radius: 50%; flex: 0 0 auto;"></span>
                                        @endif
                                    </div>
                                    <p style="font-size: 12px; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        @if($message->attachment)
                                            {{ $message->sender_id === Auth::id() ? 'You: ' : '' }}Photo attached
                                        @else
                                            {{ $message->sender_id === Auth::id() ? 'You: ' : '' }}{{ Str::limit($message->message, 40) }}
                                        @endif
                                    </p>
                                </div>
                                
                                <!-- Time -->
                                <span style="font-size: 12px; color: #9ca3af; white-space: nowrap; flex: 0 0 auto;">
                                    {{ $message->created_at->setTimezone('Asia/Kathmandu')->format('M d, H:i') }}
                                </span>
                            </a>
                        @endforeach
                    @else
                        <div style="padding: 32px 16px; text-align: center;">
                            <p style="color: #9ca3af; font-size: 14px; margin: 0;">No conversations yet</p>
                            <p style="color: #d1d5db; font-size: 12px; margin: 8px 0 0;">Start by messaging a skill lister</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main Empty State -->
            <div style="background: #f0f2f5; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 24px;">
                <div style="text-align: center;">
                    <h3 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 8px;">Your Messages</h3>
                    <p style="color: #6b7280; font-size: 15px; margin: 0;">Select a conversation to start messaging</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
