<x-staff-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit User</h3>
                    
                    <form action="{{ route('staff.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div style="margin-bottom: 24px;">
                            <label for="name" style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">
                                Full Name
                            </label>
                            <input type="text" name="name" id="name" placeholder="Enter user name" value="{{ $user->name }}" required style="width: 100%; padding: 10px 12px; border: 2px solid #333; border-radius: 8px; font-size: 16px; font-family: 'Outfit', sans-serif;">
                            @error('name')
                                <p style="color: #D02020; font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label for="email" style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">
                                Email Address
                            </label>
                            <input type="email" name="email" id="email" placeholder="Enter email address" value="{{ $user->email }}" required style="width: 100%; padding: 10px 12px; border: 2px solid #333; border-radius: 8px; font-size: 16px; font-family: 'Outfit', sans-serif;">
                            @error('email')
                                <p style="color: #D02020; font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label for="profile_image" style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">
                                Profile Picture
                            </label>
                            <div style="border: 2px dashed #333; border-radius: 8px; padding: 24px; text-align: center; cursor: pointer;" id="upload-area">
                                <input type="file" name="profile_image" id="profile_image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                                <div id="upload-prompt" style="display: {{ $user->profile_image ? 'none' : 'block' }};">
                                    <p style="margin: 0; font-size: 14px; color: #666;">
                                        Click to upload or drag and drop<br>
                                        <span style="font-size: 12px; color: #999;">PNG, JPG, GIF, WebP (Max 2MB)</span>
                                    </p>
                                </div>
                                @if($user->profile_image)
                                    <img id="preview" src="{{ asset('storage/' . $user->profile_image) }}" style="max-width: 200px; max-height: 200px; margin-top: 12px; border-radius: 8px;">
                                @else
                                    <img id="preview" style="display: none; max-width: 200px; max-height: 200px; margin-top: 12px; border-radius: 8px;">
                                @endif
                            </div>
                            @error('profile_image')
                                <p style="color: #D02020; font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="display: flex; gap: 12px;">
                            <button type="submit" style="flex: 1; padding: 12px 16px; background-color: #D02020; color: white; border: 2px solid #121212; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 200ms ease-out;">
                                Update User
                            </button>
                            <a href="{{ route('staff.users.index') }}" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 12px 16px; background-color: #f0f0f0; color: #333; border: 2px solid #121212; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 200ms ease-out;">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const uploadArea = document.getElementById('upload-area');
        const fileInput = document.getElementById('profile_image');
        const uploadPrompt = document.getElementById('upload-prompt');
        const preview = document.getElementById('preview');

        uploadArea.addEventListener('click', () => fileInput.click());

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.style.backgroundColor = '#f0f0f0';
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.style.backgroundColor = 'transparent';
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.style.backgroundColor = 'transparent';
            fileInput.files = e.dataTransfer.files;
            previewImage({target: {files: e.dataTransfer.files}});
        });

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    uploadPrompt.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-staff-layout>
