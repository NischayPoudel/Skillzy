<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters - Horizontal Bold -->
            <div style="background: white; border: 2px solid #1040C0; border-radius: 8px; padding: 16px 20px; margin-bottom: 40px;">
                <form method="GET" action="{{ route('listings.index') }}" style="display: flex; align-items: center; gap: 16px; flex-wrap: nowrap; overflow-x: auto;" id="filterForm">
                    <!-- Search -->
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search skill..." style="padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 15px; font-weight: 600; font-family: inherit; transition: all 200ms ease-out; flex: 1; min-width: 200px;" onfocus="this.style.borderColor='#1040C0'; this.style.boxShadow='0 0 0 3px rgba(16, 64, 192, 0.08)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">

                    <!-- Level Dropdown -->
                    <select name="level" style="padding: 12px 14px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 15px; font-weight: 600; background: white; cursor: pointer; font-family: inherit; transition: all 200ms ease-out; white-space: nowrap;" onfocus="this.style.borderColor='#1040C0'; this.style.boxShadow='0 0 0 3px rgba(16, 64, 192, 0.08)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <option value="">All Levels</option>
                        <option value="beginner" @if(request('level') === 'beginner') selected @endif>Beginner</option>
                        <option value="intermediate" @if(request('level') === 'intermediate') selected @endif>Intermediate</option>
                        <option value="expert" @if(request('level') === 'expert') selected @endif>Expert</option>
                    </select>

                    <!-- Sort Dropdown -->
                    <select name="sort" style="padding: 12px 14px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 15px; font-weight: 600; background: white; cursor: pointer; font-family: inherit; transition: all 200ms ease-out; white-space: nowrap;" onfocus="this.style.borderColor='#1040C0'; this.style.boxShadow='0 0 0 3px rgba(16, 64, 192, 0.08)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <option value="latest" @if(request('sort') === 'latest' || !request('sort')) selected @endif>Latest</option>
                        <option value="price_asc" @if(request('sort') === 'price_asc') selected @endif>Price: Low → High</option>
                        <option value="price_desc" @if(request('sort') === 'price_desc') selected @endif>Price: High → Low</option>
                    </select>

                    <!-- Price Range -->
                    <div style="display: flex; align-items: center; gap: 8px; white-space: nowrap;">
                        <span style="font-size: 15px; font-weight: 700; color: #1a202c;">Price:</span>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" style="width: 65px; padding: 12px 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 15px; font-weight: 600; font-family: inherit; transition: all 200ms ease-out; background: white;" onfocus="this.style.borderColor='#1040C0'; this.style.boxShadow='0 0 0 3px rgba(16, 64, 192, 0.08)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <span style="color: #9ca3af; font-weight: 700; font-size: 16px;">-</span>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" style="width: 65px; padding: 12px 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 15px; font-weight: 600; font-family: inherit; transition: all 200ms ease-out; background: white;" onfocus="this.style.borderColor='#1040C0'; this.style.boxShadow='0 0 0 3px rgba(16, 64, 192, 0.08)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>

                    <!-- Filter & Reset Buttons -->
                    <div style="display: flex; align-items: center; gap: 12px; white-space: nowrap;">
                        <button type="submit" style="padding: 12px 24px; background: #1040C0; color: white; border: 2px solid #1040C0; border-radius: 6px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 200ms ease-out; font-family: inherit;" onmouseover="this.style.background='#0D32A4'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#1040C0'; this.style.transform='translateY(0)';">Filter</button>
                        <a href="{{ route('listings.index') }}" style="padding: 12px 24px; background: white; color: #1040C0; border: 2px solid #1040C0; border-radius: 6px; font-size: 15px; font-weight: 700; text-decoration: none; cursor: pointer; transition: all 200ms ease-out;" onmouseover="this.style.background='#f8f9fa'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='white'; this.style.transform='translateY(0)';">Reset</a>
                    </div>
                </form>
            </div>

            <!-- Listings Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                @forelse($listings as $listing)
                    <a href="{{ route('listings.show', $listing) }}" style="text-decoration: none;">
                        <div style="aspect-ratio: 1/1; background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; position: relative; display: flex; flex-direction: column; transition: all 200ms ease-out; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                             onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.15)'; this.style.transform='translateY(-2px)';"
                             onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.transform='translateY(0)';">
                            
                            <!-- Image Section -->
                            <div style="flex: 1; overflow: hidden; background: #f3f4f6;">
                                @if($listing->skill->icon)
                                    <img src="{{ asset('storage/' . $listing->skill->icon) }}" alt="{{ $listing->skill->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                @else
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 32px;">📚</div>
                                @endif
                            </div>
                            
                            <!-- Info Section -->
                            <div style="padding: 8px; background: white; border-top: 1px solid #e5e7eb;">
                                <h3 style="margin: 0; font-size: 11px; font-weight: 700; color: #1f2937; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $listing->skill->name }}</h3>
                                <p style="margin: 2px 0 0 0; font-size: 10px; color: #6b7280; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $listing->user->name }}</p>
                                <div style="margin-top: 4px; display: flex; align-items: center; justify-content: space-between;">
                                    <span style="font-size: 11px; font-weight: 700; color: #1f2937;">{{ number_format($listing->price, 0) }}</span>
                                    <span style="font-size: 10px; background: #f0f0f0; padding: 2px 4px; border-radius: 4px; color: #6b7280; text-transform: uppercase;">{{ ucfirst($listing->experience_level) }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
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
        </div>
    </div>
</x-app-layout>
