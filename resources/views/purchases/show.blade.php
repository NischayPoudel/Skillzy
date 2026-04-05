<x-app-layout>
    <div class="py-12" style="background: #f5f5f5;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div style="margin-bottom: 32px;">
                <h1 style="font-size: 48px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; color: #1a202c; margin: 0; margin-bottom: 8px;">Purchase Details</h1>
                <p style="font-size: 16px; color: #6b7280; margin: 0;">Manage and track your skill purchase</p>
            </div>

            @if($message = session('success'))
                <div style="margin-bottom: 24px; padding: 16px 20px; background: #ecfdf5; border: 2px solid #10b981; border-radius: 0; font-weight: 700; color: #10b981;">✓ {{ $message }}</div>
            @endif

            @if($error = session('error'))
                <div style="margin-bottom: 24px; padding: 16px 20px; background: #fee2e2; border: 2px solid #ef4444; border-radius: 0; font-weight: 700; color: #dc2626;">✕ {{ $error }}</div>
            @endif

            @if($errors->any())
                <div style="margin-bottom: 24px; padding: 16px 20px; background: #fee2e2; border: 2px solid #ef4444; border-radius: 0; font-weight: 700; color: #dc2626;">
                    @foreach($errors->all() as $error)
                        ✕ {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
                <!-- Main Content -->
                <div>
                    <!-- Purchase Summary Card -->
                    <div style="background: white; border: 3px solid #000; border-radius: 0; padding: 32px; margin-bottom: 24px;">
                        <!-- Skill Title -->
                        <h2 style="font-size: 36px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: #000; margin: 0 0 24px 0;">
                            {{ $purchase->userSkill->skill->name }}
                        </h2>

                        <!-- Status Badge -->
                        <div style="display: inline-block; margin-bottom: 24px;">
                            @php
                                $statusColors = [
                                    'pending' => ['bg' => '#fbbf24', 'text' => '#000', 'label' => 'PENDING'],
                                    'accepted' => ['bg' => '#60a5fa', 'text' => '#fff', 'label' => 'ACCEPTED'],
                                    'work_submitted' => ['bg' => '#f59e0b', 'text' => '#fff', 'label' => 'WORK SUBMITTED'],
                                    'completed' => ['bg' => '#10b981', 'text' => '#fff', 'label' => 'COMPLETED'],
                                    'declined' => ['bg' => '#ef4444', 'text' => '#fff', 'label' => 'DECLINED'],
                                ];
                                $status = $statusColors[$purchase->status] ?? $statusColors['pending'];
                            @endphp
                            <span style="display: inline-block; background: {{ $status['bg'] }}; color: {{ $status['text'] }}; padding: 12px 20px; border: 2px solid #000; border-radius: 0; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; box-shadow: 3px 3px 0 rgba(0,0,0,0.2);">
                                {{ $status['label'] }}
                            </span>
                        </div>

                        <!-- Amount & Details Grid -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; padding: 24px 0; border-top: 2px solid #000; border-bottom: 2px solid #000; margin-bottom: 24px;">
                            <div>
                                <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 8px 0;">Amount</p>
                                <p style="font-size: 32px; font-weight: 900; color: #000; margin: 0;">₹{{ number_format($purchase->amount, 0) }}</p>
                                <p style="font-size: 12px; color: #6b7280; margin: 4px 0 0 0;">coins</p>
                            </div>
                            <div>
                                <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 8px 0;">Experience Level</p>
                                <p style="font-size: 24px; font-weight: 700; color: #000; margin: 0;">{{ ucfirst($purchase->userSkill->experience_level) }}</p>
                            </div>
                        </div>

                        <!-- Seller Details -->
                        <div style="padding: 20px; background: #fafafa; border: 2px solid #e5e7eb; margin-bottom: 24px;">
                            <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 12px 0;">Provided By</p>
                            <p style="font-size: 18px; font-weight: 900; color: #000; margin: 0;">{{ $purchase->seller->name }}</p>
                        </div>

                        @if($purchase->note)
                            <div style="padding: 16px; background: #f3f4f6; border-left: 4px solid #000; margin-bottom: 24px;">
                                <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 8px 0;">Request Note</p>
                                <p style="font-size: 14px; color: #1f2937; margin: 0; line-height: 1.6;">{{ $purchase->note }}</p>
                            </div>
                        @endif

                        <!-- Seller Actions -->
                        @auth
                            @if(auth()->id() === $purchase->seller_id && $purchase->status === 'pending')
                                <div style="display: flex; gap: 12px;">
                                    <form method="POST" action="{{ route('purchases.update', $purchase) }}" style="flex: 1;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="accept">
                                        <button type="submit" style="width: 100%; padding: 14px 20px; background: #10b981; color: white; border: 2px solid #000; border-radius: 0; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 200ms ease; box-shadow: 3px 3px 0 rgba(0,0,0,0.2);" onmouseover="this.style.transform='translate(-1px, -1px)'; this.style.boxShadow='4px 4px 0 rgba(0,0,0,0.3)';" onmouseout="this.style.transform='translate(0,0)'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.2)';">✓ Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('purchases.update', $purchase) }}" style="flex: 1;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="cancel">
                                        <button type="submit" style="width: 100%; padding: 14px 20px; background: #ef4444; color: white; border: 2px solid #000; border-radius: 0; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 200ms ease; box-shadow: 3px 3px 0 rgba(0,0,0,0.2);" onmouseover="this.style.transform='translate(-1px, -1px)'; this.style.boxShadow='4px 4px 0 rgba(0,0,0,0.3)';" onmouseout="this.style.transform='translate(0,0)'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.2)';">✕ Decline</button>
                                    </form>
                                </div>
                            @elseif(auth()->id() === $purchase->seller_id && $purchase->status === 'accepted')
                                <form method="POST" action="{{ route('purchases.update', $purchase) }}" style="width: 100%;" onsubmit="return confirm('Submit your work for verification? The buyer will review and verify.');">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="action" value="complete">
                                    <button type="submit" style="width: 100%; padding: 16px 20px; background: #f59e0b; color: white; border: 2px solid #000; border-radius: 0; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 200ms ease; box-shadow: 3px 3px 0 rgba(0,0,0,0.2);" onmouseover="this.style.transform='translate(-1px, -1px)'; this.style.boxShadow='4px 4px 0 rgba(0,0,0,0.3)';" onmouseout="this.style.transform='translate(0,0)'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.2)';">✓ Submit Work for Verification</button>
                                </form>
                            @elseif(auth()->id() === $purchase->seller_id && $purchase->status === 'work_submitted')
                                <div style="padding: 16px; background: #fef3c7; border: 2px solid #f59e0b; border-radius: 0; margin-bottom: 16px;">
                                    <p style="font-weight: 700; color: #92400e; margin: 0;">⏳ Waiting for Buyer Verification</p>
                                    <p style="color: #92400e; font-size: 14px; margin: 4px 0 0 0;">Your work has been submitted. Waiting for the buyer to verify it.</p>
                                </div>
                            @endif
                        @endauth

                        <!-- Buyer Actions -->
                        @auth
                            @if(auth()->id() === $purchase->buyer_id && $purchase->status === 'work_submitted')
                                <div style="background: #fef3c7; border: 2px solid #f59e0b; border-radius: 0; padding: 16px; margin-bottom: 16px;">
                                    <p style="font-weight: 700; color: #92400e; margin: 0 0 12px 0;">🔍 Please Review the Submitted Work</p>
                                    <p style="color: #92400e; font-size: 14px; margin: 0 0 16px 0;">The seller has submitted their work. Review the messages and details below, then verify if the work meets your expectations.</p>
                                    <form method="POST" action="{{ route('purchases.update', $purchase) }}" style="width: 100%;" onsubmit="return confirm('Verify this work? Coins will be transferred to the seller.');">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="verify">
                                        <button type="submit" style="width: 100%; padding: 14px 20px; background: #10b981; color: white; border: 2px solid #000; border-radius: 0; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 200ms ease; box-shadow: 3px 3px 0 rgba(0,0,0,0.2);" onmouseover="this.style.transform='translate(-1px, -1px)'; this.style.boxShadow='4px 4px 0 rgba(0,0,0,0.3)';" onmouseout="this.style.transform='translate(0,0)'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.2)';">✓ Verify Work Done</button>
                                    </form>
                                </div>
                            @elseif(auth()->id() === $purchase->buyer_id && $purchase->status === 'pending')
                                <form method="POST" action="{{ route('purchases.update', $purchase) }}" style="width: 100%;" onsubmit="return confirm('Cancel this purchase and refund coins back to your account?');">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="action" value="cancel">
                                    <button type="submit" style="width: 100%; padding: 16px 20px; background: #ef4444; color: white; border: 2px solid #000; border-radius: 0; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 200ms ease; box-shadow: 3px 3px 0 rgba(0,0,0,0.2);" onmouseover="this.style.transform='translate(-1px, -1px)'; this.style.boxShadow='4px 4px 0 rgba(0,0,0,0.3)';" onmouseout="this.style.transform='translate(0,0)'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.2)';">✕ Cancel & Refund Coins</button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    <!-- Messages Section -->
                    <div style="background: white; border: 3px solid #000; border-radius: 0; padding: 32px; margin-bottom: 24px;">
                        <h3 style="font-size: 20px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: #000; margin: 0 0 24px 0;">Messages</h3>
                        
                        <div style="background: #fafafa; border: 2px solid #e5e7eb; border-radius: 0; padding: 16px; min-height: 200px; max-height: 400px; overflow-y: auto; margin-bottom: 20px;">
                            @forelse($purchase->messages as $msg)
                                <div style="margin-bottom: 16px; padding: 12px 16px; background: @if($msg->sender_id === auth()->id()) #fff9e6 @else white @endif; border-left: 4px solid @if($msg->sender_id === auth()->id()) #F0C020 @else #000 @endif; border-radius: 0;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin: 0;">{{ $msg->sender->name }}</p>
                                        <p style="font-size: 12px; color: #9ca3af; margin: 0;">{{ $msg->created_at->format('M d, H:i') }}</p>
                                    </div>
                                    <p style="font-size: 14px; color: #1f2937; margin: 0; line-height: 1.6;">{{ $msg->message }}</p>
                                </div>
                            @empty
                                <p style="font-size: 14px; color: #9ca3af; text-align: center; padding: 32px 0; margin: 0;">No messages yet. Start the conversation!</p>
                            @endforelse
                        </div>

                        @auth
                            @if(auth()->id() === $purchase->buyer_id || auth()->id() === $purchase->seller_id)
                                <form method="POST" action="{{ route('messages.store') }}" style="display: flex; gap: 12px;">
                                    @csrf
                                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                    <input type="text" name="message" placeholder="Type message..." required 
                                        style="flex: 1; padding: 14px 16px; border: 2px solid #000; border-radius: 0; font-size: 14px; font-family: inherit; background: white;" 
                                        onfocus="this.style.borderColor='#F0C020'; this.style.boxShadow='0 0 0 3px rgba(240, 192, 32, 0.2)';" 
                                        onblur="this.style.borderColor='#000'; this.style.boxShadow='none';">
                                    <button type="submit" style="padding: 14px 24px; background: #000; color: #F0C020; border: 2px solid #000; border-radius: 0; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: pointer; transition: all 200ms ease; box-shadow: 2px 2px 0 rgba(0,0,0,0.2);" onmouseover="this.style.background='#F0C020'; this.style.color='#000'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.2)';" onmouseout="this.style.background='#000'; this.style.color='#F0C020'; this.style.boxShadow='2px 2px 0 rgba(0,0,0,0.2)';">Send</button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    <!-- Review Section -->
                    @if($purchase->status === 'completed' && auth()->id() === $purchase->buyer_id)
                        <div style="background: white; border: 3px solid #000; border-radius: 0; padding: 32px;">
                            <h3 style="font-size: 20px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: #000; margin: 0 0 24px 0;">Leave a Review</h3>
                            
                            @if($purchase->review)
                                <div style="padding: 20px; background: #ecfdf5; border: 2px solid #10b981; border-radius: 0; margin-bottom: 24px;">
                                    <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #10b981; margin: 0 0 12px 0;">Your Rating</p>
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                                        @for($i = 0; $i < $purchase->review->rating; $i++)
                                            <span style="font-size: 28px; color: #F0C020;">★</span>
                                        @endfor
                                        @for($i = $purchase->review->rating; $i < 5; $i++)
                                            <span style="font-size: 28px; color: #d1d5db;">★</span>
                                        @endfor
                                        <span style="font-weight: 700; color: #10b981; margin-left: 8px;">{{ $purchase->review->rating }}/5</span>
                                    </div>
                                    @if($purchase->review->comment)
                                        <p style="font-size: 14px; color: #10b981; margin: 0; line-height: 1.6;">{{ $purchase->review->comment }}</p>
                                    @endif
                                </div>
                            @else
                                <form method="POST" action="{{ route('reviews.store') }}">
                                    @csrf
                                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                    
                                    <div style="margin-bottom: 24px;">
                                        <label style="display: block; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #1f2937; margin-bottom: 12px;">Rating</label>
                                        <div style="display: flex; gap: 12px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <input type="radio" id="rating_{{ $i }}" name="rating" value="{{ $i }}" style="display: none;" required>
                                                <label for="rating_{{ $i }}" style="cursor: pointer; font-size: 36px; color: #d1d5db; transition: all 200ms ease;" onmouseover="this.style.color='#F0C020';" onmouseout="for(let j=1; j<=5; j++) { let inp = document.getElementById('rating_'+j); if(inp.checked && j <= i) this.style.color='#F0C020'; else this.style.color='#d1d5db'; }">★</label>
                                            @endfor
                                        </div>
                                    </div>

                                    <div style="margin-bottom: 24px;">
                                        <label for="comment" style="display: block; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #1f2937; margin-bottom: 8px;">Comments (Optional)</label>
                                        <textarea id="comment" name="comment" rows="4" placeholder="Share your experience..." style="width: 100%; padding: 12px 16px; border: 2px solid #000; border-radius: 0; font-size: 14px; font-family: inherit; resize: vertical;" onfocus="this.style.borderColor='#F0C020'; this.style.boxShadow='0 0 0 3px rgba(240, 192, 32, 0.2)';" onblur="this.style.borderColor='#000'; this.style.boxShadow='none';"></textarea>
                                    </div>

                                    <button type="submit" style="width: 100%; padding: 16px 20px; background: #F0C020; color: #000; border: 2px solid #000; border-radius: 0; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 200ms ease; box-shadow: 3px 3px 0 rgba(0,0,0,0.2);" onmouseover="this.style.transform='translate(-1px, -1px)'; this.style.boxShadow='4px 4px 0 rgba(0,0,0,0.3)';" onmouseout="this.style.transform='translate(0,0)'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.2)';">Submit Review</button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div>
                    <!-- Purchase Info Card -->
                    <div style="background: white; border: 3px solid #000; border-radius: 0; padding: 24px; margin-bottom: 24px;">
                        <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 16px 0;">Buyer</h4>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                            @if($purchase->buyer->profile_image)
                                <img src="{{ asset('storage/' . $purchase->buyer->profile_image) }}" alt="{{ $purchase->buyer->name }}" style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid #000; object-fit: cover;">
                            @else
                                <div style="width: 48px; height: 48px; border-radius: 50%; background: #f3f4f6; border: 2px solid #000; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #9ca3af;">{{ substr($purchase->buyer->name, 0, 1) }}</div>
                            @endif
                            <div>
                                <p style="font-size: 14px; font-weight: 700; color: #000; margin: 0;">{{ $purchase->buyer->name }}</p>
                                <p style="font-size: 12px; color: #6b7280; margin: 0;">{{ $purchase->buyer->username }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Seller Info Card -->
                    <div style="background: white; border: 3px solid #000; border-radius: 0; padding: 24px;">
                        <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 16px 0;">Seller</h4>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                            @if($purchase->seller->profile_image)
                                <img src="{{ asset('storage/' . $purchase->seller->profile_image) }}" alt="{{ $purchase->seller->name }}" style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid #000; object-fit: cover;">
                            @else
                                <div style="width: 48px; height: 48px; border-radius: 50%; background: #f3f4f6; border: 2px solid #000; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #9ca3af;">{{ substr($purchase->seller->name, 0, 1) }}</div>
                            @endif
                            <div>
                                <p style="font-size: 14px; font-weight: 700; color: #000; margin: 0;">{{ $purchase->seller->name }}</p>
                                <p style="font-size: 12px; color: #6b7280; margin: 0;">{{ $purchase->seller->username }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
