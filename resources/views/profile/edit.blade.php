<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div style="background-color: #F0F0F0; padding: 3rem 1.5rem; min-height: 100vh;">
        <div style="max-width: 900px; margin: 0 auto;">
            <!-- Profile Information Section -->
            <div style="background: white; border: 4px solid #121212; padding: 2rem; margin-bottom: 2rem; box-shadow: 8px 8px 0px rgba(18, 18, 18, 0.1);">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Section -->
            <div style="background: white; border: 4px solid #121212; padding: 2rem; margin-bottom: 2rem; box-shadow: 8px 8px 0px rgba(18, 18, 18, 0.1);">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Section -->
            <div style="background: white; border: 4px solid #D02020; padding: 2rem; margin-bottom: 2rem; box-shadow: 8px 8px 0px rgba(208, 32, 32, 0.1);">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
