<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewStoreRequest;
use App\Models\Purchase;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ReviewStoreRequest $request): RedirectResponse
    {
        $purchase = Purchase::findOrFail($request->purchase_id);
        
        if (Auth::id() !== $purchase->buyer_id || $purchase->status !== 'completed' || $purchase->review) {
            abort(403, 'Cannot review this purchase');
        }
        
        Review::create([
            'purchase_id' => $purchase->id,
            'buyer_id' => $purchase->buyer_id,
            'seller_id' => $purchase->seller_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        
        return redirect()->route('purchases.show', $purchase)->with('success', 'Review posted successfully!');
    }
}
