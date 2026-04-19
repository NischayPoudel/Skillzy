<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Purchases & Requests') }}
            </h2>
            <a href="{{ route('user.listings.management') }}" style="padding: 10px 24px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: 2px solid #000; border-radius: 0; text-decoration: none; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 200ms ease; box-shadow: 2px 2px 0 rgba(0,0,0,0.2);" onmouseover="this.style.transform='translate(-1px, -1px)'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.3)';" onmouseout="this.style.transform='translate(0,0)'; this.style.boxShadow='2px 2px 0 rgba(0,0,0,0.2)';">
                💼 Billing & Requests
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($message = session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg font-semibold">✓ {{ $message }}</div>
            @endif

            <!-- Purchases Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                @forelse($purchases as $purchase)
                    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; position: relative; display: flex; flex-direction: column; transition: all 200ms ease-out; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                         onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.15)'; this.style.transform='translateY(-2px)';"
                         onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.transform='translateY(0)';">
                        
                        <!-- Image Section -->
                        <div style="flex: 1; overflow: hidden; background: #f3f4f6; display: flex; align-items: center; justify-content: center; min-height: 200px;">
                            @if($purchase->userSkill->skill->icon)
                                @if(str_contains($purchase->userSkill->skill->icon, '/') || str_contains($purchase->userSkill->skill->icon, '.'))
                                    <img src="{{ asset('storage/' . $purchase->userSkill->skill->icon) }}" alt="{{ $purchase->userSkill->skill->name }}" style="width: 100%; height: 100%; object-fit: cover;">
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
                            
                            <!-- Seller Info -->
                            <div>
                                <p style="margin: 0; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #6b7280; letter-spacing: 0.5px;">Seller</p>
                                <p style="margin: 4px 0 0 0; font-size: 13px; font-weight: 700; color: #1f2937;">{{ $purchase->seller->name }}</p>
                            </div>

                            <!-- Amount & Status -->
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 8px; padding-top: 8px; border-top: 1px solid #e5e7eb;">
                                <span style="font-size: 14px; font-weight: 900; color: #1040C0;">₹{{ number_format($purchase->amount, 0) }}</span>
                                <span style="font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;
                                    @if($purchase->status === 'pending') background: #fef3c7; color: #92400e;
                                    @elseif($purchase->status === 'accepted') background: #dbeafe; color: #1e40af;
                                    @elseif($purchase->status === 'completed') background: #dcfce7; color: #166534;
                                    @else background: #fee2e2; color: #991b1b;
                                    @endif
                                    text-transform: uppercase;">{{ ucfirst($purchase->status) }}</span>
                            </div>

                            <!-- View Button -->
                            <a href="{{ route('purchases.show', $purchase) }}" style="display: block; padding: 12px; background: #1040C0; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 700; text-decoration: none; cursor: pointer; text-align: center; transition: all 200ms ease-out; margin-top: 8px;" onmouseover="this.style.background='#0D32A4'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#1040C0'; this.style.transform='translateY(0)';">View Details</a>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
                        <p style="font-size: 18px; font-weight: 700; color: #6b7280; margin: 0 0 8px 0;">No purchases found</p>
                        <p style="font-size: 14px; color: #9ca3af; margin: 0;">Start purchasing skills from our community of experts</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div style="margin-top: 32px;">
                {{ $purchases->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
