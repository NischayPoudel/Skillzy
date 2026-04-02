<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $listing->skill->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Listing Details -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $listing->skill->name }}</h1>
                            @if($listing->skill->icon)
                                <span class="text-5xl mt-2">{{ $listing->skill->icon }}</span>
                            @endif
                        </div>
                    </div>

                    <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $listing->skill->description }}</p>

                    <div class="grid grid-cols-2 gap-4 mb-6 py-4 border-t border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('Price') }}</p>
                            <p class="text-2xl font-bold text-indigo-600">{{ number_format($listing->price, 2) }} coins</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('Experience Level') }}</p>
                            <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ ucfirst($listing->experience_level) }}</p>
                        </div>
                    </div>

                    @auth
                        @if(auth()->id() !== $listing->user_id)
                            <form method="POST" action="{{ route('purchases.store') }}">
                                @csrf
                                <input type="hidden" name="user_skill_id" value="{{ $listing->id }}">
                                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold">
                                    {{ __('Request Listing') }}
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="p-4 bg-yellow-100 text-yellow-700 rounded-lg mb-4">
                            {{ __('Please login to request this listing') }}
                        </div>
                    @endauth

                    <!-- Reviews Section -->
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('Reviews') }}</h2>
                        
                        @forelse($reviews as $review)
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $review->buyer->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $review->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="flex gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-yellow-400">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400">{{ __('No reviews yet') }}</p>
                        @endforelse
                    </div>
                </div>

                <!-- Seller Info -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 h-fit">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Seller') }}</h3>
                    
                    @if($listing->user->profile_image)
                        <img src="{{ asset('storage/' . $listing->user->profile_image) }}" alt="{{ $listing->user->name }}" class="w-full rounded-lg mb-4">
                    @else
                        <div class="w-full h-32 bg-gray-300 dark:bg-gray-600 rounded-lg mb-4 flex items-center justify-center">
                            <span class="text-gray-600 dark:text-gray-300">No image</span>
                        </div>
                    @endif

                    <p class="font-semibold text-gray-900 dark:text-white mb-1">{{ $listing->user->name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">@username: {{ $listing->user->username }}</p>
                    
                    @if($listing->user->bio)
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $listing->user->bio }}</p>
                    @endif

                    <div class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Member since') }} {{ $listing->user->created_at->format('M Y') }}</p>
                    </div>

                    <div class="mb-4 text-center p-3 bg-gray-100 dark:bg-gray-900 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Average Rating') }}</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">
                            @php
                                $avgRating = $listing->purchases()
                                    ->where('status', 'completed')
                                    ->with('review')
                                    ->get()
                                    ->mapWithKeys(fn($p) => $p->review ? [$p->id => $p->review->rating] : [])
                                    ->average();
                            @endphp
                            {{ $avgRating ? round($avgRating, 1) : 'N/A' }}
                        </p>
                    </div>

                    <a href="#" class="block w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-center">
                        {{ __('View Profile') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
