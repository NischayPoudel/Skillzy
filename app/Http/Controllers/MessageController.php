<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStoreRequest;
use App\Models\Message;
use App\Models\Purchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(MessageStoreRequest $request): RedirectResponse
    {
        $purchase = Purchase::findOrFail($request->purchase_id);
        
        $this->authorize('update', $purchase);
        
        $receiver_id = Auth::user()->id === $purchase->buyer_id ? $purchase->seller_id : $purchase->buyer_id;
        
        Message::create([
            'purchase_id' => $purchase->id,
            'sender_id' => Auth::user()->id,
            'receiver_id' => $receiver_id,
            'message' => $request->message,
        ]);
        
        return redirect()->route('purchases.show', $purchase);
    }
}
