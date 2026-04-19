<x-app-layout>
    <!-- Premium Hero Section -->
    <div style="background: #1040C0; position: relative; overflow: hidden;">
        <!-- Decorative Elements -->
        <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: rgba(255, 193, 7, 0.1); border-radius: 50%; filter: blur(40px);"></div>
        <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: rgba(16, 64, 192, 0.1); border-radius: 50%; filter: blur(40px);"></div>
        
        <div style="max-width: 1400px; margin: 0 auto; padding: 60px 2rem; position: relative; z-index: 1;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
                <!-- Left: Image -->
                <div style="display: flex; align-items: center; justify-content: center;">
                    <div style="width: 100%; aspect-ratio: 1; background: white; border-radius: 20px; overflow: hidden; display: flex; align-items: center; justify-content: center; box-shadow: 0 25px 50px rgba(0,0,0,0.3); border: 3px solid rgba(255,255,255,0.1);">
                        @if($listing->skill->icon)
                            @if(str_contains($listing->skill->icon, '/') || str_contains($listing->skill->icon, '.'))
                                <img src="{{ asset('storage/' . $listing->skill->icon) }}" alt="{{ $listing->skill->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="font-size: 140px;">{{ $listing->skill->icon }}</div>
                            @endif
                        @else
                            <div style="font-size: 100px; color: #d1d5db;">S</div>
                        @endif
                    </div>
                </div>
                
                <!-- Right: Content -->
                <div style="color: white;">
                    <div style="display: inline-block; background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 50px; margin-bottom: 20px; font-size: 13px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">
                        Featured Skill
                    </div>
                    <h1 style="font-size: 56px; font-weight: 900; margin: 0 0 16px 0; line-height: 1.1; color: white;">{{ $listing->skill->name }}</h1>
                    <p style="font-size: 18px; color: rgba(255,255,255,0.85); margin: 0 0 24px 0; line-height: 1.6;">{{ $listing->skill->description }}</p>
                    <div style="display: flex; align-items: center; gap: 12px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.2);">
                        @if($listing->user->profile_image)
                            <img src="{{ asset('storage/' . $listing->user->profile_image) }}" alt="{{ $listing->user->name }}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                        @else
                            <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 16px; border: 2px solid white;">{{ substr($listing->user->name, 0, 1) }}</div>
                        @endif
                        <div>
                            <p style="font-weight: 700; margin: 0; color: white;">{{ $listing->user->name }}</p>
                            <p style="font-size: 13px; color: rgba(255,255,255,0.7); margin: 4px 0 0 0;">Skill Instructor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div style="max-width: 1400px; margin: 0 auto; padding: 60px 2rem;">
        <div style="display: grid; grid-template-columns: 1fr 420px; gap: 50px;">
            <!-- Left: Main Content -->
            <div>
                <!-- About Section -->
                <div style="background: white; border-radius: 16px; padding: 40px; margin-bottom: 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; transition: all 300ms ease;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)'">
                    <h2 style="font-size: 22px; font-weight: 800; color: #1f2937; margin: 0 0 16px 0; letter-spacing: -0.5px;">About this skill</h2>
                    <p style="color: #4b5563; font-size: 16px; line-height: 1.8; margin: 0;">{{ $listing->skill->description }}</p>
                </div>

                <!-- Key Details Grid -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px;">
                    <!-- Price Card -->
                    <div style="background: linear-gradient(135deg, #fff8e1 0%, #fffaed 100%); border-radius: 16px; padding: 32px; border: 2px solid #ffd666; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,214,0,0.1); border-radius: 50%; filter: blur(20px);"></div>
                        <p style="font-size: 12px; font-weight: 700; color: #ff9800; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 12px 0;">Price</p>
                        <p style="font-size: 42px; font-weight: 900; color: #ff6f00; margin: 0; display: flex; align-items: baseline; gap: 8px;">
                            {{ number_format($listing->price, 0) }}
                            <span style="font-size: 16px; font-weight: 600; color: #f57c00;">coins</span>
                        </p>
                    </div>
                    
                    <!-- Experience Level Card -->
                    <div style="background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%); border-radius: 16px; padding: 32px; border: 2px solid #ce93d8; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(206,147,216,0.1); border-radius: 50%; filter: blur(20px);"></div>
                        <p style="font-size: 12px; font-weight: 700; color: #7b1fa2; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 12px 0;">Level</p>
                        <div style="display: inline-block; padding: 12px 20px; background: white; border: 2px solid #ce93d8; border-radius: 12px; font-weight: 800; color: #7b1fa2; font-size: 16px; text-transform: capitalize;">
                            {{ $listing->experience_level }}
                        </div>
                    </div>
                </div>

                <!-- Call to Action Section -->
                @auth
                    @if(auth()->id() !== $listing->user_id)
                        @if($hasActivePurchase)
                            <!-- Already has active request -->
                            <div style="background: linear-gradient(135deg, #f0fdf4 0%, #f1fdf9 100%); border: 2px solid #22c55e; border-radius: 16px; padding: 24px; margin-bottom: 40px; position: relative; overflow: hidden;">
                                <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(34,197,94,0.1); border-radius: 50%; filter: blur(20px);"></div>
                                <p style="font-weight: 700; color: #16a34a; margin: 0 0 8px 0; font-size: 16px;">Request Active</p>
                                <p style="color: #15803d; font-size: 14px; margin: 0; line-height: 1.6;">You have an active request for this skill. Complete it before creating another one.</p>
                            </div>
                        @elseif(auth()->user()->coins < $listing->price)
                            <div style="background: linear-gradient(135deg, #fee2e2 0%, #fef2f2 100%); border: 2px solid #ef4444; border-radius: 16px; padding: 24px; margin-bottom: 40px; position: relative; overflow: hidden;">
                                <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(239,68,68,0.1); border-radius: 50%; filter: blur(20px);"></div>
                                <p style="font-weight: 700; color: #dc2626; margin: 0 0 8px 0; font-size: 16px;">Insufficient Coins</p>
                                <p style="color: #b91c1c; font-size: 14px; margin: 0;">You need <strong>{{ number_format($listing->price, 0) }} coins</strong> but have <strong>{{ number_format(auth()->user()->coins, 0) }} coins</strong></p>
                            </div>
                        @else
                            <!-- Request Listing Button -->
                            <button 
                                type="button" 
                                onclick="openPinModal()"
                                style="width: 100%; padding: 18px 24px; background: linear-gradient(135deg, #FFC107 0%, #FFB300 100%); color: #1a1a1a; border: none; border-radius: 12px; font-size: 18px; font-weight: 800; cursor: pointer; transition: all 300ms ease; box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3); margin-bottom: 40px; text-transform: uppercase; letter-spacing: 0.5px;" 
                                onmouseover="this.style.boxShadow='0 12px 30px rgba(255, 193, 7, 0.5)'; this.style.transform='translateY(-3px)';" 
                                onmouseout="this.style.boxShadow='0 8px 20px rgba(255, 193, 7, 0.3)'; this.style.transform='translateY(0)';">
                                Request This Skill Now
                            </button>

                            <!-- PIN Modal -->
                            <div id="pinModal">
                                <div style="background: white; border-radius: 20px; padding: 50px; max-width: 450px; width: 90%; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3); animation: slideUp 300ms ease;">
                                    <!-- Close Button -->
                                    <button onclick="closePinModal()" style="position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 28px; cursor: pointer; color: #9ca3af; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;" onmouseover="this.style.background='#f3f4f6'; this.style.color='#1f2937';" onmouseout="this.style.background='none'; this.style.color='#9ca3af';">×</button>
                                    
                                    <!-- Modal Header -->
                                    <div style="margin-bottom: 32px; text-align: center;">
                                        <h3 style="font-size: 28px; font-weight: 900; color: #1f2937; margin: 0 0 8px 0;">Confirm Purchase</h3>
                                        <p style="color: #6b7280; font-size: 15px; margin: 0;">Enter your 4-digit Transaction PIN to proceed</p>
                                    </div>

                                    <!-- Form -->
                                    <form method="POST" action="{{ route('purchases.store') }}" id="pinForm">
                                        @csrf
                                        <input type="hidden" name="user_skill_id" value="{{ $listing->id }}">
                                        
                                        <!-- PIN Input -->
                                        <div style="margin-bottom: 24px;">
                                            <label style="display: block; font-weight: 700; color: #1f2937; margin-bottom: 10px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                                Transaction PIN <span style="color: #ef4444;">*</span>
                                            </label>
                                            <input 
                                                type="password" 
                                                id="transactionPin"
                                                name="transaction_pin" 
                                                placeholder="• • • •" 
                                                maxlength="4"
                                                inputmode="numeric"
                                                style="width: 100%; padding: 16px; border: 2px solid {{ $errors->has('transaction_pin') ? '#ef4444' : '#e5e7eb' }}; border-radius: 12px; font-size: 32px; font-weight: 700; letter-spacing: 12px; text-align: center; transition: all 200ms ease; box-sizing: border-box; background: #f9fafb;"
                                                onfocus="this.style.borderColor='#1040C0'; this.style.boxShadow='0 0 0 4px rgba(16, 64, 192, 0.1)'; this.style.background='white';"
                                                onblur="this.style.borderColor='{{ $errors->has('transaction_pin') ? '#ef4444' : '#e5e7eb' }}'; this.style.boxShadow='none'; this.style.background='#f9fafb';"
                                                value="{{ old('transaction_pin') }}"
                                                required
                                                autofocus/>
                                            
                                            @if($errors->has('transaction_pin'))
                                                <div style="background: #fee2e2; border: 1px solid #fecaca; border-radius: 10px; padding: 12px; margin-top: 10px;">
                                                    <p style="color: #dc2626; font-size: 13px; margin: 0; font-weight: 600;">
                                                        ✕ @foreach($errors->get('transaction_pin') as $message)
                                                            {{ $message }}<br>
                                                        @endforeach
                                                    </p>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Cost Summary -->
                                        <div style="background: #f0f4ff; border-radius: 12px; padding: 20px; margin-bottom: 32px; border: 2px solid #c7d2fe;">
                                            <p style="font-size: 12px; color: #4f46e5; text-transform: uppercase; font-weight: 700; margin: 0 0 8px 0; letter-spacing: 0.5px;">Coins to Transfer</p>
                                            <p style="font-size: 28px; font-weight: 900; color: #1040C0; margin: 0;">{{ number_format($listing->price, 0) }} coins</p>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div style="display: flex; gap: 12px;">
                                            <button 
                                                type="button" 
                                                onclick="closePinModal()"
                                                style="flex: 1; padding: 14px; background: #f3f4f6; color: #1f2937; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 200ms ease; text-transform: uppercase; letter-spacing: 0.5px;"
                                                onmouseover="this.style.background='#e5e7eb'; this.style.borderColor='#d1d5db';"
                                                onmouseout="this.style.background='#f3f4f6'; this.style.borderColor='#e5e7eb';">
                                                Cancel
                                            </button>
                                            <button 
                                                type="submit" 
                                                style="flex: 1; padding: 14px; background: linear-gradient(135deg, #FFC107 0%, #FFB300 100%); color: #1a1a1a; border: none; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 200ms ease; box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3); text-transform: uppercase; letter-spacing: 0.5px;"
                                                onmouseover="this.style.boxShadow='0 8px 20px rgba(255, 193, 7, 0.4)'; this.style.transform='translateY(-2px)';"
                                                onmouseout="this.style.boxShadow='0 4px 12px rgba(255, 193, 7, 0.3)'; this.style.transform='translateY(0)';">
                                                Confirm & Pay
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal Styles -->
                            <style>
                                #pinModal {
                                    display: none !important;
                                    position: fixed;
                                    top: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 100%;
                                    background: rgba(0, 0, 0, 0.6);
                                    backdrop-filter: blur(4px);
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
                                    animation: slideUp 300ms cubic-bezier(0.34, 1.56, 0.64, 1);
                                }
                                @keyframes slideUp {
                                    from {
                                        transform: translateY(40px);
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

                                window.addEventListener('load', function() {
                                    @if($errors->has('transaction_pin'))
                                        openPinModal();
                                    @endif
                                });

                                document.getElementById('pinModal')?.addEventListener('click', function(e) {
                                    if (e.target === this) {
                                        closePinModal();
                                    }
                                });

                                document.addEventListener('keydown', function(e) {
                                    if (e.key === 'Escape' && document.getElementById('pinModal')?.classList.contains('show')) {
                                        closePinModal();
                                    }
                                });
                            </script>
                        @endif
                    @endif
                @else
                    <div style="background: linear-gradient(135deg, #fff8e1 0%, #fffaed 100%); border: 2px solid #fbbf24; border-radius: 16px; padding: 24px; margin-bottom: 40px; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(251,191,36,0.1); border-radius: 50%; filter: blur(20px);"></div>
                        <p style="font-weight: 700; color: #b45309; margin: 0 0 8px 0; font-size: 16px;">Login Required</p>
                        <p style="color: #92400e; font-size: 14px; margin: 0;">Sign in to your account to request this skill</p>
                    </div>
                @endauth

                <!-- Reviews Section -->
                <div style="background: white; border-radius: 16px; padding: 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
                        <h2 style="font-size: 22px; font-weight: 800; color: #1f2937; margin: 0; letter-spacing: -0.5px;">Client Reviews</h2>
                        @php
                            $avgRating = $listing->purchases()
                                ->where('status', 'completed')
                                ->with('review')
                                ->get()
                                ->mapWithKeys(fn($p) => $p->review ? [$p->id => $p->review->rating] : [])
                                ->average();
                        @endphp
                        @if($avgRating)
                            <div style="text-align: right;">
                                <p style="font-size: 20px; font-weight: 900; color: #1040C0; margin: 0;">{{ round($avgRating, 1) }}/5</p>
                                <p style="font-size: 12px; color: #9ca3af; margin: 4px 0 0 0;">{{ $reviews->count() }} review{{ $reviews->count() != 1 ? 's' : '' }}</p>
                            </div>
                        @endif
                    </div>
                    
                    @forelse($reviews as $review)
                        <div style="display: flex; gap: 16px; padding: 24px; background: #f9fafb; border-radius: 12px; margin-bottom: 16px; border: 1px solid #e5e7eb; transition: all 300ms ease;" onmouseover="this.style.background='#f3f4f6'; this.style.borderColor='#d1d5db';" onmouseout="this.style.background='#f9fafb'; this.style.borderColor='#e5e7eb';">
                            <!-- Reviewer Avatar -->
                            <div style="flex: 0 0 50px;">
                                @if($review->buyer->profile_image)
                                    <img src="{{ asset('storage/' . $review->buyer->profile_image) }}" alt="{{ $review->buyer->name }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb;">
                                @else
                                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-weight: 700; font-size: 18px; border: 2px solid #e5e7eb;">
                                        {{ substr($review->buyer->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Review Content -->
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                    <div>
                                        <p style="font-weight: 700; color: #1f2937; margin: 0; font-size: 15px;">{{ $review->buyer->name }}</p>
                                        <p style="font-size: 13px; color: #9ca3af; margin: 4px 0 0 0;">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div style="display: flex; gap: 3px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span style="font-size: 16px;">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                </div>
                                <p style="color: #4b5563; font-size: 15px; line-height: 1.7; margin: 0;">{{ $review->comment }}</p>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 48px 20px; background: #f9fafb; border-radius: 12px; border: 2px dashed #e5e7eb;">
                            <p style="color: #6b7280; font-size: 15px; margin: 0; font-weight: 500;">No reviews yet. Be the first to review this skill!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right: Seller Sidebar -->
            <div>
                <!-- Seller Card - Sticky -->
                <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; position: sticky; top: 120px; transition: all 300ms ease;" onmouseover="this.style.boxShadow='0 12px 24px rgba(0,0,0,0.1)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">
                    <!-- Seller Avatar Section -->
                    <div style="text-align: center; margin-bottom: 24px;">
                        @if($listing->user->profile_image)
                            <img src="{{ asset('storage/' . $listing->user->profile_image) }}" alt="{{ $listing->user->name }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #1040C0; margin-bottom: 16px; box-shadow: 0 8px 16px rgba(16,64,192,0.2);">
                        @else
                            <div style="width: 120px; height: 120px; border-radius: 50%; background: #1040C0; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 48px; margin: 0 auto 16px auto; box-shadow: 0 8px 16px rgba(16,64,192,0.2);">
                                {{ substr($listing->user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <!-- Seller Name & Title -->
                    <p style="font-weight: 800; color: #1f2937; margin: 0 0 4px 0; font-size: 18px; text-align: center;">{{ $listing->user->name }}</p>
                    @if($listing->user->username)
                        <p style="font-size: 13px; color: #1040C0; margin: 0 0 12px 0; font-weight: 700; text-align: center;">{{ $listing->user->username }}</p>
                    @endif
                    
                    @if($listing->user->bio)
                        <p style="color: #6b7280; font-size: 13px; line-height: 1.6; margin: 0 0 20px 0; text-align: center;">{{ $listing->user->bio }}</p>
                    @endif

                    <!-- Divider -->
                    <div style="height: 1px; background: #e5e7eb; margin: 20px 0;"></div>

                    <!-- Member Stats -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                        <div style="background: #f9fafb; border-radius: 12px; padding: 16px; text-align: center; border: 1px solid #e5e7eb;">
                            <p style="font-size: 12px; color: #9ca3af; text-transform: uppercase; font-weight: 700; margin: 0 0 4px 0; letter-spacing: 0.5px;">Member Since</p>
                            <p style="font-size: 16px; font-weight: 900; color: #1f2937; margin: 0;">{{ $listing->user->created_at->format('M Y') }}</p>
                        </div>
                        <div style="background: #f9fafb; border-radius: 12px; padding: 16px; text-align: center; border: 1px solid #e5e7eb;">
                            <p style="font-size: 12px; color: #9ca3af; text-transform: uppercase; font-weight: 700; margin: 0 0 4px 0; letter-spacing: 0.5px;">Listings</p>
                            <p style="font-size: 16px; font-weight: 900; color: #1f2937; margin: 0;">
                                @php
                                    $listingCount = \App\Models\UserSkill::where('user_id', $listing->user_id)->where('status', 'active')->count();
                                @endphp
                                {{ $listingCount }}
                            </p>
                        </div>
                    </div>

                    <!-- Rating Badge -->
                    <div style="background: #f0f4ff; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 24px; border: 2px solid #c7d2fe;">
                        <p style="font-size: 11px; color: #4f46e5; text-transform: uppercase; font-weight: 800; margin: 0 0 8px 0; letter-spacing: 0.5px;">Rating</p>
                        <div style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                            <p style="font-size: 36px; font-weight: 900; color: #1040C0; margin: 0;">
                                {{ $avgRating ? round($avgRating, 1) : 'N/A' }}
                            </p>
                            @if($avgRating)
                                <div style="display: flex; gap: 3px; font-size: 18px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= round($avgRating) ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Verified Badge -->
                    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #f1fdf9 100%); border-radius: 12px; padding: 12px; text-align: center; margin-bottom: 24px; border: 2px solid #22c55e;">
                        <p style="font-size: 12px; color: #16a34a; font-weight: 800; margin: 0;">Verified Professional</p>
                    </div>

                    <!-- Action Buttons -->
                    @auth
                        @if(auth()->id() !== $listing->user_id)
                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                <x-message-modal :listing="$listing" />
                                <a href="{{ route('profile.public', $listing->user_id) }}" style="display: block; padding: 14px 16px; background: white; color: #1040C0; border: 2px solid #1040C0; border-radius: 10px; text-align: center; text-decoration: none; font-weight: 700; font-size: 14px; transition: all 200ms ease; text-transform: uppercase; letter-spacing: 0.5px;" onmouseover="this.style.background='#f3f4f6'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='white'; this.style.transform='translateY(0)';">
                                    View Profile
                                </a>
                            </div>
                        @else
                            <a href="{{ route('profile.show') }}" style="display: block; width: 100%; padding: 14px 16px; background: #1040C0; color: white; border: 2px solid #1040C0; border-radius: 10px; text-align: center; text-decoration: none; font-weight: 700; font-size: 14px; transition: all 200ms ease; text-transform: uppercase; letter-spacing: 0.5px;" onmouseover="this.style.background='#0D32A4'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#1040C0'; this.style.transform='translateY(0)';">
                                Edit Your Profile
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" style="display: block; width: 100%; padding: 14px 16px; background: #1040C0; color: white; border: 2px solid #1040C0; border-radius: 10px; text-align: center; text-decoration: none; font-weight: 700; font-size: 14px; transition: all 200ms ease; box-shadow: 0 4px 12px rgba(16,64,192,0.2); text-transform: uppercase; letter-spacing: 0.5px;" onmouseover="this.style.boxShadow='0 8px 20px rgba(16,64,192,0.3)'; this.style.transform='translateY(-2px);" onmouseout="this.style.boxShadow='0 4px 12px rgba(16,64,192,0.2)'; this.style.transform='translateY(0);">
                            Login to Chat
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
