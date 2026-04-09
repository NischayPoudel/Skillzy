<x-app-layout>
    <!-- Hero Section with Image -->
    <div style="background: white; border-bottom: 1px solid #e5e7eb;">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem;">
            <!-- Image Display -->
            <div style="width: 100%; aspect-ratio: 16/5.5; background: linear-gradient(135deg, #1040C0 0%, #0D32A4 100%); border-radius: 12px; overflow: hidden; margin: 24px 0; display: flex; align-items: center; justify-content: center; position: relative; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                @if($listing->skill->icon)
                    @if(str_contains($listing->skill->icon, '/') || str_contains($listing->skill->icon, '.'))
                        <!-- File path - display as image -->
                        <img src="{{ asset('storage/' . $listing->skill->icon) }}" alt="{{ $listing->skill->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    @else
                        <!-- Emoji - display as text -->
                        <div style="font-size: 120px; line-height: 1; display: flex; align-items: center; justify-content: center;">{{ $listing->skill->icon }}</div>
                    @endif
                @else
                    <div style="display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 16px; color: white;">
                        <p style="font-size: 20px; font-weight: 600; color: rgba(255,255,255,0.8);">{{ $listing->skill->name }}</p>
                    </div>
                @endif
            </div>

            <!-- Title Section -->
            <div style="padding: 24px 0;">
                <h1 style="font-size: 40px; font-weight: 900; color: #1f2937; margin: 0 0 8px 0; line-height: 1.1;">{{ $listing->skill->name }}</h1>
                <p style="font-size: 16px; color: #6b7280; margin: 0;">
                    <span style="font-weight: 600;">by</span> 
                    <span style="color: #1040C0; font-weight: 700;">{{ $listing->user->name }}</span>
                </p>
            </div>
        </div>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 40px 2rem;">
        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 40px;">
            <!-- Main Content -->
            <div>
                <!-- Description Card -->
                <div style="background: white; border-radius: 12px; padding: 32px; margin-bottom: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
                    <h2 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0 0 16px 0;">About this skill</h2>
                    <p style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0;">{{ $listing->skill->description }}</p>
                </div>

                <!-- Pricing & Details Card -->
                <div style="background: white; border-radius: 12px; padding: 32px; margin-bottom: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
                        <!-- Price -->
                        <div>
                            <p style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 8px 0;">Price</p>
                            <p style="font-size: 36px; font-weight: 900; color: #1040C0; margin: 0; display: flex; align-items: baseline; gap: 4px;">
                                {{ number_format($listing->price, 0) }}
                                <span style="font-size: 16px; font-weight: 600; color: #9ca3af;">coins</span>
                            </p>
                        </div>
                        
                        <!-- Experience Level -->
                        <div>
                            <p style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 8px 0;">Experience Level</p>
                            <div style="display: inline-block; padding: 8px 16px; background: #f0f4ff; border: 2px solid #1040C0; border-radius: 6px; font-weight: 700; color: #1040C0; font-size: 14px;">
                                {{ ucfirst($listing->experience_level) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                @auth
                    @if(auth()->id() !== $listing->user_id)
                        @if(auth()->user()->coins < $listing->price)
                            <div style="background: #fee2e2; border: 2px solid #ef4444; border-radius: 8px; padding: 16px; margin-bottom: 32px;">
                                <p style="font-weight: 600; color: #dc2626; margin: 0 0 4px 0;">✕ Insufficient Coins</p>
                                <p style="color: #dc2626; font-size: 14px; margin: 0;">You need {{ number_format($listing->price, 0) }} coins to request this listing. You currently have {{ number_format(auth()->user()->coins, 0) }} coins.</p>
                            </div>
                        @else
                            <!-- Request Listing Button -->
                            <button 
                                type="button" 
                                onclick="openPinModal()"
                                style="width: 100%; padding: 16px 24px; background: linear-gradient(135deg, #FFC107 0%, #FFB300 100%); color: #1a1a1a; border: none; border-radius: 8px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 300ms ease; box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3); margin-bottom: 32px;" 
                                onmouseover="this.style.boxShadow='0 8px 20px rgba(255, 193, 7, 0.4)'; this.style.transform='translateY(-2px)';" 
                                onmouseout="this.style.boxShadow='0 4px 12px rgba(255, 193, 7, 0.3)'; this.style.transform='translateY(0)';">
                                Request Listing
                            </button>

                            <!-- PIN Modal -->
                            <div id="pinModal">
                                <div style="background: white; border-radius: 12px; padding: 40px; max-width: 400px; width: 90%; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); animation: slideUp 300ms ease;">
                                    <!-- Modal Header -->
                                    <div style="margin-bottom: 24px;">
                                        <h3 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 8px 0;">Confirm Purchase</h3>
                                        <p style="color: #6b7280; font-size: 14px; margin: 0;">Enter your Transaction PIN to proceed</p>
                                    </div>

                                    <!-- Form -->
                                    <form method="POST" action="{{ route('purchases.store') }}" id="pinForm" style="margin-bottom: 0;">
                                        @csrf
                                        <input type="hidden" name="user_skill_id" value="{{ $listing->id }}">
                                        
                                        <!-- PIN Input -->
                                        <div style="margin-bottom: 24px;">
                                            <label style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 8px; font-size: 14px;">
                                                Transaction PIN <span style="color: #ef4444;">*</span>
                                            </label>
                                            <input 
                                                type="password" 
                                                id="transactionPin"
                                                name="transaction_pin" 
                                                placeholder="Enter 4-digit PIN" 
                                                maxlength="4"
                                                inputmode="numeric"
                                                style="width: 100%; padding: 14px 16px; border: 2px solid {{ $errors->has('transaction_pin') ? '#ef4444' : '#e5e7eb' }}; border-radius: 8px; font-size: 18px; font-weight: 600; letter-spacing: 6px; text-align: center; transition: all 200ms ease; box-sizing: border-box;"
                                                onfocus="this.style.borderColor='#1040C0'; this.style.boxShadow='0 0 0 3px rgba(16, 64, 192, 0.1)';"
                                                onblur="this.style.borderColor='{{ $errors->has('transaction_pin') ? '#ef4444' : '#e5e7eb' }}'; this.style.boxShadow='none';"
                                                value="{{ old('transaction_pin') }}"
                                                required
                                                autofocus/>
                                            
                                            @if($errors->has('transaction_pin'))
                                                <div style="background: #fee2e2; border: 1px solid #fecaca; border-radius: 6px; padding: 8px 12px; margin-top: 8px;">
                                                    <p style="color: #dc2626; font-size: 13px; margin: 0; font-weight: 500;">
                                                        @foreach($errors->get('transaction_pin') as $message)
                                                            {{ $message }}<br>
                                                        @endforeach
                                                    </p>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Cost Info -->
                                        <div style="background: #f0f4ff; border-radius: 8px; padding: 12px; margin-bottom: 24px; border-left: 4px solid #1040C0;">
                                            <p style="font-size: 12px; color: #6b7280; margin: 0 0 4px 0; text-transform: uppercase; font-weight: 600;">Cost</p>
                                            <p style="font-size: 18px; font-weight: 700; color: #1040C0; margin: 0;">{{ number_format($listing->price, 0) }} coins</p>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div style="display: flex; gap: 12px;">
                                            <button 
                                                type="button" 
                                                onclick="closePinModal()"
                                                style="flex: 1; padding: 12px 16px; background: #f3f4f6; color: #1f2937; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 200ms ease;"
                                                onmouseover="this.style.background='#e5e7eb'; this.style.borderColor='#d1d5db';"
                                                onmouseout="this.style.background='#f3f4f6'; this.style.borderColor='#e5e7eb';">
                                                Cancel
                                            </button>
                                            <button 
                                                type="submit" 
                                                style="flex: 1; padding: 12px 16px; background: linear-gradient(135deg, #FFC107 0%, #FFB300 100%); color: #1a1a1a; border: none; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 200ms ease; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.2);"
                                                onmouseover="this.style.boxShadow='0 4px 12px rgba(255, 193, 7, 0.3)'; this.style.transform='translateY(-1px)';"
                                                onmouseout="this.style.boxShadow='0 2px 8px rgba(255, 193, 7, 0.2)'; this.style.transform='translateY(0)';">
                                                Confirm
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal Styles & Scripts -->
                            <style>
                                #pinModal {
                                    display: none !important;
                                    position: fixed;
                                    top: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 100%;
                                    background: rgba(0, 0, 0, 0.5);
                                    z-index: 1000;
                                    align-items: center;
                                    justify-content: center;
                                    opacity: 0;
                                    transition: opacity 300ms ease;
                                }
                                #pinModal.show {
                                    display: flex !important;
                                    opacity: 1;
                                }
                                #pinModal.show > div {
                                    animation: slideUp 300ms ease;
                                }
                                @keyframes slideUp {
                                    from {
                                        transform: translateY(30px);
                                        opacity: 0;
                                    }
                                    to {
                                        transform: translateY(0);
                                        opacity: 1;
                                    }
                                }
                            </style>

                            <script>
                                function openPinModal() {
                                    const modal = document.getElementById('pinModal');
                                    modal.classList.add('show');
                                    document.getElementById('transactionPin').focus();
                                    document.body.style.overflow = 'hidden';
                                }

                                function closePinModal() {
                                    const modal = document.getElementById('pinModal');
                                    modal.classList.remove('show');
                                    document.body.style.overflow = 'auto';
                                    document.getElementById('transactionPin').value = '';
                                }

                                // Check if there are PIN errors on page load
                                window.addEventListener('load', function() {
                                    @if($errors->has('transaction_pin'))
                                        openPinModal();
                                    @endif
                                });

                                // Close modal when clicking outside
                                document.getElementById('pinModal')?.addEventListener('click', function(e) {
                                    if (e.target === this) {
                                        closePinModal();
                                    }
                                });

                                // Close modal on Escape key
                                document.addEventListener('keydown', function(e) {
                                    if (e.key === 'Escape' && document.getElementById('pinModal')?.classList.contains('show')) {
                                        closePinModal();
                                    }
                                });
                            </script>
                        @endif
                    @endif
                @else
                    <div style="background: #fff3cd; border: 2px solid #FFC107; border-radius: 8px; padding: 16px; margin-bottom: 32px;">
                        <p style="font-weight: 600; color: #856404; margin: 0 0 4px 0;">Login Required</p>
                        <p style="color: #856404; font-size: 14px; margin: 0;">Please sign in to request this listing</p>
                    </div>
                @endauth

                <!-- Reviews Section -->
                <div style="background: white; border-radius: 12px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
                    <h2 style="font-size: 20px; font-weight: 700; color: #1f2937; margin: 0 0 24px 0;">Reviews from buyers</h2>
                    
                    @forelse($reviews as $review)
                        <div style="display: flex; gap: 16px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid #e5e7eb;">
                            <!-- Reviewer Avatar -->
                            <div style="flex: 0 0 48px;">
                                @if($review->buyer->profile_image)
                                    <img src="{{ asset('storage/' . $review->buyer->profile_image) }}" alt="{{ $review->buyer->name }}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #d1d5db;">
                                @else
                                    <div style="width: 48px; height: 48px; border-radius: 50%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-weight: 700; font-size: 14px;">
                                        {{ substr($review->buyer->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Review Content -->
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                    <div>
                                        <p style="font-weight: 600; color: #1f2937; margin: 0; font-size: 15px;">{{ $review->buyer->name }}</p>
                                        <p style="font-size: 13px; color: #9ca3af; margin: 4px 0 0 0;">{{ $review->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div style="display: flex; gap: 2px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span style="color: {{ $i <= $review->rating ? '#FFC107' : '#e5e7eb' }}; font-size: 16px;">★</span>
                                        @endfor
                                    </div>
                                </div>
                                <p style="color: #4b5563; font-size: 14px; line-height: 1.6; margin: 0;">{{ $review->comment }}</p>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 32px; background: #f9fafb; border-radius: 8px;">
                            <p style="color: #9ca3af; font-size: 15px; margin: 0;">No reviews yet. Be the first to review this skill!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Seller Card -->
                <div style="background: white; border-radius: 12px; padding: 28px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e5e7eb; position: sticky; top: 100px;">
                    <p style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 16px 0;">Seller Information</p>
                    
                    <!-- Seller Avatar -->
                    <div style="margin-bottom: 20px;">
                        @if($listing->user->profile_image)
                            <img src="{{ asset('storage/' . $listing->user->profile_image) }}" alt="{{ $listing->user->name }}" style="width: 100%; aspect-ratio: 1; border-radius: 8px; object-fit: cover; border: 2px solid #d1d5db;">
                        @else
                            <div style="width: 100%; aspect-ratio: 1; background: linear-gradient(135deg, #f0f4f6 0%, #e5e7eb 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; color: #9ca3af; font-weight: 600; border: 2px solid #e5e7eb;">No Image</div>
                        @endif
                    </div>

                    <!-- Seller Name & Username -->
                    <p style="font-weight: 700; color: #1f2937; margin: 0 0 4px 0; font-size: 16px;">{{ $listing->user->name }}</p>
                    @if($listing->user->username)
                        <p style="font-size: 13px; color: #1040C0; margin: 0 0 12px 0; font-weight: 600;">{{ $listing->user->username }}</p>
                    @endif
                    
                    @if($listing->user->bio)
                        <p style="color: #6b7280; font-size: 13px; line-height: 1.5; margin: 0 0 16px 0;">{{ $listing->user->bio }}</p>
                    @endif

                    <!-- Member Stats -->
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; margin: 16px 0;">
                        <div style="text-align: center;">
                            <p style="font-size: 11px; color: #9ca3af; text-transform: uppercase; font-weight: 600; margin: 0;">Member Since</p>
                            <p style="font-size: 14px; font-weight: 700; color: #1f2937; margin: 4px 0 0 0;">{{ $listing->user->created_at->format('M Y') }}</p>
                        </div>
                    </div>

                    <!-- Rating Badge -->
                    <div style="background: linear-gradient(135deg, #f0f4ff 0%, #e5e7ff 100%); border-radius: 8px; padding: 16px; text-align: center; margin: 16px 0;">
                        <p style="font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; margin: 0 0 8px 0;">Average Rating</p>
                        <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                            <p style="font-size: 32px; font-weight: 900; color: #1040C0; margin: 0;">
                                @php
                                    $avgRating = $listing->purchases()
                                        ->where('status', 'completed')
                                        ->with('review')
                                        ->get()
                                        ->mapWithKeys(fn($p) => $p->review ? [$p->id => $p->review->rating] : [])
                                        ->average();
                                @endphp
                                {{ $avgRating ? round($avgRating, 1) : 'N/A' }}
                            </p>
                            @if($avgRating)
                                <div style="display: flex; gap: 2px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span style="color: #FFC107; font-size: 16px;">{{ $i <= round($avgRating) ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @auth
                        @if(auth()->id() !== $listing->user_id)
                            <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 20px;">
                                <x-message-modal :listing="$listing" />
                                <a href="{{ route('profile.public', $listing->user_id) }}" style="display: block; padding: 12px 16px; background: #f3f4f6; color: #1040C0; border: 2px solid #1040C0; border-radius: 6px; text-align: center; text-decoration: none; font-weight: 700; font-size: 14px; transition: all 200ms ease;" onmouseover="this.style.background='#e5e7eb'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#f3f4f6'; this.style.transform='translateY(0)';">
                                    View Profile
                                </a>
                            </div>
                        @else
                            <a href="{{ route('profile.show') }}" style="display: block; width: 100%; padding: 12px 16px; background: #f3f4f6; color: #1040C0; border: 2px solid #1040C0; border-radius: 6px; text-align: center; text-decoration: none; font-weight: 700; font-size: 14px; transition: all 200ms ease; margin-top: 20px;" onmouseover="this.style.background='#e5e7eb'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#f3f4f6'; this.style.transform='translateY(0)';">
                                View Your Profile
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" style="display: block; width: 100%; padding: 12px 16px; background: #1040C0; color: white; border: 2px solid #1040C0; border-radius: 6px; text-align: center; text-decoration: none; font-weight: 700; font-size: 14px; transition: all 200ms ease; margin-top: 20px;" onmouseover="this.style.background='#0D32A4'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#1040C0'; this.style.transform='translateY(0)';">
                            Login to Message
                        </a>
                    @endauth

                    <!-- Seller Status -->
                    <div style="margin-top: 20px; padding: 12px; background: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 4px;">
                        <p style="font-size: 12px; color: #166534; font-weight: 600; margin: 0;">✓ Verified Professional</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
