<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $skill->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $skill->name }}</h1>
                        
                        @if($skill->icon)
                            <div class="text-4xl mb-4">{{ $skill->icon }}</div>
                        @endif

                        <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $skill->description }}</p>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Created By') }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $skill->creator->name }}</p>
                        </div>

                        @if(in_array(auth()->user()->role, ['admin', 'staff']))
                            <div class="flex gap-4">
                                <a href="{{ route('skills.edit', $skill) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">{{ __('Edit') }}</a>
                                <form method="POST" action="{{ route('skills.destroy', $skill) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700" onclick="return confirm('Are you sure?')">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Active Listings') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $skill->userSkills()->where('status', 'active')->count() }}</p>
                        <a href="#" class="text-blue-600 hover:text-blue-900">{{ __('View All Listings') }}</a>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Listings for this Skill') }}</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Seller') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Price') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Level') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($skill->userSkills()->where('status', 'active')->get() as $listing)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $listing->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ number_format($listing->price, 2) }} coins</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ ucfirst($listing->experience_level) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="#" class="text-blue-600 hover:text-blue-900">{{ __('View') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">{{ __('No active listings') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
