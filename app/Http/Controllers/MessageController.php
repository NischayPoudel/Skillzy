<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStoreRequest;
use App\Models\Message;
use App\Models\Purchase;
use App\Models\UserSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all conversations for the authenticated user
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Get unique conversations grouped by the other user
        $conversationPartners = Message::where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver', 'userSkill', 'purchase'])
            ->latest()
            ->get()
            ->groupBy(function($message) use ($user) {
                return $message->sender_id === $user->id ? $message->receiver_id : $message->sender_id;
            })
            ->map(function($messages) {
                return $messages->first();
            })
            ->values();

        // Mark received messages as read
        Message::where('receiver_id', $user->id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return view('messages.index', ['conversations' => $conversationPartners]);
    }

    /**
     * Show a specific conversation with a user
     */
    public function show($userId): View
    {
        $user = Auth::user();
        $otherUser = \App\Models\User::findOrFail($userId);

        // Get all messages between these two users
        $messages = Message::where(function($query) use ($user, $userId) {
                $query->where([
                    ['sender_id', $user->id],
                    ['receiver_id', $userId]
                ])->orWhere([
                    ['sender_id', $userId],
                    ['receiver_id', $user->id]
                ]);
            })
            ->with(['sender', 'receiver', 'userSkill', 'purchase'])
            ->oldest()
            ->get();

        // Mark all messages from the other user as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', $user->id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return view('messages.show', [
            'messages' => $messages,
            'otherUser' => $otherUser,
        ]);
    }

    /**
     * Store a new message
     * Can be used for both purchase-related and skill listing messages
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'message' => 'nullable|string|min:1|max:5000',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'purchase_id' => 'nullable|exists:purchases,id',
            'user_skill_id' => 'nullable|exists:user_skills,id',
            'receiver_id' => 'nullable|exists:users,id',
        ]);

        // Ensure either message or attachment is provided
        if (!$request->message && !$request->hasFile('attachment')) {
            return back()->with('error', 'Please send a message or attach a photo');
        }

        $sender = Auth::user();
        $receiver_id = $request->receiver_id;
        $purchase_id = $request->purchase_id;
        $user_skill_id = $request->user_skill_id;

        // If purchase-based message
        if ($purchase_id) {
            $purchase = Purchase::findOrFail($purchase_id);
            $this->authorize('update', $purchase);
            $receiver_id = $sender->id === $purchase->buyer_id ? $purchase->seller_id : $purchase->buyer_id;
        }
        // If skill listing message
        elseif ($user_skill_id) {
            $userSkill = UserSkill::findOrFail($user_skill_id);
            // Receiver must be the skill lister (not the sender)
            if (!$receiver_id) {
                $receiver_id = $userSkill->user_id;
            }
            // Security check: sender can't message themselves
            if ($sender->id === $receiver_id) {
                return back()->with('error', 'You cannot message yourself');
            }
        } else {
            // Direct message with receiver_id
            if (!$receiver_id) {
                return back()->with('error', 'Invalid message recipient');
            }
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('messages', 'public');
        }

        Message::create([
            'purchase_id' => $purchase_id,
            'user_skill_id' => $user_skill_id,
            'sender_id' => $sender->id,
            'receiver_id' => $receiver_id,
            'message' => $request->message,
            'attachment' => $attachmentPath,
        ]);

        // Redirect based on context
        if ($purchase_id) {
            return redirect()->route('purchases.show', $purchase_id)->with('success', 'Message sent successfully');
        } elseif ($user_skill_id) {
            return back()->with('success', 'Message sent to the skill lister');
        }

        return back()->with('success', 'Message sent successfully');
    }
}
