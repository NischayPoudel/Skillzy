<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Edit Purchase Status') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Update Purchase Status</h3>
                    
                    <!-- Purchase Details -->
                    <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Buyer</label>
                                <p class="text-gray-900 dark:text-white">{{ $purchase->buyer->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Seller</label>
                                <p class="text-gray-900 dark:text-white">{{ $purchase->seller->name }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Skill</label>
                                <p class="text-gray-900 dark:text-white">{{ $purchase->userSkill->skill->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Amount</label>
                                <p class="text-gray-900 dark:text-white">${{ number_format($purchase->amount, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Update Form -->
                    <form method="POST" action="{{ route('admin.purchases.update', $purchase) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Purchase Status
                            </label>
                            <select name="status" id="status" required class="w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:border-blue-500 transition">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @selected($purchase->status === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                                Update Status
                            </button>
                            <a href="{{ route('admin.purchases.index') }}" class="flex-1 px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white font-semibold text-center rounded-lg transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
