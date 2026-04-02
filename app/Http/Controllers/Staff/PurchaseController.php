<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    /**
     * Display a listing of all purchases
     */
    public function index()
    {
        $purchases = Purchase::with(['buyer', 'userSkill.user', 'userSkill.skill'])->latest()->paginate(10);
        return view('staff.purchases.index', compact('purchases'));
    }
}
