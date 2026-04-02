<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillStoreRequest;
use App\Http\Requests\SkillUpdateRequest;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,staff')->except(['index', 'show']);
    }

    public function index(): View
    {
        $skills = Skill::with('creator')->paginate(15);
        return view('skills.index', ['skills' => $skills]);
    }

    public function create(): View
    {
        return view('skills.create');
    }

    public function store(SkillStoreRequest $request): RedirectResponse
    {
        Skill::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('skills.index')->with('success', 'Skill created successfully.');
    }

    public function show(Skill $skill): View
    {
        return view('skills.show', ['skill' => $skill->load('creator')]);
    }

    public function edit(Skill $skill): View
    {
        return view('skills.edit', ['skill' => $skill]);
    }

    public function update(SkillUpdateRequest $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validated());
        return redirect()->route('skills.index')->with('success', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();
        return redirect()->route('skills.index')->with('success', 'Skill deleted successfully.');
    }
}
