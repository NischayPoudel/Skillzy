<x-app-layout>
    <div class="py-12" style="background: #f5f5f5;">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div style="margin-bottom: 32px;">
                <h1 style="font-size: 48px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; color: #1a202c; margin: 0; margin-bottom: 8px;">Rate & Review</h1>
                <p style="font-size: 16px; color: #6b7280; margin: 0;">Share your experience with this skill</p>
            </div>

            <!-- Review Form Card -->
            <div style="background: white; border: 3px solid #000; border-radius: 0; padding: 32px;">
                <!-- Skill Info -->
                <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 2px solid #e5e7eb;">
                    <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; color: #000; margin: 0 0 12px 0;">
                        {{ $purchase->userSkill->skill->name }}
                    </h2>
                    <p style="font-size: 16px; color: #6b7280; margin: 0;">Offered by <strong>{{ $purchase->seller->name }}</strong></p>
                </div>

                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">

                    <!-- Rating -->
                    <div style="margin-bottom: 32px;">
                        <label style="display: block; font-weight: 700; color: #000; margin-bottom: 12px; font-size: 16px; text-transform: uppercase;">Rating <span style="color: #ef4444;">*</span></label>
                        <div style="display: flex; gap: 12px;">
                            @for($i = 1; $i <= 5; $i++)
                                <label style="display: flex; align-items: center; cursor: pointer;">
                                    <input type="radio" name="rating" value="{{ $i }}" style="margin-right: 8px; cursor: pointer;" required
                                        @if(old('rating') == $i) checked @endif>
                                    <span style="font-size: 24px;">
                                        @for($j = 1; $j <= $i; $j++)⭐@endfor
                                    </span>
                                    <span style="margin-left: 8px; color: #6b7280;">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</span>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <p style="color: #ef4444; font-weight: 600; margin-top: 8px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Comment -->
                    <div style="margin-bottom: 32px;">
                        <label for="comment" style="display: block; font-weight: 700; color: #000; margin-bottom: 12px; font-size: 16px; text-transform: uppercase;">Comment (Optional)</label>
                        <textarea name="comment" id="comment" rows="6" style="width: 100%; padding: 12px; border: 2px solid #000; border-radius: 0; font-family: inherit; font-size: 14px; resize: vertical;" placeholder="Share your experience...">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p style="color: #ef4444; font-weight: 600; margin-top: 8px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div style="display: flex; gap: 12px;">
                        <button type="submit" style="flex: 1; padding: 16px; background: #10b981; color: white; border: 2px solid #000; border-radius: 0; font-weight: 700; font-size: 16px; text-transform: uppercase; cursor: pointer; transition: all 200ms ease-out; box-shadow: 3px 3px 0 rgba(0,0,0,0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='5px 5px 0 rgba(0,0,0,0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.2)';">
                            Submit Review
                        </button>
                        <a href="{{ route('purchases.show', $purchase) }}" style="flex: 1; padding: 16px; background: white; color: #000; border: 2px solid #000; border-radius: 0; font-weight: 700; font-size: 16px; text-transform: uppercase; cursor: pointer; transition: all 200ms ease-out; text-decoration: none; display: flex; align-items: center; justify-content: center; box-shadow: 3px 3px 0 rgba(0,0,0,0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='5px 5px 0 rgba(0,0,0,0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='3px 3px 0 rgba(0,0,0,0.2)';">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
