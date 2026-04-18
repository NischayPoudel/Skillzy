<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div style="display: grid; grid-template-columns: 280px 1fr; gap: 24px;">
                
                <!-- Left Sidebar Filters -->
                <div style="background: white; border-radius: 8px; overflow: hidden; height: fit-content; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <form method="GET" action="{{ route('listings.index') }}" id="filterForm">
                        <!-- Search Box -->
                        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search skill or user..." style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; font-weight: 600; font-family: inherit; transition: all 200ms ease-out;" onfocus="this.style.borderColor='#1040C0'; this.style.boxShadow='0 0 0 3px rgba(16, 64, 192, 0.08)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        </div>

                        <!-- Search By -->
                        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
                            <h3 style="margin: 0 0 12px 0; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px;">Search In</h3>
                            <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; cursor: pointer;">
                                <input type="radio" name="search_by" value="both" @if(request('search_by') === 'both' || !request('search_by')) checked @endif style="cursor: pointer; width: 16px; height: 16px;">
                                <span style="font-size: 14px; color: #4b5563;">Both</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; cursor: pointer;">
                                <input type="radio" name="search_by" value="skill" @if(request('search_by') === 'skill') checked @endif style="cursor: pointer; width: 16px; height: 16px;">
                                <span style="font-size: 14px; color: #4b5563;">Skill Only</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="radio" name="search_by" value="user" @if(request('search_by') === 'user') checked @endif style="cursor: pointer; width: 16px; height: 16px;">
                                <span style="font-size: 14px; color: #4b5563;">User Only</span>
                            </label>
                        </div>

                        <!-- Experience Level -->
                        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
                            <h3 style="margin: 0 0 12px 0; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px;">Level</h3>
                            <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; cursor: pointer;">
                                <input type="checkbox" name="level" value="beginner" @if(request('level') === 'beginner') checked @endif style="cursor: pointer; width: 16px; height: 16px;">
                                <span style="font-size: 14px; color: #4b5563;">Beginner</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; cursor: pointer;">
                                <input type="checkbox" name="level" value="intermediate" @if(request('level') === 'intermediate') checked @endif style="cursor: pointer; width: 16px; height: 16px;">
                                <span style="font-size: 14px; color: #4b5563;">Intermediate</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" name="level" value="expert" @if(request('level') === 'expert') checked @endif style="cursor: pointer; width: 16px; height: 16px;">
                                <span style="font-size: 14px; color: #4b5563;">Expert</span>
                            </label>
                        </div>

                        <!-- Price Range -->
                        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
                            <h3 style="margin: 0 0 12px 0; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px;">Price Range</h3>
                            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" style="flex: 1; padding: 8px 10px; border: 1px solid #e5e7eb; border-radius: 4px; font-size: 13px;">
                                <span style="display: flex; align-items: center; color: #9ca3af;">-</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" style="flex: 1; padding: 8px 10px; border: 1px solid #e5e7eb; border-radius: 4px; font-size: 13px;">
                            </div>
                        </div>

                        <!-- Sort By -->
                        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
                            <h3 style="margin: 0 0 12px 0; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px;">Sort By</h3>
                            <select name="sort" style="width: 100%; padding: 8px 10px; border: 1px solid #e5e7eb; border-radius: 4px; font-size: 14px; background: white; cursor: pointer;">
                                <option value="latest" @if(request('sort') === 'latest' || !request('sort')) selected @endif>Latest</option>
                                <option value="price_asc" @if(request('sort') === 'price_asc') selected @endif>Price: Low to High</option>
                                <option value="price_desc" @if(request('sort') === 'price_desc') selected @endif>Price: High to Low</option>
                            </select>
                        </div>

                        <!-- Filter & Reset Buttons -->
                        <div style="padding: 16px; display: flex; gap: 8px;">
                            <button type="submit" style="flex: 1; padding: 10px 12px; background: #1040C0; color: white; border: 2px solid #1040C0; border-radius: 6px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 200ms ease-out;" onmouseover="this.style.background='#0D32A4';" onmouseout="this.style.background='#1040C0';">Apply</button>
                            <a href="{{ route('listings.index') }}" style="flex: 1; padding: 10px 12px; background: white; color: #1040C0; border: 2px solid #1040C0; border-radius: 6px; font-size: 14px; font-weight: 700; text-decoration: none; cursor: pointer; text-align: center; transition: all 200ms ease-out;" onmouseover="this.style.background='#f8f9fa';" onmouseout="this.style.background='white';">Reset</a>
                        </div>
                    </form>
                </div>

                <!-- Right Content Area -->
                <div>
                    <!-- Listings Grid - Show when search_by is NOT 'user' -->
                    @if(request('search_by') !== 'user')
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                            @forelse($listings as $listing)
                                <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; position: relative; display: flex; flex-direction: column; transition: all 200ms ease-out; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                                     onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.15)'; this.style.transform='translateY(-2px)';"
                                     onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.transform='translateY(0)';">
                                    
                                    <!-- Image Section -->
                                    <a href="{{ route('listings.show', $listing) }}" style="flex: 1; overflow: hidden; background: #f3f4f6; text-decoration: none; display: block; cursor: pointer; min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                        @if($listing->skill->icon)
                                            @if(str_contains($listing->skill->icon, '/') || str_contains($listing->skill->icon, '.'))
                                                <!-- File path - display as image -->
                                                <img src="{{ asset('storage/' . $listing->skill->icon) }}" alt="{{ $listing->skill->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                            @else
                                                <!-- Emoji - display centered -->
                                                <div style="font-size: 48px;">{{ $listing->skill->icon }}</div>
                                            @endif
                                        @else
                                            <div style="font-size: 32px; color: #d1d5db; font-weight: 600;">No Image</div>
                                        @endif
                                    </a>
                                    
                                    <!-- Info Section -->
                                    <div style="padding: 12px; background: white; border-top: 1px solid #e5e7eb; display: flex; flex-direction: column; gap: 8px;">
                                        <a href="{{ route('listings.show', $listing) }}" style="text-decoration: none;">
                                            <h3 style="margin: 0; font-size: 14px; font-weight: 700; color: #1f2937; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; transition: color 200ms ease; color: #1040C0;">{{ $listing->skill->name }}</h3>
                                        </a>
                                        
                                        <!-- User Profile Section -->
                                        <a href="{{ route('profile.public', $listing->user) }}" style="text-decoration: none; display: flex; align-items: center; gap: 8px;">
                                            @if($listing->user->profile_image)
                                                <img src="{{ asset('storage/' . $listing->user->profile_image) }}" alt="{{ $listing->user->name }}" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                                            @else
                                                <div style="width: 28px; height: 28px; border-radius: 50%; background: #e5e7eb; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 12px; font-weight: 700; color: #6b7280;">{{ substr($listing->user->name, 0, 1) }}</div>
                                            @endif
                                            <span style="font-size: 12px; color: #1f2937; font-weight: 500; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $listing->user->name }}</span>
                                        </a>
                                        
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 4px;">
                                            <span style="font-size: 12px; font-weight: 700; color: #1f2937;">₹{{ number_format($listing->price, 0) }}</span>
                                            <span style="font-size: 11px; background: #f0f0f0; padding: 3px 6px; border-radius: 4px; color: #6b7280; text-transform: uppercase;">{{ ucfirst($listing->experience_level) }}</span>
                                        </div>
                                        
                                        <!-- Message Button -->
                                        @auth
                                            @if(Auth::user()->id !== $listing->user_id)
                                                <x-message-modal :listing="$listing" />
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @empty
                                <div style="grid-column: 1 / -1; text-align: center; padding: 32px; color: #6b7280;">
                                    {{ __('No listings found') }}
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $listings->links() }}
                        </div>
                    @endif

                    <!-- User Profiles Section - Show when search_by is NOT 'skill' -->
                    @if(request('search_by') !== 'skill' && $sellers->count() > 0)
                        <div style="margin-top: 40px;">
                            <h3 style="font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 20px; text-align: center;">Featured Sellers</h3>
                            <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 24px;">
                                @foreach($sellers as $seller)
                                    <div style="text-align: center;">
                                        <a href="{{ route('profile.public', $seller) }}" style="text-decoration: none; display: inline-block;">
                                            <div style="position: relative; display: inline-block;">
                                                @if($seller->profile_image)
                                                    <img src="{{ asset('storage/' . $seller->profile_image) }}" alt="{{ $seller->name }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #1040C0; transition: all 200ms ease; box-shadow: 0 4px 12px rgba(16, 64, 192, 0.15);" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 20px rgba(16, 64, 192, 0.25)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 12px rgba(16, 64, 192, 0.15)';">
                                                @else
                                                    <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; font-size: 48px; font-weight: 700; color: white; border: 3px solid #1040C0; transition: all 200ms ease; box-shadow: 0 4px 12px rgba(16, 64, 192, 0.15);" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 20px rgba(16, 64, 192, 0.25)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 12px rgba(16, 64, 192, 0.15)';">{{ substr($seller->name, 0, 1) }}</div>
                                                @endif
                                            </div>
                                        </a>
                                        <p style="margin-top: 12px; font-size: 14px; font-weight: 600; color: #1f2937; max-width: 140px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $seller->name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
</x-app-layout>
