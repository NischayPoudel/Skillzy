@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
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
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $notification->title }}
                                    </h3>
                                    @if(!$notification->is_read)
                                        <span class="inline-block h-3 w-3 bg-blue-500 rounded-full"></span>
                                    @endif
                                </div>
                                <p class="text-gray-700 mt-2">{{ $notification->message }}</p>
                                <p class="text-gray-500 text-sm mt-3">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            @if(!$notification->is_read)
                                <form action="{{ route('notifications.markRead', $notification) }}" method="POST" class="ml-4">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors duration-200 whitespace-nowrap"
                                    >
                                        Mark Read
                                    </button>
                                </form>
                            @else
                                <span class="ml-4 px-3 py-1 text-sm text-gray-500 bg-gray-100 rounded whitespace-nowrap">
                                    Read
                                </span>
                            @endif
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
