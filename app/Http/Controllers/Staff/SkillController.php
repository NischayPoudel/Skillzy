<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    /**
     * Display a listing of skills (staff view only)
     */
    public function index()
    {
        $skills = Skill::latest()->paginate(10);
        return view('staff.skills.index', compact('skills'));
    }

    /**
     * Show the form for creating a new skill
     */
    public function create()
    {
        return view('staff.skills.create');
    }

    /**
     * Store a newly created skill in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills',
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('skills', $filename, 'public');
            $data['icon'] = 'skills/' . $filename;
        }

        Skill::create($data);

        return redirect()->route('staff.skills.index')->with('success', 'Skill created successfully.');
    }

    /**
     * Show the form for editing the specified skill
     */
    public function edit(Skill $skill)
    {
        return view('staff.skills.edit', compact('skill'));
    }

    /**
     * Update the specified skill in storage
     */
    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name,' . $skill->id,
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('icon')) {
            // Delete old image if exists
            if ($skill->icon && Storage::disk('public')->exists($skill->icon)) {
                Storage::disk('public')->delete($skill->icon);
            }

            $file = $request->file('icon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('skills', $filename, 'public');
            $data['icon'] = 'skills/' . $filename;
        }

        $skill->update($data);

        return redirect()->route('staff.skills.index')->with('success', 'Skill updated successfully.');
    }

    /**
     * Remove the specified skill from storage
     */
    public function destroy(Skill $skill)
    {
        if ($skill->icon && Storage::disk('public')->exists($skill->icon)) {
            Storage::disk('public')->delete($skill->icon);
        }
        
        $skill->delete();
        return redirect()->route('staff.skills.index')->with('success', 'Skill deleted successfully.');
    }
}
