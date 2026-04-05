<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingStoreRequest;
use App\Http\Requests\ListingUpdateRequest;
use App\Models\Skill;
use App\Models\UserSkill;
use App\Models\Purchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class ListingController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index(Request $request): View
    {
        $query = UserSkill::with('user', 'skill');

        // If accessing via user.listings.index, show only current user's listings
        if ($request->route('user.listings.index') === null && request()->route() && str_contains(request()->route()->getName(), 'user.listings')) {
            $query->where('user_id', Auth::id());
        } else {
            // Show only active listings for public browse
            $query->where('status', 'active');
        }

        if ($request->has('search')) {
            $query->whereHas('skill', function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            });
        }

        if ($request->has('level')) {
            $query->where('experience_level', request('level'));
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        $sort = $request->get('sort', 'latest');
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $listings = $query->paginate(12);
        $skills = Skill::orderBy('name')->get();

        return view('listings.index', [
            'listings' => $listings,
            'skills' => $skills,
        ]);
    }

    public function create(): View
    {
        $skills = Skill::orderBy('name')->get();
        return view('listings.create', ['skills' => $skills]);
    }

    public function store(ListingStoreRequest $request): RedirectResponse
    {
        UserSkill::create([
            'user_id' => Auth::id(),
            'skill_id' => $request->skill_id,
            'price' => $request->price,
            'experience_level' => $request->experience_level,
            'status' => 'active',
        ]);

        return redirect()->route('user.listings.index')->with('success', 'Listing created successfully.');
    }

    public function show(UserSkill $listing): View
    {
        $reviews = $listing->purchases()
            ->where('status', 'completed')
            ->with('review')
            ->get()
            ->mapWithKeys(fn($p) => $p->review ? [$p->id => $p->review] : []);

        return view('listings.show', [
            'listing' => $listing->load('user', 'skill'),
            'reviews' => $reviews,
        ]);
    }

    public function edit(UserSkill $listing): View
    {
        $this->authorize('update', $listing);
        $skills = Skill::orderBy('name')->get();
        return view('listings.edit', [
            'listing' => $listing,
            'skills' => $skills,
        ]);
    }

    public function update(ListingUpdateRequest $request, UserSkill $listing): RedirectResponse
    {
        $this->authorize('update', $listing);
        $listing->update($request->validated());
        return redirect()->route('user.listings.index')->with('success', 'Listing updated successfully.');
    }

    public function destroy(UserSkill $listing): RedirectResponse
    {
        $this->authorize('delete', $listing);
        $listing->delete();
        return redirect()->route('user.listings.index')->with('success', 'Listing deleted successfully.');
    }

    public function search(Request $request): RedirectResponse
    {
        $query = $request->input('q', '');
        
        if (empty($query)) {
            return redirect()->route('listings.index');
        }

        return redirect()->route('listings.index', ['search' => $query]);
    }

    public function management(): View
    {
        // Get all user skills for the current seller
        $userSkills = UserSkill::where('user_id', Auth::id())->pluck('id');

        // Get purchases for this seller's skills
        $allPurchases = Purchase::whereIn('user_skill_id', $userSkills)
            ->with('buyer', 'seller', 'userSkill.skill')
            ->get();

        // Separate by status
        $pendingRequests = $allPurchases->where('status', 'pending')->sortByDesc('created_at');
        $acceptedRequests = $allPurchases->where('status', 'accepted')->sortByDesc('updated_at');
        $completedRequests = $allPurchases->where('status', 'completed')->sortByDesc('updated_at');

        return view('user.listings-management', [
            'pendingRequests' => $pendingRequests,
            'acceptedRequests' => $acceptedRequests,
            'completedRequests' => $completedRequests,
        ]);
    }
}
