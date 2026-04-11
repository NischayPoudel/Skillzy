<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PendingRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users'), Rule::unique('pending_registrations')],
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

        // Create pending registration (user not saved yet)
        $verificationToken = Str::random(60);
        
        $pendingRegistration = PendingRegistration::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'transaction_pin' => Hash::make($request->transaction_pin),
            'verification_token' => $verificationToken,
            'token_expires_at' => now()->addHours(24),
        ]);

        // Send verification email
        $verificationUrl = route('registration.verify', ['token' => $verificationToken], absolute: true);
        
        Mail::send('auth.emails.verify-registration', [
            'name' => $pendingRegistration->name,
            'verificationUrl' => $verificationUrl,
        ], function ($message) use ($pendingRegistration) {
            $message->to($pendingRegistration->email)
                    ->subject('Verify Your Email Address - Skillzy Registration');
        });

        return redirect(route('login', absolute: false))->with('status', 'Registration successful! Please check your email to verify your account. You have 24 hours to verify.');
    }
}
