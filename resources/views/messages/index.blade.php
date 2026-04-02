<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if($conversations->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div style="padding: 24px; display: flex; flex-direction: column; gap: 20px;">
                        <h3 style="font-size: 18px; font-weight: 600; color: #1f2937; margin: 0;">All Messages</h3>
                        
                        @foreach($conversations as $message)
                            <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; background: {{ $message->receiver_id === Auth::id() && !$message->is_read ? '#f0f8ff' : 'white' }}; transition: all 200ms ease;">
                                <!-- Sender/Receiver Info -->
                                <div style="flex: 1; display: flex; align-items: center; gap: 12px; min-width: 0;">
                                    @php
                                        $otherUser = $message->sender_id === Auth::id() ? $message->receiver : $message->sender;
                                    @endphp
                                    
                                    @if($otherUser->profile_image)
                                        <img src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="{{ $otherUser->name }}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #1040C0;">
                                    @else
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #6b7280; font-weight: 700;">
                                            {{ substr($otherUser->name, 0, 1) }}
                                        </div>
                                    @endif
                                    
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <p style="font-weight: 600; color: #1f2937; margin: 0;">{{ $otherUser->name }}</p>
                                            @if($message->receiver_id === Auth::id() && !$message->is_read)
                                                <span style="display: inline-block; width: 8px; height: 8px; background: #1040C0; border-radius: 50%;"></span>
                                            @endif
                                        </div>
                                        
                                        @if($message->userSkill)
                                            <p style="font-size: 12px; color: #6b7280; margin: 4px 0 0 0;">
                                                About: <strong>{{ $message->userSkill->skill->name }}</strong>
                                            </p>
                                        @elseif($message->purchase)
                                            <p style="font-size: 12px; color: #6b7280; margin: 4px 0 0 0;">
                                                Purchase #{{ $message->purchase->id }}
                                            </p>
                                        @endif
                                        
                                        <p style="font-size: 13px; color: #4b5563; margin: 6px 0 0 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{ $message->sender_id === Auth::id() ? 'You: ' : '' }}{{ $message->message }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Date & View Button -->
                                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 8px; white-space: nowrap;">
                                    <span style="font-size: 12px; color: #9ca3af;">
                                        {{ $message->created_at->format('M d, H:i') }}
                                    </span>
                                    <a href="#" style="padding: 6px 12px; background: #1040C0; color: white; border: none; border-radius: 4px; font-size: 12px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 200ms ease;" onmouseover="this.style.background='#0D32A4';" onmouseout="this.style.background='#1040C0';">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                <div style="margin-top: 24px;">
                    {{ $conversations->links() }}
                </div>
            @else
                <div style="background: white; border-radius: 8px; padding: 48px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #d1d5db; margin: 0 auto 16px;">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <h3 style="font-size: 18px; font-weight: 600; color: #6b7280; margin: 0 0 8px 0;">No messages yet</h3>
                    <p style="color: #9ca3af; margin: 0 0 24px 0;">Start messaging by browsing skills and clicking the message button.</p>
                    <a href="{{ route('listings.index') }}" style="display: inline-block; padding: 12px 24px; background: #1040C0; color: white; border-radius: 4px; text-decoration: none; font-weight: 600; transition: all 200ms ease;" onmouseover="this.style.background='#0D32A4';" onmouseout="this.style.background='#1040C0';">
                        Browse Skills
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
