<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Skill') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('skills.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('Name') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg @error('name') border-red-500 @enderror" required>
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('Description') }}</label>
                        <textarea name="description" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg @error('description') border-red-500 @enderror" rows="4">{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('Icon') }}</label>
                        <input type="text" name="icon" value="{{ old('icon') }}" placeholder="e.g., icon-name or emoji" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg @error('icon') border-red-500 @enderror">
                        @error('icon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">{{ __('Create') }}</button>
                        <a href="{{ route('skills.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
