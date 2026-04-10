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
                @forelse($pendingRequests as $purchase)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; position: relative; display: flex; flex-direction: column; transition: all 200ms ease-out; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                             onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.15)'; this.style.transform='translateY(-2px)';"
                             onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.transform='translateY(0)';">
                            
                            <!-- Image Section -->
                            <div style="flex: 1; overflow: hidden; background: #f3f4f6; text-decoration: none; display: flex; align-items: center; justify-content: center; min-height: 200px; cursor: pointer;">
                                @if($purchase->userSkill->skill->icon)
                                    @if(str_contains($purchase->userSkill->skill->icon, '/') || str_contains($purchase->userSkill->skill->icon, '.'))
                                        <img src="{{ asset('storage/' . $purchase->userSkill->skill->icon) }}" alt="{{ $purchase->userSkill->skill->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                    @else
                                        <div style="font-size: 48px;">{{ $purchase->userSkill->skill->icon }}</div>
                                    @endif
                                @else
                                    <div style="font-size: 32px; color: #d1d5db; font-weight: 600;">No Image</div>
                                @endif
                            </div>
                            
                            <!-- Card Content -->
                            <div style="padding: 16px; background: white; border-top: 1px solid #e5e7eb; display: flex; flex-direction: column; gap: 12px; flex: 1;">
                                <!-- Skill Name -->
                                <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #1040C0; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $purchase->userSkill->skill->name }}</h3>
                                
                                <!-- Buyer Info -->
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: #1040C0; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 12px;">{{ substr($purchase->buyer->name, 0, 1) }}</div>
                                    <div>
                                        <p style="margin: 0; font-size: 13px; font-weight: 700; color: #1f2937;">{{ $purchase->buyer->name }}</p>
                                        <p style="margin: 0; font-size: 12px; color: #6b7280;">@{{ $purchase->buyer->username }}</p>
                                    </div>
                                </div>

                                <!-- Level & Amount -->
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 8px;">
                                    <span style="font-size: 12px; font-weight: 700; color: #1f2937;">{{ ucfirst($purchase->userSkill->experience_level) }}</span>
                                    <span style="font-size: 14px; font-weight: 900; color: #1040C0;">₹{{ number_format($purchase->amount, 0) }}</span>
                                </div>

                                <!-- Note Preview -->
                                @if($purchase->note)
                                    <div style="padding: 8px; background: #f0f4ff; border-left: 3px solid #1040C0; margin-top: 4px; border-radius: 2px;">
                                        <p style="margin: 0; font-size: 12px; color: #1f2937; line-height: 1.4; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $purchase->note }}</p>
                                    </div>
                                @endif

                                <!-- View Button -->
                                <a href="{{ route('purchases.show', $purchase) }}" style="display: block; padding: 12px; background: #1040C0; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 700; text-decoration: none; cursor: pointer; text-align: center; transition: all 200ms ease-out; margin-top: 8px;" onmouseover="this.style.background='#0D32A4'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#1040C0'; this.style.transform='translateY(0)';">View & Accept</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 8px;">
                        <p style="font-size: 18px; font-weight: 700; color: #6b7280; margin: 0 0 8px 0;">No pending requests</p>
                        <p style="font-size: 14px; color: #9ca3af; margin: 0;">You'll see new requests here when buyers request your listings</p>
                    </div>
                @endforelse
            </div>

            <!-- Accepted (In Progress) Tab -->
            <div id="accepted" class="tab-content" style="display: none;">
                @forelse($acceptedRequests as $purchase)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; position: relative; display: flex; flex-direction: column; transition: all 200ms ease-out; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                             onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.15)'; this.style.transform='translateY(-2px)';"
                             onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.transform='translateY(0)';">
                            
                            <!-- Image Section -->
                            <div style="flex: 1; overflow: hidden; background: #f3f4f6; text-decoration: none; display: flex; align-items: center; justify-content: center; min-height: 200px; cursor: pointer;">
                                @if($purchase->userSkill->skill->icon)
                                    @if(str_contains($purchase->userSkill->skill->icon, '/') || str_contains($purchase->userSkill->skill->icon, '.'))
                                        <img src="{{ asset('storage/' . $purchase->userSkill->skill->icon) }}" alt="{{ $purchase->userSkill->skill->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                    @else
                                        <div style="font-size: 48px;">{{ $purchase->userSkill->skill->icon }}</div>
                                    @endif
                                @else
                                    <div style="font-size: 32px; color: #d1d5db; font-weight: 600;">No Image</div>
                                @endif
                            </div>
                            
                            <!-- Card Content -->
                            <div style="padding: 16px; background: white; border-top: 1px solid #e5e7eb; display: flex; flex-direction: column; gap: 12px; flex: 1;">
                                <!-- Skill Name -->
                                <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #10b981; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $purchase->userSkill->skill->name }}</h3>
                                
                                <!-- Buyer Info -->
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: #10b981; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 12px;">{{ substr($purchase->buyer->name, 0, 1) }}</div>
                                    <div>
                                        <p style="margin: 0; font-size: 13px; font-weight: 700; color: #1f2937;">{{ $purchase->buyer->name }}</p>
                                        <p style="margin: 0; font-size: 12px; color: #6b7280;">@{{ $purchase->buyer->username }}</p>
                                    </div>
                                </div>

                                <!-- Level & Amount -->
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 8px;">
                                    <span style="font-size: 12px; font-weight: 700; background: #f0fdf4; padding: 4px 8px; border-radius: 4px; color: #10b981;">In Progress</span>
                                    <span style="font-size: 14px; font-weight: 900; color: #10b981;">₹{{ number_format($purchase->amount, 0) }}</span>
                                </div>

                                <!-- Status Note -->
                                <div style="padding: 8px; background: #f0fdf4; border-left: 3px solid #10b981; border-radius: 2px; margin-top: 4px;">
                                    <p style="margin: 0; font-size: 12px; color: #065f46; font-weight: 600;">Work in progress - Complete to mark done</p>
                                </div>

                                <!-- Mark Done Button -->
                                <a href="{{ route('purchases.show', $purchase) }}" style="display: block; padding: 12px; background: #10b981; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 700; text-decoration: none; cursor: pointer; text-align: center; transition: all 200ms ease-out; margin-top: 8px;" onmouseover="this.style.background='#059669'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#10b981'; this.style.transform='translateY(0)';">Mark Work Done</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 8px;">
                        <p style="font-size: 18px; font-weight: 700; color: #6b7280; margin: 0 0 8px 0;">No work in progress</p>
                        <p style="font-size: 14px; color: #9ca3af; margin: 0;">Accept pending requests to start working</p>
                    </div>
                @endforelse
            </div>

            <!-- Completed Tab -->
            <div id="completed" class="tab-content" style="display: none;">
                @forelse($completedRequests as $purchase)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; position: relative; display: flex; flex-direction: column; transition: all 200ms ease-out; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                             onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.15)'; this.style.transform='translateY(-2px)';"
                             onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.transform='translateY(0)';">
                            
                            <!-- Image Section -->
                            <div style="flex: 1; overflow: hidden; background: #f3f4f6; text-decoration: none; display: flex; align-items: center; justify-content: center; min-height: 200px; cursor: pointer;">
                                @if($purchase->userSkill->skill->icon)
                                    @if(str_contains($purchase->userSkill->skill->icon, '/') || str_contains($purchase->userSkill->skill->icon, '.'))
                                        <img src="{{ asset('storage/' . $purchase->userSkill->skill->icon) }}" alt="{{ $purchase->userSkill->skill->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                    @else
                                        <div style="font-size: 48px;">{{ $purchase->userSkill->skill->icon }}</div>
                                    @endif
                                @else
                                    <div style="font-size: 32px; color: #d1d5db; font-weight: 600;">No Image</div>
                                @endif
                            </div>
                            
                            <!-- Card Content -->
                            <div style="padding: 16px; background: white; border-top: 1px solid #e5e7eb; display: flex; flex-direction: column; gap: 12px; flex: 1;">
                                <!-- Skill Name -->
                                <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #10b981; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $purchase->userSkill->skill->name }}</h3>
                                
                                <!-- Buyer Info -->
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: #10b981; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 12px;">{{ substr($purchase->buyer->name, 0, 1) }}</div>
                                    <div>
                                        <p style="margin: 0; font-size: 13px; font-weight: 700; color: #1f2937;">{{ $purchase->buyer->name }}</p>
                                        <p style="margin: 0; font-size: 12px; color: #6b7280;">@{{ $purchase->buyer->username }}</p>
                                    </div>
                                </div>

                                <!-- Level & Amount -->
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 8px;">
                                    <span style="font-size: 12px; font-weight: 700; background: #f0fdf4; padding: 4px 8px; border-radius: 4px; color: #10b981;">✓ Completed</span>
                                    <span style="font-size: 14px; font-weight: 900; color: #10b981;">₹{{ number_format($purchase->amount, 0) }}</span>
                                </div>

                                <!-- Completion Note -->
                                <div style="padding: 8px; background: #f0fdf4; border-left: 3px solid #10b981; border-radius: 2px; margin-top: 4px;">
                                    <p style="margin: 0; font-size: 12px; color: #065f46; font-weight: 600;">✓ Coins transferred to your account</p>
                                </div>

                                <!-- View Button -->
                                <a href="{{ route('purchases.show', $purchase) }}" style="display: block; padding: 12px; background: #10b981; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 700; text-decoration: none; cursor: pointer; text-align: center; transition: all 200ms ease-out; margin-top: 8px;" onmouseover="this.style.background='#059669'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#10b981'; this.style.transform='translateY(0)';">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 8px;">
                        <p style="font-size: 18px; font-weight: 700; color: #6b7280; margin: 0 0 8px 0;">No completed work yet</p>
                        <p style="font-size: 14px; color: #9ca3af; margin: 0;">Complete accepted requests to track your earnings</p>
                    </div>
                @endforelse
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
