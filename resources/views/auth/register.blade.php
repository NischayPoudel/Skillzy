<x-guest-layout>
    <div class="auth-title">
        <h2>Create Account</h2>
        <p class="auth-subtitle">Join Skillzy and start sharing your skills</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-error mb-4">
            <ul class="mt-2 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="field">
            <label for="name">{{ __('Full Name') }}</label>
            <input id="name" class="input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
        </div>

        <div class="field">
            <label for="email">{{ __('Email Address') }}</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
        </div>

        <div class="field">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" class="input" type="password" name="password" required autocomplete="new-password" />
        </div>

        <div class="field">
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="input" type="password" name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="field">
            <label for="phone_number">{{ __('Phone Number') }} <span class="text-gray-500">(Optional - for support)</span></label>
            <input id="phone_number" class="input" type="tel" name="phone_number" value="{{ old('phone_number') }}" placeholder="+1 234 567 8900" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <div class="field">
            <label for="transaction_pin">{{ __('Transaction PIN') }} <span class="text-red-500">*</span></label>
            <input id="transaction_pin" class="input" type="password" name="transaction_pin" required placeholder="Enter 4 digit PIN" maxlength="4" autocomplete="off" />
            <p class="text-sm text-gray-600 mt-1">Create a 4-digit PIN for transferring Skillzy coins</p>
            <x-input-error :messages="$errors->get('transaction_pin')" class="mt-2" />
        </div>

        <button type="submit" class="btn btn-primary">
            {{ __('Create Account') }}
        </button>

        <div class="auth-footer">
            <p>Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign In</a></p>
        </div>
    </form>
</x-guest-layout>
