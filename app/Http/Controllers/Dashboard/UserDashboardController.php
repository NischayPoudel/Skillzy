<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\UserSkill;
use App\Models\Review;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function __invoke(): View|Response|RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        $totalListings = UserSkill::where('user_id', $user->id)->count();
        $totalPurchases = Purchase::where('buyer_id', $user->id)
            ->orWhere('seller_id', $user->id)
            ->count();
        $totalEarnings = Purchase::where('seller_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');
        
        // Get top 6 rated skills with their average ratings
        $topRatedSkills = UserSkill::with('user', 'skill')
            ->where('user_skills.status', 'active')
            ->leftJoin('purchases', 'user_skills.id', '=', 'purchases.user_skill_id')
            ->leftJoin('reviews', 'purchases.id', '=', 'reviews.purchase_id')
            ->select(
                'user_skills.id',
                'user_skills.user_id',
                'user_skills.skill_id',
                'user_skills.price',
                'user_skills.experience_level',
                'user_skills.status',
                'user_skills.created_at',
                'user_skills.updated_at',
                DB::raw('AVG(CAST(reviews.rating as UNSIGNED)) as avg_rating')
            )
            ->groupBy('user_skills.id', 'user_skills.user_id', 'user_skills.skill_id', 'user_skills.price', 'user_skills.experience_level', 'user_skills.status', 'user_skills.created_at', 'user_skills.updated_at')
            ->orderByDesc('avg_rating')
            ->limit(6)
            ->get();
        
        return view('user.dashboard', [
            'totalListings' => $totalListings,
            'totalPurchases' => $totalPurchases,
            'totalEarnings' => $totalEarnings,
            'coins' => $user->coins,
            'topRatedSkills' => $topRatedSkills,
        ]);
    }
}
