<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Purchase Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($message = session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ $message }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="md:col-span-2">
                    <!-- Purchase Info -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            {{ $purchase->userSkill->skill->name }}
                        </h2>

                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('Amount') }}</p>
                                <p class="text-3xl font-bold text-indigo-600">{{ number_format($purchase->amount, 2) }} coins</p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('Status') }}</p>
                                <p class="text-2xl font-bold
                                    @if($purchase->status === 'pending') text-yellow-600
                                    @elseif($purchase->status === 'accepted') text-blue-600
                                    @elseif($purchase->status === 'completed') text-green-600
                                    @else text-red-600
                                    @endif">
                                    {{ ucfirst($purchase->status) }}
                                </p>
                            </div>
                        </div>

                        <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('Buyer') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $purchase->buyer->name }}</p>
                        </div>

                        <div class="mb-6">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('Seller') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $purchase->seller->name }}</p>
                        </div>

                        @if($purchase->note)
                            <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-900 rounded-lg">
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">{{ __('Note') }}</p>
                                <p class="text-gray-900 dark:text-white">{{ $purchase->note }}</p>
                            </div>
                        @endif

                        <!-- Seller Actions -->
                        @auth
                            @if(auth()->id() === $purchase->seller_id && $purchase->status === 'pending')
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('purchases.update', $purchase) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="accept">
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                            {{ __('Accept') }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('purchases.update', $purchase) }}" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="cancel">
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                            {{ __('Decline') }}
                                        </button>
                                    </form>
                                </div>
                            @elseif(auth()->id() === $purchase->seller_id && $purchase->status === 'accepted')
                                <form method="POST" action="{{ route('purchases.update', $purchase) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="action" value="complete">
                                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700" onclick="return confirm('Complete this purchase?')">
                                        {{ __('Complete Purchase & Transfer Coins') }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    <!-- Messages Section -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('Messages') }}</h3>
                        
                        <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                            @forelse($purchase->messages as $msg)
                                <div class="p-3 rounded-lg @if($msg->sender_id === auth()->id()) bg-indigo-100 dark:bg-indigo-900 @else bg-gray-100 dark:bg-gray-700 @endif">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ $msg->sender->name }}</p>
                                    <p class="text-gray-900 dark:text-white">{{ $msg->message }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $msg->created_at->format('M d, H:i') }}</p>
                                </div>
                            @empty
                                <p class="text-gray-600 dark:text-gray-400">{{ __('No messages yet') }}</p>
                            @endforelse
                        </div>

                        @auth
                            @if(auth()->id() === $purchase->buyer_id || auth()->id() === $purchase->seller_id)
                                <form method="POST" action="{{ route('messages.store') }}">
                                    @csrf
                                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                    <div class="flex gap-2">
                                        <input type="text" name="message" placeholder="Type a message..." required
                                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg">
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                            {{ __('Send') }}
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @endauth
                    </div>

                    <!-- Review Section -->
                    @if($purchase->status === 'completed' && auth()->id() === $purchase->buyer_id)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('Leave a Review') }}</h3>
                            
                            @if($purchase->review)
                                <div class="p-4 bg-green-100 dark:bg-green-900 rounded-lg mb-4">
                                    <p class="font-semibold text-green-800 dark:text-green-100 mb-2">{{ __('Your Review') }}</p>
                                    <div class="mb-2">
                                        @for($i = 0; $i < $purchase->review->rating; $i++)
                                            <span class="text-yellow-400">★</span>
                                        @endfor
                                        @for($i = $purchase->review->rating; $i < 5; $i++)
                                            <span class="text-gray-400">★</span>
                                        @endfor
                                        <span class="ml-2 font-semibold text-green-800 dark:text-green-100">{{ $purchase->review->rating }}/5</span>
                                    </div>
                                    @if($purchase->review->comment)
                                        <p class="text-green-800 dark:text-green-100">{{ $purchase->review->comment }}</p>
                                    @endif
                                </div>
                            @else
                                <form method="POST" action="{{ route('reviews.store') }}">
                                    @csrf
                                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                    
                                    <div class="mb-6">
                                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                            {{ __('Rating') }}
                                        </label>
                                        <div class="flex gap-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <input type="radio" id="rating_{{ $i }}" name="rating" value="{{ $i }}" 
                                                    class="hidden" required>
                                                <label for="rating_{{ $i }}" class="cursor-pointer text-4xl text-gray-400 hover:text-yellow-400 transition">
                                                    ★
                                                </label>
                                            @endfor
                                        </div>
                                        @error('rating')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label for="comment" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                            {{ __('Comment (Optional)') }}
                                        </label>
                                        <textarea id="comment" name="comment" rows="4"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg @error('comment') border-red-500 @enderror"
                                            placeholder="Share your experience..."></textarea>
                                        @error('comment')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                        {{ __('Submit Review') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Sidebar - Parties Info -->
                <div>
                    <!-- Buyer Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('Buyer') }}</h3>
                        <p class="font-semibold text-gray-900 dark:text-white mb-1">{{ $purchase->buyer->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">@{{ $purchase->buyer->username }}</p>
                    </div>

                    <!-- Seller Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('Seller') }}</h3>
                        <p class="font-semibold text-gray-900 dark:text-white mb-1">{{ $purchase->seller->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">@{{ $purchase->seller->username }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
