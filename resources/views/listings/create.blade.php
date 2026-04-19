<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Listing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('user.listings.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('Skill') }}</label>
                        <select name="skill_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg @error('skill_id') border-red-500 @enderror" required>
                            <option value="">Select a skill</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" @if(old('skill_id') == $skill->id) selected @endif>{{ $skill->name }}</option>
                            @endforeach
                        </select>
                        @error('skill_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('Price (coins)') }}</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0.01" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg @error('price') border-red-500 @enderror" required>
                        @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ __('Experience Level') }}</label>
                        <select name="experience_level" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg @error('experience_level') border-red-500 @enderror" required>
                            <option value="">Select level</option>
                            <option value="beginner" @if(old('experience_level') === 'beginner') selected @endif>Beginner</option>
                            <option value="intermediate" @if(old('experience_level') === 'intermediate') selected @endif>Intermediate</option>
                            <option value="expert" @if(old('experience_level') === 'expert') selected @endif>Expert</option>
                        </select>
                        @error('experience_level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="px-4 py-2 bg-yellow-400 text-black font-bold rounded-lg hover:bg-yellow-500">{{ __('Create') }}</button>
                        <a href="{{ route('user.listings.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
