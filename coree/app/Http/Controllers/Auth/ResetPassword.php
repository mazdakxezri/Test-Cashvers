<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\HomeService;

class ResetPassword extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function ForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->route('home')->with('openForgotModal', true)->with(['success' => 'We have emailed your password reset link!']);
        }

        return back()->withErrors(['email' => [__($status)]])->with('openForgotModal', true);
    }


    public function ResetPasswordForm(Request $request, $token)
    {
        $data = $this->getWelcomeViewData();

        $email = $request->query('email');

        return view($data['activeTemplate'] . '.welcome', [
            'faqs' => $data['faqs'],
            'paymentMethods' => $data['paymentMethods'],
            'token' => $token,
            'email' => $email,
        ]);
    }



    public function ResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('home')->with('openLoginModal', true)->with('success', 'Password has been successfully reset!')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
