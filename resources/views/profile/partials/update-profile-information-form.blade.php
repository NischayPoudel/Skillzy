<section>
    <header style="margin-bottom: 2rem; border-bottom: 4px solid #121212; padding-bottom: 1.5rem;">
        <h2 style="font-size: 1.75rem; font-weight: 900; color: #121212; text-transform: uppercase; letter-spacing: -1px; margin-bottom: 0.5rem;">
            {{ __('Profile Information') }}
        </h2>

        <p style="font-size: 0.95rem; color: #666; font-weight: 500;">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div style="border: 3px solid #121212; padding: 1.5rem; background-color: #F0F0F0;">
            <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Profile Picture</label>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 3px solid #121212;">
                @else
                    <div style="width: 70px; height: 70px; border-radius: 50%; background-color: #E0E0E0; display: flex; align-items: center; justify-content: center; border: 3px solid #121212;">
                        <i class="fas fa-user" style="font-size: 1.8rem; color: #121212;"></i>
                    </div>
                @endif
                <div>
                    <input id="profile_image" name="profile_image" type="file" style="display: block; width: 100%; border: 2px solid #121212; padding: 0.5rem; font-size: 0.9rem;" accept="image/*" />
                    <p style="font-size: 0.8rem; color: #666; margin-top: 0.5rem;">JPG, PNG, or GIF. Max 2MB.</p>
                </div>
            </div>
        </div>

        <div style="border: 3px solid #121212; padding: 1.5rem; background-color: #F0F0F0;">
            <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Name</label>
            <input id="name" name="name" type="text" style="width: 100%; border: 3px solid #121212; padding: 0.75rem 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500;" value="{{ old('name', $user->name) }}" required autofocus />
        </div>

        <div style="border: 3px solid #121212; padding: 1.5rem; background-color: #F0F0F0;">
            <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Email</label>
            <input id="email" name="email" type="email" style="width: 100%; border: 3px solid #121212; padding: 0.75rem 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500;" value="{{ old('email', $user->email) }}" required />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 1rem;">
                    <p style="font-size: 0.9rem; color: #666;">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" style="color: #D02020; text-decoration: underline; background: none; border: none; cursor: pointer; font-weight: 600;">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 0.75rem; font-weight: 600; font-size: 0.9rem; color: #28a745;">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="border: 3px solid #121212; padding: 1.5rem; background-color: #F0F0F0;">
            <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Phone Number</label>
            <input id="phone_number" name="phone_number" type="tel" style="width: 100%; border: 3px solid #121212; padding: 0.75rem 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500;" value="{{ old('phone_number', $user->phone_number) }}" placeholder="+977 9841234567" autocomplete="tel" />
        </div>

        <div style="border: 3px solid #121212; padding: 1.5rem; background-color: #F0F0F0;">
            <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Bio</label>
            <textarea id="bio" name="bio" style="width: 100%; border: 3px solid #121212; padding: 0.75rem 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500; min-height: 120px; resize: vertical;" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div style="border: 3px solid #121212; padding: 1.5rem; background-color: #F0F0F0;">
            <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Transaction PIN</label>
            <input id="transaction_pin" name="transaction_pin" type="password" style="width: 100%; border: 3px solid #121212; padding: 0.75rem 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500;" placeholder="4-digit PIN (numbers only)" maxlength="4" />
            <p style="font-size: 0.8rem; color: #666; margin-top: 0.5rem;">4 digit PIN for transactions. Leave blank to keep current PIN.</p>
        </div>

        <div style="display: flex; align-items: center; gap: 1rem; margin-top: 2rem;">
            <button type="submit" style="background-color: #F0C020; color: #121212; border: 4px solid #121212; font-weight: 900; padding: 1rem 2rem; text-transform: uppercase; font-size: 0.95rem; letter-spacing: 0.5px; cursor: pointer; transition: all 0.2s ease; font-family: 'Outfit', sans-serif;" onmouseover="this.style.transform='translate(-3px, -3px)'; this.style.boxShadow='6px 6px 0px rgba(18, 18, 18, 0.15)';" onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='none';">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p id="profile-saved" style="font-size: 0.9rem; color: #28a745; font-weight: 600; display: block;">
                    ✓ {{ __('Saved successfully!') }}
                </p>
                <script>
                    setTimeout(() => {
                        const msg = document.getElementById('profile-saved');
                        if (msg) msg.style.display = 'none';
                    }, 3000);
                </script>
            @endif
        </div>
    </form>
</section>
