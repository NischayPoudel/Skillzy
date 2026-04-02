<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['buyer', 'userSkill.skill'])->latest()->paginate(10);
        return view('admin.purchases.index', compact('purchases'));
    }
}
