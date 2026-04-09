<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Edit Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Review</h3>
                    
                    <!-- Review Details -->
                    <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Buyer</label>
                                <p class="text-gray-900 dark:text-white">{{ $review->buyer->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Seller</label>
                                <p class="text-gray-900 dark:text-white">{{ $review->seller->name }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Skill</label>
                            <p class="text-gray-900 dark:text-white">{{ $review->purchase->userSkill->skill->name }}</p>
                        </div>
                    </div>

                    <!-- Review Edit Form -->
                    <form method="POST" action="{{ route('admin.reviews.update', $review) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="rating" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Rating (1-5 stars)
                            </label>
                            <select name="rating" id="rating" required class="w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:border-blue-500 transition">
                                <option value="">-- Select Rating --</option>
                                <option value="1" @selected($review->rating === 1)>⭐ 1 - Poor</option>
                                <option value="2" @selected($review->rating === 2)>⭐⭐ 2 - Fair</option>
                                <option value="3" @selected($review->rating === 3)>⭐⭐⭐ 3 - Good</option>
                                <option value="4" @selected($review->rating === 4)>⭐⭐⭐⭐ 4 - Very Good</option>
                                <option value="5" @selected($review->rating === 5)>⭐⭐⭐⭐⭐ 5 - Excellent</option>
                            </select>
                            @error('rating')
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="comment" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Comment
                            </label>
                            <textarea name="comment" id="comment" rows="5" required class="w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:border-blue-500 transition" placeholder="Enter review comment...">{{ old('comment', $review->comment) }}</textarea>
                            @error('comment')
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                                Update Review
                            </button>
                            <a href="{{ route('admin.reviews.index') }}" class="flex-1 px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white font-semibold text-center rounded-lg transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
