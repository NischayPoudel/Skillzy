<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PendingRegistration;
use Illuminate\Http\RedirectResponse;

class RegistrationVerificationController extends Controller
{
    /**
     * Verify registration and move to users table
     */
    public function verify(string $token): RedirectResponse
    {
        $pending = PendingRegistration::where('verification_token', $token)->first();

        if (!$pending) {
            return redirect(route('register'))->with('error', 'Invalid verification link.');
        }

        if ($pending->isTokenExpired()) {
            $pending->delete();
            return redirect(route('register'))->with('error', 'Verification link has expired. Please register again.');
        }

        // Create the user now that email is verified
        $username = strtolower(str_replace(' ', '', $pending->name));
        
        $user = User::create([
            'name' => $pending->name,
            'username' => $username,
            'email' => $pending->email,
            'password' => $pending->password,
            'phone_number' => $pending->phone_number,
            'transaction_pin' => $pending->transaction_pin,
            'email_verified_at' => now(),
            'isverified' => true,
        ]);

        // Delete pending registration
        $pending->delete();

        return redirect(route('login'))->with('status', 'Email verified successfully! You can now log in with your credentials.');
    }
}
