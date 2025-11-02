<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Services\EmailDomainChecker;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;


class RegisterController extends Controller
{
    protected $emailDomainChecker;

    public function __construct(EmailDomainChecker $emailDomainChecker)
    {
        $this->emailDomainChecker = $emailDomainChecker;
    }

    //Default Registrations
    public function store(Request $request)
    {
        if (!isRegistrationEnabled()) {
            return back()
                ->withErrors(['error' => 'Registration is closed. Please try again later.'])
                ->with('openRegisterModal', true);
        }

        try {
            $validatedData = $this->validateRegistration($request);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('openRegisterModal', true);
        }

        if ($this->isOneDeviceRegistrationEnabled() && $this->isDeviceAlreadyRegistered($request)) {
            return back()
                ->withErrors(['error' => 'A user has already registered from this device.'])
                ->with('openRegisterModal', true);
        }

        $user = $this->createUser($request, $validatedData);

        return $this->handlePostRegistration($user);
    }

    private function validateRegistration(Request $request)
    {
        $recaptchaRule = isCaptchaEnabled() ? 'required|captcha' : 'nullable';

        return $request->validate([
            'name' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'email' => [
                'required',
                'email',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    if (Setting::getValue('temporary_email_ban_enabled') == 0) {
                        if (!$this->emailDomainChecker->isAllowedDomain($value)) {
                            $fail('The ' . $attribute . ' domain is not allowed.');
                        }
                    }
                },
            ],
            'password' => 'required|string|min:8',
            'g-recaptcha-response' => $recaptchaRule,
        ]);
    }

    private function isOneDeviceRegistrationEnabled()
    {
        return (int) Setting::getValue('one_device_registration_only') == 1;
    }

    private function isDeviceAlreadyRegistered(Request $request)
    {
        return User::where('ip', $request->ip())
            ->where('user_agent', $request->header('User-Agent'))
            ->exists();
    }

    private function createUser(Request $request, array $validatedData)
    {
        $referralCode = $request->cookie('referral_code');
        $invitedById = User::where('referral_code', $referralCode)->value('id');
        $signupBonus = $this->getSignupBonus();

        return User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'balance' => $signupBonus,
            'country_code' => getCountryCode($request->ip()),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'invited_by' => $invitedById,
        ]);
    }

    private function handlePostRegistration(User $user)
    {
        $emailVerificationSetting = Setting::getValue('email_verification_enabled');

        if ($emailVerificationSetting != 0) {
            event(new Registered($user));
        } else {
            $user->email_verified_at = now();
            $user->save();
        }

        Auth::login($user);
        return redirect()->route('earnings.index');
    }

    private function getSignupBonus()
    {
        return Setting::getValue('signup_bonus');
    }

    //Google Registrations
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();

    }

    public function handleGoogleCallback(Request $request)
    {
        if ($request->has('error')) {
            return redirect('/')->with('error', 'Google sign-in was cancelled.');
        }
        $user = Socialite::driver('google')->stateless()->user();
        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            Auth::login($existingUser);
            return redirect()->route('earnings.index');
        } else {
            $referral_code = request()->cookie('referral_code');
            $invited_by_id = User::where('referral_code', $referral_code)->value('id');
            $signupBonus = $this->getSignupBonus();

            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => Hash::make(Str::random(24)),
                'email_verified_at' => now(),
                'country_code' => getCountryCode($request->ip()),
                'ip' => $request->ip(),
                'balance' => $signupBonus,
                'avatar' => $user->avatar,
                'user_agent' => request()->header('User-Agent'),
                'invited_by' => $invited_by_id,
            ]);

            Auth::login($newUser);
            return redirect()->route('earnings.index');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
