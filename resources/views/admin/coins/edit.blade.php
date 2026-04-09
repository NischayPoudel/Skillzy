<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Manage Coins') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $user->name }}</h3>
                        <div class="flex items-center gap-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</div>
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                🪙 {{ number_format($user->coins, 0) }} Coins
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700">
                            <h4 class="text-sm font-bold text-red-800 dark:text-red-200 mb-2">Errors:</h4>
                            <ul class="text-sm text-red-700 dark:text-red-300">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-4 p-4 rounded-lg bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700">
                            <p class="text-sm font-bold text-green-800 dark:text-green-200">✓ {{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('admin.coins.update', $user) }}" method="POST" style="background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%); padding: 24px; border-radius: 12px; border: 1px solid #ddd; dark:bg-gray-700; dark:border-gray-600;">
                        @csrf
                        @method('PUT')
                        
                        <div style="margin-bottom: 24px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">
                                Action
                            </label>
                            <div style="display: flex; gap: 16px;">
                                <label style="display: flex; align-items: center; cursor: pointer;">
                                    <input type="radio" name="action" value="add" required style="margin-right: 8px; cursor: pointer;" @if(old('action') === 'add' || !old('action')) checked @endif>
                                    <span style="font-weight: 500;">Add Coins</span>
                                </label>
                                <label style="display: flex; align-items: center; cursor: pointer;">
                                    <input type="radio" name="action" value="deduct" style="margin-right: 8px; cursor: pointer;" @if(old('action') === 'deduct') checked @endif>
                                    <span style="font-weight: 500;">Deduct Coins</span>
                                </label>
                            </div>
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label for="amount" style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">
                                Amount
                            </label>
                            <input type="number" name="amount" id="amount" placeholder="Enter coin amount" value="{{ old('amount') }}" required style="width: 100%; padding: 10px 12px; border: 2px solid #333; border-radius: 8px; font-size: 16px; font-family: 'Outfit', sans-serif;">
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label for="reason" style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">
                                Reason
                            </label>
                            <textarea name="reason" id="reason" placeholder="E.g., Bonus payment, Adjustment, Refund, etc." rows="3" required style="width: 100%; padding: 10px 12px; border: 2px solid #333; border-radius: 8px; font-size: 16px; font-family: 'Outfit', sans-serif;">{{ old('reason') }}</textarea>
                        </div>

                        <div style="display: flex; gap: 12px;">
                            <button type="submit" style="flex: 1; padding: 12px 16px; background-color: #D02020; color: white; border: 2px solid #121212; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 200ms ease-out;">
                                Update Coins
                            </button>
                            <a href="{{ route('admin.coins.index') }}" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 12px 16px; background-color: #f0f0f0; color: #333; border: 2px solid #121212; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 200ms ease-out;">
                                Cancel
                            </a>
                        </div>
                    </form>

                    <div style="margin-top: 40px;">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Recent Coin Transactions</h4>
                        
                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Reason</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($transactions as $transaction)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                                    @if($transaction->type === 'credit') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                    @endif">
                                                    {{ $transaction->type === 'credit' ? 'Credit' : 'Debit' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($transaction->amount, 0) }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $transaction->reason }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $transaction->created_at->format('M d, Y H:i') }}</div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-600 dark:text-gray-400">
                                                No coin transactions yet
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
