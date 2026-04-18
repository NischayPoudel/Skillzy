<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Coin Redemption Requests') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div style="margin-bottom: 2rem;">
                <h1 style="font-size: 2.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: #121212; margin-bottom: 0.5rem;">
                    Coin Redemption Requests
                </h1>
                <div style="height: 4px; width: 100px; background-color: #D02020;"></div>
            </div>

            <!-- Stats Section -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <div style="border: 4px solid #121212; background: white; padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 900; color: #1040C0; margin-bottom: 0.5rem;">{{ $stats['pending'] }}</div>
                    <div style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: #666;">Pending Requests</div>
                </div>
                <div style="border: 4px solid #121212; background: white; padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 900; color: #F0C020; margin-bottom: 0.5rem;">{{ $stats['approved'] }}</div>
                    <div style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: #666;">Approved Requests</div>
                </div>
                <div style="border: 4px solid #121212; background: white; padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 900; color: #D02020; margin-bottom: 0.5rem;">{{ $stats['rejected'] }}</div>
                    <div style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: #666;">Rejected Requests</div>
                </div>
                <div style="border: 4px solid #121212; background: white; padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 900; color: #666; margin-bottom: 0.5rem;">{{ $stats['total_coins'] }}</div>
                    <div style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: #666;">Total Coins to Review</div>
                </div>
            </div>

            <!-- Requests List -->
            <div style="border: 4px solid #121212; background: white; overflow: hidden;">
                @if($redeemRequests->count() > 0)
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #121212; color: white; font-weight: 900; font-size: 0.85rem; text-transform: uppercase;">
                                    <th style="border: 2px solid #F0F0F0; padding: 1rem; text-align: left;">User</th>
                                    <th style="border: 2px solid #F0F0F0; padding: 1rem; text-align: left;">Coins</th>
                                    <th style="border: 2px solid #F0F0F0; padding: 1rem; text-align: left;">Status</th>
                                    <th style="border: 2px solid #F0F0F0; padding: 1rem; text-align: left;">Submitted</th>
                                    <th style="border: 2px solid #F0F0F0; padding: 1rem; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($redeemRequests as $request)
                                    <tr style="border-bottom: 2px solid #F0F0F0; transition: background-color 0.2s ease;"
                                        onmouseover="this.style.backgroundColor='#F9F9F9';"
                                        onmouseout="this.style.backgroundColor='white';">
                                        <td style="border: 2px solid #F0F0F0; padding: 1rem;">
                                            <strong>{{ $request->user->name }}</strong>
                                            <br>
                                            <span style="font-size: 0.85rem; color: #666;">{{ $request->user->email }}</span>
                                        </td>
                                        <td style="border: 2px solid #F0F0F0; padding: 1rem; font-weight: 700;">
                                            <span style="background-color: #1040C0; color: white; padding: 0.25rem 0.75rem; border-radius: 2px; font-size: 0.9rem;">
                                                {{ $request->coins_amount }}
                                            </span>
                                        </td>
                                        <td style="border: 2px solid #F0F0F0; padding: 1rem;">
                                            @if($request->isPending())
                                                <span style="background-color: #F0C020; color: #121212; padding: 0.5rem 1rem; font-weight: 900; font-size: 0.75rem; text-transform: uppercase; border: 2px solid #121212; display: inline-block;">
                                                    Pending
                                                </span>
                                            @elseif($request->isApproved())
                                                <span style="background-color: #90EE90; color: #121212; padding: 0.5rem 1rem; font-weight: 900; font-size: 0.75rem; text-transform: uppercase; border: 2px solid #121212; display: inline-block;">
                                                    Approved
                                                </span>
                                            @else
                                                <span style="background-color: #D02020; color: white; padding: 0.5rem 1rem; font-weight: 900; font-size: 0.75rem; text-transform: uppercase; border: 2px solid #121212; display: inline-block;">
                                                    Rejected
                                                </span>
                                            @endif
                                        </td>
                                        <td style="border: 2px solid #F0F0F0; padding: 1rem; font-size: 0.9rem;">
                                            <div>{{ $request->created_at->format('M d, Y') }}</div>
                                            <div style="color: #666; font-size: 0.85rem;">{{ $request->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td style="border: 2px solid #F0F0F0; padding: 1rem; text-align: center;">
                                            <a href="{{ route('admin.redeem.show', $request) }}"
                                               style="background-color: #1040C0; color: white; border: 2px solid #121212; padding: 0.5rem 1rem; font-weight: 900; font-size: 0.8rem; text-transform: uppercase; text-decoration: none; display: inline-block; transition: all 0.2s ease; cursor: pointer;"
                                               onmouseover="this.style.transform='translate(-2px, -2px)'; this.style.boxShadow='4px 4px 0px rgba(16, 64, 192, 0.2)';"
                                               onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='none';">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div style="padding: 1.5rem; border-top: 2px solid #F0F0F0;">
                        {{ $redeemRequests->links() }}
                    </div>
                @else
                    <div style="padding: 3rem; text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">📋</div>
                        <h3 style="font-size: 1.3rem; font-weight: 700; color: #121212; margin-bottom: 0.5rem;">No Redemption Requests</h3>
                        <p style="color: #666;">There are currently no coin redemption requests to review.</p>
                    </div>
                @endif
            </div>
        </div>
</x-admin-layout>
