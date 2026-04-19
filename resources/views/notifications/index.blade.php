<x-app-layout>
    <style>
        .notification-card {
            background: white;
            border: 3px solid #121212;
            box-shadow: 6px 6px 0px rgba(18, 18, 18, 0.1);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .notification-card:hover {
            transform: translate(-3px, -3px);
            box-shadow: 9px 9px 0px rgba(18, 18, 18, 0.2);
        }

        .notification-card.unread {
            border-left: 8px solid #D02020;
            background: linear-gradient(135deg, #FEF5F5 0%, #FFFFFF 100%);
        }

        .notification-card.read {
            opacity: 0.85;
            border-color: #E5E7EB;
        }

        .notification-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 0;
            border: 2px solid #121212;
            flex-shrink: 0;
            font-weight: 900;
            font-size: 24px;
            background: #F0F0F0;
        }

        .notification-icon.topup {
            background: #F0C020;
            border-color: #121212;
            color: #121212;
        }

        .notification-icon.purchase {
            background: #1040C0;
            border-color: #121212;
            color: white;
        }

        .notification-icon.completed {
            background: #F0F0F0;
            border-color: #121212;
            color: #121212;
        }

        .notification-icon.review {
            background: #D02020;
            border-color: #121212;
            color: white;
        }

        .notification-badge {
            display: inline-block;
            background: #D02020;
            color: white;
            font-weight: 900;
            font-size: 10px;
            padding: 4px 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 2px solid #121212;
            margin-top: 8px;
        }

        .btn-action {
            padding: 10px 16px;
            font-weight: 700;
            border: 2px solid #121212;
            background: white;
            color: #121212;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.2s ease;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
        }

        .btn-action:hover {
            background: #121212;
            color: white;
            transform: translate(2px, 2px);
        }

        .btn-primary {
            background: #1040C0;
            color: white;
            border-color: #1040C0;
        }

        .btn-primary:hover {
            background: #0D32A4;
            border-color: #0D32A4;
            color: white;
        }

        .btn-accent {
            background: #D02020;
            color: white;
            border-color: #D02020;
        }

        .btn-accent:hover {
            background: #B01D1D;
            border-color: #B01D1D;
            color: white;
        }

        .notification-title {
            font-size: 18px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #121212;
            margin: 0;
            line-height: 1.2;
        }

        .notification-message {
            font-size: 14px;
            color: #4B5563;
            margin-top: 8px;
            line-height: 1.5;
        }

        .notification-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 12px;
            padding: 12px;
            background: #F9FAFB;
            border: 2px solid #E5E7EB;
        }

        .notification-meta-item {
            font-size: 13px;
        }

        .notification-meta-label {
            font-weight: 700;
            color: #121212;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            font-size: 11px;
        }

        .notification-meta-value {
            color: #4B5563;
            margin-top: 3px;
            font-weight: 600;
        }

        .notification-time {
            font-size: 12px;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-top: 8px;
        }

        .no-notifications {
            background: white;
            border: 4px solid #121212;
            padding: 48px 32px;
            text-align: center;
        }

        .no-notifications-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }

        .no-notifications-title {
            font-size: 24px;
            font-weight: 900;
            color: #121212;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .no-notifications-text {
            color: #4B5563;
            font-size: 14px;
            margin-top: 8px;
        }

        .header-section {
            margin-bottom: 32px;
        }

        .header-title {
            font-size: 48px;
            font-weight: 900;
            color: #121212;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0 0 8px 0;
            line-height: 1;
        }

        .header-underline {
            height: 6px;
            width: 120px;
            background: #D02020;
            margin-bottom: 16px;
        }

        .header-subtitle {
            color: #4B5563;
            font-size: 15px;
            font-weight: 600;
        }

        .unread-badge {
            display: inline-block;
            background: #D02020;
            color: white;
            padding: 8px 16px;
            font-weight: 900;
            border: 2px solid #121212;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .actions-section {
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 140px;
        }

        .notification-container {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 20px;
            align-items: flex-start;
        }

        .content-section {
            flex: 1;
            min-width: 0;
        }
    </style>

    <div class="px-4 py-8" style="background: #F0F0F0; min-height: calc(100vh - 70px);">
        <div style="max-width: 1200px; margin: 0 auto;">
            <!-- Header -->
            <div class="header-section">
                <h1 class="header-title">Notifications</h1>
                <div class="header-underline"></div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <p class="header-subtitle">Stay updated with your account activity</p>
                    @php
                        $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="unread-badge">{{ $unreadCount }} New</span>
                    @endif
                </div>
            </div>

            <!-- Notifications List -->
            <div style="display: grid; gap: 16px;">
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="notification-card {{ !$notification->is_read ? 'unread' : 'read' }}">
                            <div style="padding: 24px;">
                                <div class="notification-container">
                                    <!-- Icon -->
                                    <div class="notification-icon @if(strpos($notification->type, 'topup') !== false) topup @elseif(strpos($notification->type, 'purchase') !== false) purchase @elseif(strpos($notification->type, 'review') !== false) review @else completed @endif">
                                        @if(strpos($notification->type, 'topup') !== false)
                                            ⬆
                                        @elseif(strpos($notification->type, 'purchase_request') !== false)
                                            ◉
                                        @elseif(strpos($notification->type, 'purchase_accepted') !== false)
                                            ✓
                                        @elseif(strpos($notification->type, 'purchase_completed') !== false)
                                            ★
                                        @elseif(strpos($notification->type, 'review') !== false)
                                            ◆
                                        @else
                                            ✦
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="content-section">
                                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                                            <h3 class="notification-title">{{ $notification->title }}</h3>
                                            @if(!$notification->is_read)
                                                <span class="notification-badge">New</span>
                                            @endif
                                        </div>

                                        <p class="notification-message">{{ $notification->message }}</p>

                                        <!-- Purchase Details -->
                                        @if($notification->purchase)
                                            <div class="notification-meta">
                                                <div class="notification-meta-item">
                                                    <span class="notification-meta-label">Skill</span>
                                                    <div class="notification-meta-value">{{ $notification->purchase->userSkill->skill->name }}</div>
                                                </div>
                                                <div class="notification-meta-item">
                                                    <span class="notification-meta-label">Amount</span>
                                                    <div class="notification-meta-value">{{ number_format($notification->purchase->amount, 0) }} coins</div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="actions-section">
                                        @if($notification->purchase)
                                            <a 
                                                href="{{ route('purchases.show', $notification->purchase) }}"
                                                class="btn-action btn-primary"
                                            >
                                                View Details
                                            </a>

                                            @if($notification->type === 'purchase_request' && auth()->id() === $notification->purchase->seller_id)
                                                <a 
                                                    href="{{ route('user.listings.management') }}"
                                                    class="btn-action"
                                                >
                                                    Listings
                                                </a>
                                            @endif
                                        @endif

                                        @if(!$notification->is_read)
                                            <form action="{{ route('notifications.markRead', $notification) }}" method="POST" style="display: contents;">
                                                @csrf
                                                <button 
                                                    type="submit" 
                                                    class="btn-action btn-accent"
                                                >
                                                    Mark Read
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div style="margin-top: 24px; display: flex; justify-content: center;">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="no-notifications">
                        <div class="no-notifications-icon">🔔</div>
                        <p class="no-notifications-title">All Caught Up!</p>
                        <p class="no-notifications-text">You don't have any notifications yet. Notifications will appear here when you have account activity.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
