@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Skill</h1>
            <p class="text-gray-600 mt-2">Update skill information</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('skills.update', $skill) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Skill Name
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $skill->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror"
                        placeholder="e.g., PHP, JavaScript, UI Design"
                        required
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description (Optional)
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('description') border-red-500 @enderror"
                        placeholder="Describe this skill..."
                    >{{ old('description', $skill->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon Field -->
                <div class="mb-6">
                    <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">
                        Icon (Optional)
                    </label>
                    <input 
                        type="text" 
                        id="icon" 
                        name="icon" 
                        value="{{ old('icon', $skill->icon) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('icon') border-red-500 @enderror"
                        placeholder="e.g., P, J, U, or D"
                    >
                    @error('icon')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-2">Use letter or icon name</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button 
                        type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200"
                    >
                        Update Skill
                    </button>
                    <a 
                        href="{{ route('skills.show', $skill) }}" 
                        class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors duration-200"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="mt-8 bg-red-50 border-2 border-red-200 rounded-lg p-8">
            <h3 class="text-lg font-bold text-red-600 mb-4">Danger Zone</h3>
            <p class="text-gray-700 mb-4">Deleting this skill will remove it from all users' profiles. This action cannot be undone.</p>
            
            <form action="{{ route('skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Are you absolutely sure? This will delete this skill and all associated listings.')">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors duration-200"
                >
                    Delete Skill
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
