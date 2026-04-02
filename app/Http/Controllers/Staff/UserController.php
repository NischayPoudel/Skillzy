<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of regular users (staff cannot see other staff/admins)
     */
    public function index()
    {
        $users = User::where('role', 'user')->latest()->paginate(10);
        return view('staff.users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        // Ensure staff can only edit regular users
        if ($user->role !== 'user') {
            abort(403, 'You can only manage regular users.');
        }
        
        return view('staff.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage
     */
    public function update(Request $request, User $user)
    {
        // Ensure staff can only edit regular users
        if ($user->role !== 'user') {
            abort(403, 'You can only manage regular users.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only('name', 'email');

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('users', 'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);

        return redirect()->route('staff.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage
     */
    public function destroy(User $user)
    {
        // Ensure staff can only delete regular users
        if ($user->role !== 'user') {
            abort(403, 'You can only manage regular users.');
        }

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }
        
        $user->delete();
        return redirect()->route('staff.users.index')->with('success', 'User deleted successfully.');
    }
}
