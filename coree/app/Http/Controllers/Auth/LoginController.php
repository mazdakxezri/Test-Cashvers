<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function signin(Request $request)
    {
        $ip = $request->ip();
        $key = 'login-attempts:' . $ip;

        // Too many login attempts check
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return redirect()->back()
                ->withErrors(['error' => "Too many login attempts. Please try again in {$seconds} seconds."])
                ->with('openLoginModal', true);
        }

        $recaptchaRule = isCaptchaEnabled() ? 'required|captcha' : 'nullable';

        // Validate form input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
            'g-recaptcha-response' => $recaptchaRule,
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('openLoginModal', true);
        }

        $validated = $validator->validated();

        // Use validated data for credentials
        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        // Attempt login
        if (!Auth::attempt($credentials)) {
            RateLimiter::hit($key);
            return redirect()->back()
                ->withErrors(['error' => 'These credentials do not match our records.'])
                ->with('openLoginModal', true);
        }

        $user = Auth::user();

        // Check if user exists and is active
        if (!$user || ($user->status ?? '') !== 'active') {
            Auth::logout();
            return redirect()->back()
                ->withErrors(['error' => 'Your account is banned due to a violation.'])
                ->with('openLoginModal', true);
        }

        // Update last login IP and regenerate session
        $user->update(['last_login_ip' => $ip]);
        $request->session()->regenerate();

        // Clear login attempts
        RateLimiter::clear($key);

        return redirect()->intended(route('earnings.index'));
    }
}
