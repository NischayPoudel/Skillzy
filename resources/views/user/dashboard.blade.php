<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px;">
                <!-- Coins Card -->
                <div style="background: linear-gradient(135deg, #1040C0 0%, #0D32A4 100%); border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(16, 64, 192, 0.2); color: white; transition: all 200ms ease-out;" 
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(16, 64, 192, 0.3)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(16, 64, 192, 0.2)';">
                    <p style="margin: 0; font-size: 13px; font-weight: 600; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('Your Coins') }}</p>
                    <p style="margin: 12px 0 0 0; font-size: 36px; font-weight: 800;">{{ number_format($coins, 0) }}</p>
                </div>
                
                <!-- Active Listings Card -->
                <div style="background: linear-gradient(135deg, #F0C020 0%, #E5B212 100%); border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(240, 192, 32, 0.2); color: #1a202c; transition: all 200ms ease-out;" 
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(240, 192, 32, 0.3)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(240, 192, 32, 0.2)';">
                    <p style="margin: 0; font-size: 13px; font-weight: 600; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('Active Listings') }}</p>
                    <p style="margin: 12px 0 0 0; font-size: 36px; font-weight: 800;">{{ $totalListings }}</p>
                </div>
                
                <!-- Total Purchases Card -->
                <div style="background: linear-gradient(135deg, #D02020 0%, #B01818 100%); border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(208, 32, 32, 0.2); color: white; transition: all 200ms ease-out;" 
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(208, 32, 32, 0.3)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(208, 32, 32, 0.2)';">
                    <p style="margin: 0; font-size: 13px; font-weight: 600; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('Total Purchases') }}</p>
                    <p style="margin: 12px 0 0 0; font-size: 36px; font-weight: 800;">{{ $totalPurchases }}</p>
                </div>
                
                <!-- Total Earnings Card -->
                <div style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); color: white; transition: all 200ms ease-out;" 
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(16, 185, 129, 0.3)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(16, 185, 129, 0.2)';">
                    <p style="margin: 0; font-size: 13px; font-weight: 600; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('Total Earnings') }}</p>
                    <p style="margin: 12px 0 0 0; font-size: 36px; font-weight: 800;">{{ number_format($totalEarnings, 0) }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div style="background: white; border: 2px solid #1040C0; border-radius: 12px; padding: 28px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 40px;">
                <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 700; color: #1f2937;">{{ __('Quick Actions') }}</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                    <a href="{{ route('listings.index') }}" style="padding: 12px 24px; background: #1040C0; color: white; border: 2px solid #1040C0; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 200ms ease-out;" onmouseover="this.style.background='#0D32A4'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#1040C0'; this.style.transform='translateY(0)';">Browse Skills</a>
                    <a href="#" style="padding: 12px 24px; background: white; color: #1040C0; border: 2px solid #1040C0; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 200ms ease-out;" onmouseover="this.style.background='#f8f9fa'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='white'; this.style.transform='translateY(0)';">My Listings</a>
                    <a href="{{ route('wallet.show') }}" style="padding: 12px 24px; background: white; color: #1040C0; border: 2px solid #1040C0; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 200ms ease-out;" onmouseover="this.style.background='#f8f9fa'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='white'; this.style.transform='translateY(0)';">Top Up Coins</a>
                    <a href="#" style="padding: 12px 24px; background: white; color: #1040C0; border: 2px solid #1040C0; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 200ms ease-out;" onmouseover="this.style.background='#f8f9fa'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='white'; this.style.transform='translateY(0)';">Messages</a>
                </div>
            </div>

            <!-- Top Rated Skills Section -->
            @if($topRatedSkills && count($topRatedSkills) > 0)
            <div class="mt-12">
                <h2 class="text-3xl font-black uppercase tracking-tighter mb-8">Top Rated Skills</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                    @foreach($topRatedSkills as $skill)
                    <a href="{{ route('listings.show', $skill) }}" style="text-decoration: none; group;">
                        <div style="aspect-ratio: 1/1; background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; position: relative; display: flex; flex-direction: column; transition: all 200ms ease-out; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                             onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.15)'; this.style.transform='translateY(-2px)';"
                             onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.transform='translateY(0)';">
                            
                            <!-- Image Section -->
                            <div style="flex: 1; overflow: hidden; background: #f3f4f6;">
                                @if($skill->skill->icon)
                                    <img src="{{ asset('storage/' . $skill->skill->icon) }}" alt="{{ $skill->skill->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                @else
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 32px;">📚</div>
                                @endif
                            </div>
                            
                            <!-- Info Section -->
                            <div style="padding: 8px; background: white; border-top: 1px solid #e5e7eb;">
                                <h3 style="margin: 0; font-size: 11px; font-weight: 700; color: #1f2937; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $skill->skill->name ?? 'N/A' }}</h3>
                                <p style="margin: 2px 0 0 0; font-size: 10px; color: #6b7280; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $skill->user->name ?? 'Unknown' }}</p>
                                <div style="margin-top: 4px; display: flex; align-items: center; justify-content: space-between;">
                                    <span style="font-size: 11px; font-weight: 700; color: #1f2937;">{{ number_format($skill->price ?? 0, 0) }}</span>
                                    <span style="font-size: 10px; color: #fbbf24;">★ {{ number_format($skill->avg_rating ?? 0, 1) }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
