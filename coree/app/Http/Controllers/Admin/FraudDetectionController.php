<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSession;
use App\Models\WithdrawalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FraudDetectionController extends Controller
{
    /**
     * Show fraud detection dashboard
     */
    public function index()
    {
        $suspiciousUsers = $this->getSuspiciousUsers();
        $duplicateAddresses = $this->getDuplicateWithdrawalAddresses();
        $multipleAccounts = $this->getMultipleAccountsFromSameDevice();
        $vpnUsers = $this->getVPNUsers();
        
        return view('admin.fraud.index', compact(
            'suspiciousUsers',
            'duplicateAddresses',
            'multipleAccounts',
            'vpnUsers'
        ));
    }

    /**
     * Get users with suspicious activity
     */
    protected function getSuspiciousUsers()
    {
        return User::select('users.*')
            ->selectRaw('COUNT(DISTINCT user_sessions.country_code) as country_changes')
            ->selectRaw('COUNT(DISTINCT user_sessions.ip_address) as ip_changes')
            ->selectRaw('COUNT(DISTINCT user_sessions.device_fingerprint) as device_changes')
            ->leftJoin('user_sessions', 'users.id', '=', 'user_sessions.user_id')
            ->groupBy('users.id')
            ->havingRaw('country_changes > 2 OR ip_changes > 5 OR device_changes > 2')
            ->orderByDesc('country_changes')
            ->limit(50)
            ->get();
    }

    /**
     * Get duplicate withdrawal addresses
     */
    protected function getDuplicateWithdrawalAddresses()
    {
        return DB::table('withdrawal_histories')
            ->select('wallet_address', DB::raw('COUNT(DISTINCT uid) as user_count'), DB::raw('GROUP_CONCAT(DISTINCT uid) as user_ids'))
            ->whereNotNull('wallet_address')
            ->where('wallet_address', '!=', '')
            ->groupBy('wallet_address')
            ->having('user_count', '>', 1)
            ->orderByDesc('user_count')
            ->limit(50)
            ->get();
    }

    /**
     * Get multiple accounts from same device
     */
    protected function getMultipleAccountsFromSameDevice()
    {
        return DB::table('user_sessions')
            ->select('device_fingerprint', DB::raw('COUNT(DISTINCT user_id) as user_count'), DB::raw('GROUP_CONCAT(DISTINCT user_id) as user_ids'))
            ->whereNotNull('device_fingerprint')
            ->where('device_fingerprint', '!=', '')
            ->groupBy('device_fingerprint')
            ->having('user_count', '>', 1)
            ->orderByDesc('user_count')
            ->limit(50)
            ->get();
    }

    /**
     * Get users who used VPN
     */
    protected function getVPNUsers()
    {
        return User::where('vpn_detected', true)
            ->orderByDesc('updated_at')
            ->limit(50)
            ->get();
    }

    /**
     * Show detailed user fraud info
     */
    public function userDetails($userId)
    {
        $user = User::findOrFail($userId);
        
        $sessions = UserSession::where('user_id', $userId)
            ->orderByDesc('last_activity_at')
            ->get();
        
        $withdrawals = WithdrawalHistory::where('uid', $user->uid)
            ->orderByDesc('created_at')
            ->get();
        
        $riskScore = $this->calculateRiskScore($user, $sessions, $withdrawals);
        
        return view('admin.fraud.user-details', compact(
            'user',
            'sessions',
            'withdrawals',
            'riskScore'
        ));
    }

    /**
     * Calculate fraud risk score for user (0-100)
     */
    protected function calculateRiskScore($user, $sessions, $withdrawals): int
    {
        $score = 0;
        
        // Multiple countries
        $countries = $sessions->pluck('country_code')->unique()->count();
        if ($countries > 2) $score += 20;
        if ($countries > 4) $score += 20;
        
        // Multiple IPs
        $ips = $sessions->pluck('ip_address')->unique()->count();
        if ($ips > 5) $score += 15;
        if ($ips > 10) $score += 15;
        
        // Multiple devices
        $devices = $sessions->pluck('device_fingerprint')->unique()->count();
        if ($devices > 2) $score += 20;
        
        // VPN detected
        if ($user->vpn_detected) $score += 25;
        
        // Duplicate withdrawal addresses
        if ($withdrawals->count() > 0) {
            $addresses = $withdrawals->pluck('wallet_address')->filter();
            if ($addresses->count() > 0) {
                $duplicateCount = DB::table('withdrawal_histories')
                    ->whereIn('wallet_address', $addresses->toArray())
                    ->where('uid', '!=', $user->uid)
                    ->distinct('uid')
                    ->count('uid');
                
                if ($duplicateCount > 0) $score += 30;
            }
        }
        
        return min($score, 100);
    }
}

