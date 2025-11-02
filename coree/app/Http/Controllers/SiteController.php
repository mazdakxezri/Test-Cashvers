<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\TermsOfServiceManagements;
use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {
        $data = $this->getWelcomeViewData();
        return view($data['activeTemplate'] . '.welcome', [
            'faqs' => $data['faqs'],
            'paymentMethods' => $data['paymentMethods'],
        ]);
    }


    public function referralCode(Request $request, $referral_code)
    {
        Cookie::queue('referral_code', $referral_code, 1440); // Cookie expires in 1 day (1440 minutes)
        return redirect()->route('home');
    }


    public function privacy()
    {
        $privacy = TermsOfServiceManagements::select('privacy_policy', 'privacy_policy_updated_at')->first();
        $this->formatUpdatedDate($privacy, 'privacy_policy_updated_at');

        $activeTemplate = getActiveTemplate();
        return view($activeTemplate . '.tos.privacy', compact('privacy'));
    }

    public function terms()
    {
        $terms = TermsOfServiceManagements::select('terms_of_use', 'terms_of_use_updated_at')->first();
        $this->formatUpdatedDate($terms, 'terms_of_use_updated_at');

        $activeTemplate = getActiveTemplate();
        return view($activeTemplate . '.tos.terms', compact('terms'));
    }

    private function formatUpdatedDate($model, $dateField)
    {
        if ($model->$dateField) {
            $model->formatted_updated_at = Carbon::parse($model->$dateField)->format('F j, Y');
        } else {
            $model->formatted_updated_at = null;
        }
    }

    public function submitForm(Request $request)
    {
        $recaptchaRule = isCaptchaEnabled() ? 'required|captcha' : 'nullable';
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'g-recaptcha-response' => $recaptchaRule,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('openContactModal', true);
        }

        $support_email = Setting::getValue('support_email');

        Mail::raw($request->message, function ($mail) use ($request, $support_email) {
            $mail->to($support_email)
                ->subject($request->subject)
                ->replyTo($request->email);
        });

        return redirect()->back()
            ->with('success', 'Your message has been sent successfully!')
            ->with('openContactModal', true);
    }

}
