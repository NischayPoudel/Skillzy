<x-admin-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Redeem Request') }}
            </h2>
            <a href="{{ route('admin.redeem.index') }}"
               style="background-color: #F0F0F0; color: #121212; border: 3px solid #121212; padding: 0.75rem 1.5rem; font-weight: 900; font-size: 0.9rem; text-transform: uppercase; text-decoration: none; cursor: pointer; transition: all 0.2s ease;"
               onmouseover="this.style.backgroundColor='#E0E0E0';"
               onmouseout="this.style.backgroundColor='#F0F0F0';">
                ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
            <!-- Main Content -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <!-- Request Details -->
                <div style="border: 4px solid #121212; background: white; padding: 2rem;">
                    <h2 style="font-size: 1.3rem; font-weight: 900; text-transform: uppercase; border-bottom: 3px solid #121212; padding-bottom: 1rem; margin-bottom: 1.5rem;">Request Details</h2>

                    <!-- User Info -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: #666; display: block; margin-bottom: 0.5rem;">User</label>
                        <div style="border: 2px solid #121212; padding: 1rem; background-color: #F9F9F9;">
                            <div style="font-weight: 900; font-size: 1.1rem;">{{ $redeemRequest->user->name }}</div>
                            <div style="color: #666; font-size: 0.9rem;">{{ $redeemRequest->user->email }}</div>
                        </div>
                    </div>

                    <!-- Coins Amount -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: #666; display: block; margin-bottom: 0.5rem;">Amount to Redeem</label>
                        <div style="border: 3px solid #1040C0; background-color: #E8F0FF; padding: 1rem; font-size: 1.5rem; font-weight: 900; color: #1040C0; text-align: center;">
                            {{ $redeemRequest->coins_amount }} Coins
                        </div>
                    </div>

                    <!-- Status -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: #666; display: block; margin-bottom: 0.5rem;">Status</label>
                        <div style="border: 2px solid #121212; padding: 0.75rem; background-color: #F9F9F9;">
                            @if($redeemRequest->isPending())
                                <span style="background-color: #F0C020; color: #121212; padding: 0.5rem 1rem; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; border: 2px solid #121212;">
                                    ⏳ Pending Review
                                </span>
                            @elseif($redeemRequest->isApproved())
                                <span style="background-color: #90EE90; color: #121212; padding: 0.5rem 1rem; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; border: 2px solid #121212;">
                                    ✓ Approved
                                </span>
                            @else
                                <span style="background-color: #D02020; color: white; padding: 0.5rem 1rem; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; border: 2px solid #121212;">
                                    ✗ Rejected
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Dates -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="font-weight: 900; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: #666; display: block; margin-bottom: 0.5rem;">Submitted</label>
                            <div style="border: 2px solid #121212; padding: 0.75rem; background-color: #F9F9F9; font-size: 0.9rem;">
                                {{ $redeemRequest->created_at->format('M d, Y H:i') }}
                            </div>
                        </div>
                        @if($redeemRequest->reviewed_at)
                            <div>
                                <label style="font-weight: 900; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: #666; display: block; margin-bottom: 0.5rem;">Reviewed</label>
                                <div style="border: 2px solid #121212; padding: 0.75rem; background-color: #F9F9F9; font-size: 0.9rem;">
                                    {{ $redeemRequest->reviewed_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Reviewed By -->
                    @if($redeemRequest->reviewedBy)
                        <div style="margin-bottom: 1.5rem;">
                            <label style="font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: #666; display: block; margin-bottom: 0.5rem;">Reviewed By</label>
                            <div style="border: 2px solid #121212; padding: 0.75rem; background-color: #F9F9F9;">
                                {{ $redeemRequest->reviewedBy->name }}
                            </div>
                        </div>
                    @endif

                    <!-- Admin Notes (if any) -->
                    @if($redeemRequest->admin_notes)
                        <div style="margin-bottom: 1.5rem;">
                            <label style="font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: #666; display: block; margin-bottom: 0.5rem;">Admin Notes</label>
                            <div style="border: 2px solid #121212; padding: 1rem; background-color: #FFF5E6; font-size: 0.9rem; line-height: 1.6;">
                                {{ $redeemRequest->admin_notes }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Proof Image & Actions -->
                <div>
                    <!-- Proof Image -->
                    <div style="border: 4px solid #121212; background: white; padding: 2rem; margin-bottom: 2rem;">
                        <h2 style="font-size: 1.3rem; font-weight: 900; text-transform: uppercase; border-bottom: 3px solid #121212; padding-bottom: 1rem; margin-bottom: 1.5rem;">Proof Image</h2>

                        @if($redeemRequest->proof_image)
                            <div style="border: 3px solid #121212; padding: 0.5rem; background-color: #F9F9F9; margin-bottom: 1rem;">
                                <img src="{{ Storage::url($redeemRequest->proof_image) }}" 
                                     alt="Proof Image" 
                                     style="width: 100%; height: auto; display: block; border: 2px solid #121212;">
                            </div>
                            <a href="{{ Storage::url($redeemRequest->proof_image) }}" 
                               target="_blank"
                               style="background-color: #1040C0; color: white; border: 2px solid #121212; padding: 0.75rem 1.5rem; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; text-decoration: none; display: inline-block; transition: all 0.2s ease; width: 100%; text-align: center; box-sizing: border-box;"
                               onmouseover="this.style.transform='translate(-2px, -2px)'; this.style.boxShadow='4px 4px 0px rgba(16, 64, 192, 0.2)';"
                               onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='none';">
                                View Full Size
                            </a>
                        @else
                            <div style="padding: 2rem; text-align: center; color: #999;">
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;">📷</div>
                                <p>No proof image uploaded</p>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons (only if pending) -->
                    @if($redeemRequest->isPending())
                        <div style="border: 4px solid #121212; background: white; padding: 2rem;">
                            <h2 style="font-size: 1.3rem; font-weight: 900; text-transform: uppercase; border-bottom: 3px solid #121212; padding-bottom: 1rem; margin-bottom: 1.5rem;">Review Action</h2>

                            <!-- Approve Form -->
                            <form method="POST" action="{{ route('admin.redeem.approve', $redeemRequest) }}" style="margin-bottom: 1rem;">
                                @csrf
                                <button type="submit"
                                        style="background-color: #90EE90; color: #121212; border: 4px solid #121212; padding: 1rem; font-weight: 900; font-size: 0.95rem; text-transform: uppercase; cursor: pointer; transition: all 0.2s ease; width: 100%; font-family: 'Outfit', sans-serif;"
                                        onmouseover="this.style.transform='translate(-3px, -3px)'; this.style.boxShadow='6px 6px 0px rgba(144, 238, 144, 0.4)';"
                                        onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='none';">
                                    ✓ Approve & Transfer Coins
                                </button>
                            </form>

                            <!-- Reject Button -->
                            <button type="button"
                                    onclick="document.getElementById('reject-modal').style.display='flex'"
                                    style="background-color: #D02020; color: white; border: 4px solid #121212; padding: 1rem; font-weight: 900; font-size: 0.95rem; text-transform: uppercase; cursor: pointer; transition: all 0.2s ease; width: 100%; font-family: 'Outfit', sans-serif;"
                                    onmouseover="this.style.transform='translate(-3px, -3px)'; this.style.boxShadow='6px 6px 0px rgba(208, 32, 32, 0.4)';"
                                    onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='none';">
                                ✗ Reject Request
                            </button>
                        </div>

                        <!-- Reject Modal -->
                        <div id="reject-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); z-index: 1000; align-items: center; justify-content: center;">
                            <div style="background: white; border: 4px solid #121212; padding: 2rem; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
                                <h3 style="font-size: 1.3rem; font-weight: 900; text-transform: uppercase; margin-bottom: 1rem;">Reject Request</h3>

                                <form method="POST" action="{{ route('admin.redeem.reject', $redeemRequest) }}">
                                    @csrf
                                    <div style="margin-bottom: 1.5rem;">
                                        <label style="display: block; font-weight: 900; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">
                                            Reason (Optional)
                                        </label>
                                        <textarea name="admin_notes"
                                                  style="width: 100%; border: 3px solid #121212; padding: 1rem; font-size: 1rem; font-family: 'Outfit', sans-serif; font-weight: 500; min-height: 120px; resize: vertical;"
                                                  placeholder="Explain why you're rejecting this request..."></textarea>
                                    </div>

                                    <div style="display: flex; gap: 1rem;">
                                        <button type="button"
                                                onclick="document.getElementById('reject-modal').style.display='none'"
                                                style="flex: 1; background-color: #F0F0F0; color: #121212; border: 3px solid #121212; font-weight: 900; padding: 0.75rem 1.5rem; text-transform: uppercase; font-size: 0.9rem; cursor: pointer; font-family: 'Outfit', sans-serif; transition: all 0.2s ease;"
                                                onmouseover="this.style.backgroundColor='#E0E0E0';"
                                                onmouseout="this.style.backgroundColor='#F0F0F0';">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                style="flex: 1; background-color: #D02020; color: white; border: 4px solid #121212; font-weight: 900; padding: 0.75rem 1.5rem; text-transform: uppercase; font-size: 0.9rem; cursor: pointer; font-family: 'Outfit', sans-serif; transition: all 0.2s ease;"
                                                onmouseover="this.style.transform='translate(-2px, -2px)'; this.style.boxShadow='4px 4px 0px rgba(208, 32, 32, 0.2)';"
                                                onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='none';">
                                            Reject Request
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            document.getElementById('reject-modal').addEventListener('click', function(e) {
                                if (e.target === this) {
                                    this.style.display = 'none';
                                }
                            });
                        </script>
                    @endif
                </div>
            </div>
        </div>
</x-admin-layout>
