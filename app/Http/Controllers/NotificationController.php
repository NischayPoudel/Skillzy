<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);
        
        return view('notifications.index', ['notifications' => $notifications]);
    }

    /**
     * Get recent notifications as JSON for dropdown
     */
    public function getRecent(): JsonResponse
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->with('purchase.userSkill.skill', 'purchase.buyer', 'purchase.seller')
            ->limit(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function markRead(Notification $notification): RedirectResponse
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
        
        $notification->update(['is_read' => true]);
        return redirect()->back();
    }
}
