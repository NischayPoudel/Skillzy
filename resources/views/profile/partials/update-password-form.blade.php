<section>
    <header style="margin-bottom: 2rem; border-bottom: 4px solid #121212; padding-bottom: 1.5rem;">
        <h2 style="font-size: 1.75rem; font-weight: 900; color: #121212; text-transform: uppercase; letter-spacing: -1px; margin-bottom: 0.5rem;">
            {{ __('Update Password') }}
        </h2>

        <p style="font-size: 0.95rem; color: #666; font-weight: 500;">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div style="border: 3px solid #121212; padding: 1.5rem; background-color: #F0F0F0;">
            <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" style="width: 100%; border: 3px solid #121212; padding: 0.75rem 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500;" autocomplete="current-password" />
        </div>

        <div style="border: 3px solid #121212; padding: 1.5rem; background-color: #F0F0F0;">
            <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">New Password</label>
            <input id="update_password_password" name="password" type="password" style="width: 100%; border: 3px solid #121212; padding: 0.75rem 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500;" autocomplete="new-password" />
        </div>

        <div style="border: 3px solid #121212; padding: 1.5rem; background-color: #F0F0F0;">
            <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" style="width: 100%; border: 3px solid #121212; padding: 0.75rem 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500;" autocomplete="new-password" />
        </div>

        <div style="display: flex; align-items: center; gap: 1rem; margin-top: 2rem;">
            <button type="submit" style="background-color: #F0C020; color: #121212; border: 4px solid #121212; font-weight: 900; padding: 1rem 2rem; text-transform: uppercase; font-size: 0.95rem; letter-spacing: 0.5px; cursor: pointer; transition: all 0.2s ease; font-family: 'Outfit', sans-serif;" onmouseover="this.style.transform='translate(-3px, -3px)'; this.style.boxShadow='6px 6px 0px rgba(18, 18, 18, 0.15)';" onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='none';">
                {{ __('Save Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p id="password-saved" style="font-size: 0.9rem; color: #28a745; font-weight: 600; display: block;">
                    ✓ {{ __('Password updated successfully!') }}
                </p>
                <script>
                    setTimeout(() => {
                        const msg = document.getElementById('password-saved');
                        if (msg) msg.style.display = 'none';
                    }, 3000);
                </script>
            @endif
        </div>
    </form>
</section>
