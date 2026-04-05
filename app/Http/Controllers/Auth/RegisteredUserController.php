<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'transaction_pin' => ['required', 'string', 'size:4', 'regex:/^[0-9]+$/'],
        ]);

        // Generate username from name
        $username = strtolower(str_replace(' ', '', $request->name));
        
        // Check if username already exists
        if (User::where('username', $username)->exists()) {
            return redirect()->back()->withErrors(['name' => 'This username already exists. Please choose a different name.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'transaction_pin' => Hash::make($request->transaction_pin),
        ]);

        event(new Registered($user));

        return redirect(route('login', absolute: false))->with('status', 'Registration successful! Please log in with your credentials.');
    }
}
