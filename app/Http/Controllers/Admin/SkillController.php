<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::latest()->paginate(10);
        return view('admin.skills.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.skills.create');
    }

    /**
     * Store a newly created resource in storage.
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

        // Set the creator
        $data['created_by'] = auth()->id();

        Skill::create($data);

        return redirect()->route('admin.skills.index')->with('success', 'Skill created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        return view('admin.skills.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
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

        // Preserve the original creator
        unset($data['created_by']);

        $skill->update($data);

        return redirect()->route('admin.skills.index')->with('success', 'Skill updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted successfully.');
    }
}
