@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
                <p class="text-gray-600 mt-2">Stay updated with your account activity</p>
            </div>
            @php
                $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="bg-red-500 text-white rounded-full px-4 py-2 font-semibold">
                    {{ $unreadCount }} New
                </span>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="space-y-4">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 
                        @if(!$notification->is_read)
                            border-blue-500 bg-blue-50
                        @else
                            border-gray-300
                        @endif
                        transition-colors duration-200">
                        
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <!-- Notification Type Icon -->
                                    @if($notification->type === 'purchase_request')
                                        <span class="text-2xl">📋</span>
                                    @elseif($notification->type === 'purchase_accepted')
                                        <span class="text-2xl">✓</span>
                                    @elseif($notification->type === 'work_completed')
                                        <span class="text-2xl">🎉</span>
                                    @elseif($notification->type === 'purchase_cancelled')
                                        <span class="text-2xl">✕</span>
                                    @else
                                        <span class="text-2xl">⚡</span>
                                    @endif

                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $notification->title }}
                                    </h3>
                                    @if(!$notification->is_read)
                                        <span class="inline-block h-3 w-3 bg-blue-500 rounded-full"></span>
                                    @endif
                                </div>

                                <p class="text-gray-700 mt-2">{{ $notification->message }}</p>

                                <!-- Purchase-related notification details -->
                                @if($notification->purchase)
                                    <div class="mt-3 p-3 bg-gray-50 rounded border border-gray-200">
                                        <p class="text-sm text-gray-600">
                                            <strong>Skill:</strong> {{ $notification->purchase->userSkill->skill->name }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <strong>Amount:</strong> {{ number_format($notification->purchase->amount, 0) }} coins
                                        </p>
                                    </div>
                                @endif

                                <p class="text-gray-500 text-sm mt-3">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            <div class="ml-4 flex flex-col gap-2">
                                @if($notification->purchase)
                                    <a 
                                        href="{{ route('purchases.show', $notification->purchase) }}"
                                        class="px-3 py-2 text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors duration-200 whitespace-nowrap text-center"
                                    >
                                        View Details
                                    </a>

                                    @if($notification->type === 'purchase_request' && auth()->id() === $notification->purchase->seller_id)
                                        <a 
                                            href="{{ route('user.listings.management') }}"
                                            class="px-3 py-2 text-sm bg-green-500 text-white rounded hover:bg-green-600 transition-colors duration-200 whitespace-nowrap text-center"
                                        >
                                            Listing Mgmt
                                        </a>
                                    @endif
                                @endif

                                @if(!$notification->is_read)
                                    <form action="{{ route('notifications.markRead', $notification) }}" method="POST">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="px-3 py-2 text-sm bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors duration-200 whitespace-nowrap w-full"
                                        >
                                            Mark Read
                                        </button>
                                    </form>
                                @else
                                    <span class="px-3 py-2 text-sm text-gray-500 bg-gray-100 rounded whitespace-nowrap text-center">
                                        Read
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="text-6xl mb-4">◉</div>
                    <p class="text-gray-500 text-lg font-semibold">No notifications yet</p>
                    <p class="text-gray-400 text-sm mt-2">You're all caught up! Notifications will appear here when you have activity</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
