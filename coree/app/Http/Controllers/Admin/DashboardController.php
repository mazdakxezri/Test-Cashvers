<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\User;
use App\Models\Offer;
use App\Models\WithdrawalHistory;
use Illuminate\Support\Facades\Artisan;


class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;

        $leads = Track::select('uid', 'partners', 'reward', 'created_at')
            ->where('reward', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();


        $totalUsers = User::count();

        $totalEarnings = number_format(
            Track::whereMonth('created_at', $currentMonth)
                ->sum('payout'),
            2
        );

        $totalWithdrawn = number_format(
            WithdrawalHistory::where('status', 'completed')
                ->whereMonth('created_at', $currentMonth)
                ->sum('amount'),
            2
        );

        $totalOffers = Offer::count();

        $userCounts = User::select('country_code')
            ->groupBy('country_code')
            ->selectRaw('count(*) as count, country_code')
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->country_code => $user->count];
            });

        return view('admin.dashboard', compact('leads', 'totalUsers', 'totalEarnings', 'totalWithdrawn', 'userCounts', 'totalOffers'));
    }

    public function globaleSearch(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $search = $request->input('search');

        $query = User::query();

        $query->where(function ($q) use ($search) {
            $q->where('email', $search)
                ->orWhere('uid', $search);
        });

        $user = $query->first();

        if ($user) {
            return redirect()->route('admin.members.info', ['uid' => $user->uid]);
        } else {
            return redirect()->back();
        }
    }

    public function clearCache(Request $request)
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        return redirect()->back()->with('success', 'Cache cleared successfully.');
    }




}
