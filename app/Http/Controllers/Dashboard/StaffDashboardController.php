<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Skill;
use App\Models\Purchase;
use Illuminate\View\View;

class StaffDashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalSkills = Skill::count();
        $totalPurchases = Purchase::count();
        
        return view('staff.dashboard', [
            'totalUsers' => $totalUsers,
            'totalSkills' => $totalSkills,
            'totalPurchases' => $totalPurchases,
        ]);
    }
}
