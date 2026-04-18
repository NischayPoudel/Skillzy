<section class="space-y-6">
    <header style="margin-bottom: 2rem; border-bottom: 4px solid #D02020; padding-bottom: 1.5rem;">
        <h2 style="font-size: 1.75rem; font-weight: 900; color: #D02020; text-transform: uppercase; letter-spacing: -1px; margin-bottom: 0.5rem;">
            {{ __('Delete Account') }}
        </h2>

        <p style="font-size: 0.95rem; color: #666; font-weight: 500;">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button id="delete-account-btn" type="button" style="background-color: #D02020; color: white; border: 4px solid #121212; font-weight: 900; padding: 1rem 2rem; text-transform: uppercase; font-size: 0.95rem; letter-spacing: 0.5px; cursor: pointer; transition: all 0.2s ease; font-family: 'Outfit', sans-serif;" onmouseover="this.style.transform='translate(-3px, -3px)'; this.style.boxShadow='6px 6px 0px rgba(208, 32, 32, 0.2)';" onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='none';">
        {{ __('Delete Account') }}
    </button>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('delete-account-btn');
            if (btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const event = new CustomEvent('open-modal-confirm-user-deletion');
                    window.dispatchEvent(event);
                });
            }
        });
    </script>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 style="font-size: 1.3rem; font-weight: 900; color: #D02020; text-transform: uppercase; margin-bottom: 1rem;">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p style="font-size: 0.95rem; color: #666; margin-bottom: 1.5rem; line-height: 1.6;">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">{{ __('Password') }}</label>
                <input id="password" name="password" type="password" style="width: 100%; border: 3px solid #121212; padding: 0.75rem 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500;" placeholder="Enter your password" />
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" x-on:click="$dispatch('close')" style="background-color: white; color: #121212; border: 3px solid #121212; font-weight: 900; padding: 0.75rem 1.5rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; cursor: pointer; transition: all 0.2s ease; font-family: 'Outfit', sans-serif;" onmouseover="this.style.backgroundColor='#F0F0F0';" onmouseout="this.style.backgroundColor='white';">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" style="background-color: #D02020; color: white; border: 4px solid #121212; font-weight: 900; padding: 0.75rem 1.5rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; cursor: pointer; transition: all 0.2s ease; font-family: 'Outfit', sans-serif;" onmouseover="this.style.transform='translate(-2px, -2px)'; this.style.boxShadow='4px 4px 0px rgba(208, 32, 32, 0.2)';" onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='none';">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
