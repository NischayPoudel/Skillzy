<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Skill;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalUsers = User::count();
        $totalSkills = Skill::count();
        $totalListings = \App\Models\UserSkill::count();
        $totalPurchases = Purchase::count();
        $totalRevenue = Purchase::where('status', 'completed')->sum('amount');
        
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalSkills' => $totalSkills,
            'totalListings' => $totalListings,
            'totalPurchases' => $totalPurchases,
            'totalRevenue' => $totalRevenue,
        ]);
    }
}
