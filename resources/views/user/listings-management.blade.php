<x-app-layout>
    <div style="background: #f5f5f5;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 40px 2rem;">
            <!-- Header -->
            <div style="margin-bottom: 32px;">
                <h1 style="font-size: 48px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; color: #1a202c; margin: 0; margin-bottom: 8px;">Listing Management</h1>
                <p style="font-size: 16px; color: #6b7280; margin: 0;">Manage your skill requests and billing</p>
            </div>

            @if(session('success'))
                <div style="margin-bottom: 24px; padding: 16px 20px; background: #ecfdf5; border: 2px solid #10b981; border-radius: 0; font-weight: 700; color: #10b981;">✓ {{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div style="margin-bottom: 24px; padding: 16px 20px; background: #fee2e2; border: 2px solid #ef4444; border-radius: 0; font-weight: 700; color: #dc2626;">✕ {{ session('error') }}</div>
            @endif

            <!-- Tabs -->
            <div style="display: flex; gap: 12px; margin-bottom: 32px; border-bottom: 2px solid #e5e7eb;">
                <button 
                    class="tab-button" 
                    onclick="switchTab('pending')" 
                    data-tab="pending"
                    style="padding: 14px 24px; background: transparent; border: none; font-size: 15px; font-weight: 700; text-transform: uppercase; cursor: pointer; color: #6b7280; border-bottom: 3px solid transparent; transition: all 200ms;">
                    📋 Pending Requests
                </button>
                <button 
                    class="tab-button" 
                    onclick="switchTab('accepted')" 
                    data-tab="accepted"
                    style="padding: 14px 24px; background: transparent; border: none; font-size: 15px; font-weight: 700; text-transform: uppercase; cursor: pointer; color: #6b7280; border-bottom: 3px solid transparent; transition: all 200ms;">
                    ✓ Accepted (In Progress)
                </button>
                <button 
                    class="tab-button" 
                    onclick="switchTab('completed')" 
                    data-tab="completed"
                    style="padding: 14px 24px; background: transparent; border: none; font-size: 15px; font-weight: 700; text-transform: uppercase; cursor: pointer; color: #6b7280; border-bottom: 3px solid transparent; transition: all 200ms;">
                    ✓ Completed
                </button>
            </div>

            <!-- Pending Requests Tab -->
            <div id="pending" class="tab-content" style="display: block;">
                <div style="background: white; border: 3px solid #000; border-radius: 0; padding: 0;">
                    @forelse($pendingRequests as $purchase)
                        <div style="display: grid; grid-template-columns: 1fr auto; align-items: center; padding: 24px; border-bottom: 2px solid #e5e7eb; gap: 24px;">
                            <!-- Request Info -->
                            <div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 16px;">
                                    <div>
                                        <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 8px 0;">Buyer</p>
                                        <p style="font-size: 18px; font-weight: 900; color: #000; margin: 0;">{{ $purchase->buyer->name }}</p>
                                        <p style="font-size: 13px; color: #1040C0; margin: 4px 0 0 0; font-weight: 600;">@{{ $purchase->buyer->username }}</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 8px 0;">Skill</p>
                                        <p style="font-size: 18px; font-weight: 900; color: #000; margin: 0;">{{ $purchase->userSkill->skill->name }}</p>
                                        <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0 0;">Level: {{ ucfirst($purchase->userSkill->experience_level) }}</p>
                                    </div>
                                </div>
                                
                                <div style="padding: 12px; background: #f9fafb; border-left: 4px solid #1040C0; margin-top: 12px;">
                                    <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 4px 0;">Request Note</p>
                                    <p style="font-size: 14px; color: #1f2937; margin: 0; line-height: 1.5;">{{ $purchase->note ?: 'No note provided' }}</p>
                                </div>

                                <p style="font-size: 12px; color: #9ca3af; margin: 12px 0 0 0;">Requested {{ $purchase->created_at->diffForHumans() }}</p>
                            </div>

                            <!-- Actions & Amount -->
                            <div style="text-align: right; display: flex; flex-direction: column; gap: 12px; align-items: flex-end;">
                                <div style="background: #1040C0; color: white; padding: 12px 16px; border-radius: 0; text-align: center;">
                                    <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.8); margin: 0 0 4px 0;">Amount</p>
                                    <p style="font-size: 32px; font-weight: 900; color: #FFC107; margin: 0;">{{ number_format($purchase->amount, 0) }}</p>
                                    <p style="font-size: 12px; color: rgba(255,255,255,0.8); margin: 4px 0 0 0;">coins</p>
                                </div>

                                <a href="{{ route('purchases.show', $purchase) }}" style="display: inline-block; padding: 12px 24px; background: #000; color: #FFC107; border: 2px solid #000; border-radius: 0; font-weight: 700; text-decoration: none; font-size: 13px; text-transform: uppercase; cursor: pointer; transition: all 200ms; box-shadow: 2px 2px 0 rgba(0,0,0,0.2);" onmouseover="this.style.background='#FFC107'; this.style.color='#000'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.2)';" onmouseout="this.style.background='#000'; this.style.color='#FFC107'; this.style.boxShadow='2px 2px 0 rgba(0,0,0,0.2)';">
                                    View & Accept
                                </a>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 40px; text-align: center;">
                            <p style="font-size: 18px; font-weight: 700; color: #6b7280; margin: 0 0 8px 0;">No pending requests</p>
                            <p style="font-size: 14px; color: #9ca3af; margin: 0;">You'll see new requests here when buyers request your listings</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Accepted (In Progress) Tab -->
            <div id="accepted" class="tab-content" style="display: none;">
                <div style="background: white; border: 3px solid #000; border-radius: 0; padding: 0;">
                    @forelse($acceptedRequests as $purchase)
                        <div style="display: grid; grid-template-columns: 1fr auto; align-items: center; padding: 24px; border-bottom: 2px solid #e5e7eb; gap: 24px;">
                            <!-- Request Info -->
                            <div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 16px;">
                                    <div>
                                        <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 8px 0;">Buyer</p>
                                        <p style="font-size: 18px; font-weight: 900; color: #000; margin: 0;">{{ $purchase->buyer->name }}</p>
                                        <p style="font-size: 13px; color: #1040C0; margin: 4px 0 0 0; font-weight: 600;">@{{ $purchase->buyer->username }}</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 8px 0;">Skill</p>
                                        <p style="font-size: 18px; font-weight: 900; color: #000; margin: 0;">{{ $purchase->userSkill->skill->name }}</p>
                                        <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0 0;">Level: {{ ucfirst($purchase->userSkill->experience_level) }}</p>
                                    </div>
                                </div>

                                <div style="padding: 12px; background: #f0f4ff; border-left: 4px solid #60a5fa;">
                                    <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #1e40af; margin: 0 0 4px 0;">Status</p>
                                    <p style="font-size: 14px; color: #1e40af; margin: 0;">Work in progress - You accepted this request and should complete the work</p>
                                </div>

                                <p style="font-size: 12px; color: #9ca3af; margin: 12px 0 0 0;">Accepted {{ $purchase->updated_at->diffForHumans() }}</p>
                            </div>

                            <!-- Actions & Amount -->
                            <div style="text-align: right; display: flex; flex-direction: column; gap: 12px; align-items: flex-end;">
                                <div style="background: #10b981; color: white; padding: 12px 16px; border-radius: 0; text-align: center;">
                                    <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.8); margin: 0 0 4px 0;">Amount</p>
                                    <p style="font-size: 32px; font-weight: 900; color: white; margin: 0;">{{ number_format($purchase->amount, 0) }}</p>
                                    <p style="font-size: 12px; color: rgba(255,255,255,0.8); margin: 4px 0 0 0;">coins</p>
                                </div>

                                <a href="{{ route('purchases.show', $purchase) }}" style="display: inline-block; padding: 12px 24px; background: #10b981; color: white; border: 2px solid #000; border-radius: 0; font-weight: 700; text-decoration: none; font-size: 13px; text-transform: uppercase; cursor: pointer; transition: all 200ms; box-shadow: 2px 2px 0 rgba(0,0,0,0.2);" onmouseover="this.style.transform='translate(-1px, -1px)'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.2)';" onmouseout="this.style.transform='translate(0,0)'; this.style.boxShadow='2px 2px 0 rgba(0,0,0,0.2)';">
                                    Mark Work Done
                                </a>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 40px; text-align: center;">
                            <p style="font-size: 18px; font-weight: 700; color: #6b7280; margin: 0 0 8px 0;">No work in progress</p>
                            <p style="font-size: 14px; color: #9ca3af; margin: 0;">Accept pending requests to start working</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Completed Tab -->
            <div id="completed" class="tab-content" style="display: none;">
                <div style="background: white; border: 3px solid #000; border-radius: 0; padding: 0;">
                    @forelse($completedRequests as $purchase)
                        <div style="display: grid; grid-template-columns: 1fr auto; align-items: center; padding: 24px; border-bottom: 2px solid #e5e7eb; gap: 24px;">
                            <!-- Request Info -->
                            <div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 16px;">
                                    <div>
                                        <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 8px 0;">Buyer</p>
                                        <p style="font-size: 18px; font-weight: 900; color: #000; margin: 0;">{{ $purchase->buyer->name }}</p>
                                        <p style="font-size: 13px; color: #1040C0; margin: 4px 0 0 0; font-weight: 600;">@{{ $purchase->buyer->username }}</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin: 0 0 8px 0;">Skill</p>
                                        <p style="font-size: 18px; font-weight: 900; color: #000; margin: 0;">{{ $purchase->userSkill->skill->name }}</p>
                                        <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0 0;">Level: {{ ucfirst($purchase->userSkill->experience_level) }}</p>
                                    </div>
                                </div>

                                <div style="padding: 12px; background: #ecfdf5; border-left: 4px solid #10b981;">
                                    <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #065f46; margin: 0 0 4px 0;">✓ Completed</p>
                                    <p style="font-size: 14px; color: #065f46; margin: 0;">Transaction completed - Coins transferred to your account</p>
                                </div>

                                <p style="font-size: 12px; color: #9ca3af; margin: 12px 0 0 0;">Completed {{ $purchase->updated_at->diffForHumans() }}</p>
                            </div>

                            <!-- Amount -->
                            <div style="text-align: right; display: flex; flex-direction: column; gap: 12px; align-items: flex-end;">
                                <div style="background: #10b981; color: white; padding: 12px 16px; border-radius: 0; text-align: center;">
                                    <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.8); margin: 0 0 4px 0;">Earned</p>
                                    <p style="font-size: 32px; font-weight: 900; color: white; margin: 0;">{{ number_format($purchase->amount, 0) }}</p>
                                    <p style="font-size: 12px; color: rgba(255,255,255,0.8); margin: 4px 0 0 0;">coins</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 40px; text-align: center;">
                            <p style="font-size: 18px; font-weight: 700; color: #6b7280; margin: 0 0 8px 0;">No completed work yet</p>
                            <p style="font-size: 14px; color: #9ca3af; margin: 0;">Complete accepted requests to track your earnings</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });
            
            // Remove active styling from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.style.color = '#6b7280';
                btn.style.borderBottomColor = 'transparent';
            });
            
            // Show selected tab
            document.getElementById(tabName).style.display = 'block';
            
            // Add active styling to clicked button
            event.target.style.color = '#000';
            event.target.style.borderBottomColor = '#000';
        }

        // Set initial active tab
        document.querySelector('[data-tab="pending"]').style.color = '#000';
        document.querySelector('[data-tab="pending"]').style.borderBottomColor = '#000';
    </script>
</x-app-layout>
