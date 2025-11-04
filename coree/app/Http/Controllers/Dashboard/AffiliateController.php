<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReferralLog;
use App\Models\User;


class AffiliateController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $referralLogs = ReferralLog::with('referredUser:id,name')
            ->where('referrer_id', $user->id)
            ->get()
            ->groupBy('user_id')
            ->map(function ($logs) {
                return [
                    'user' => $logs->first()->referredUser->name,
                    'earnings' => $logs->sum('earnings'),
                    'created_at' => $logs->first()->created_at
                ];
            });

        $ref_earning = $referralLogs->sum('earnings');
        $total_user_referred = User::where('invited_by', $user->id)->count();

        $activeTemplate = getActiveTemplate();
        $referral_code = $user->referral_code;

        return view($activeTemplate . '.affiliates-space', compact('referral_code', 'ref_earning', 'referralLogs', 'total_user_referred'));
    }





}
