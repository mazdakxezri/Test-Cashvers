<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\Network;
use App\Models\WithdrawalHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{
    public function index()
    {
        $activeTemplate = getActiveTemplate();
        $user = Auth::user();

        $networks = Network::select('network_name', 'network_type')->get()->groupBy('network_type');

        $offerNetworkNamesArray = $this->prepareNetworkNames($networks['offer'] ?? collect());
        $surveyNetworkNamesArray = $this->prepareNetworkNames($networks['survey'] ?? collect());

        $offerNetworkNamesStr = !empty($offerNetworkNamesArray) ? '"' . implode('","', $offerNetworkNamesArray) . '"' : 'NULL';
        $surveyNetworkNamesStr = !empty($surveyNetworkNamesArray) ? '"' . implode('","', $surveyNetworkNamesArray) . '"' : 'NULL';

        $trackStats = Track::selectRaw("
        COUNT(CASE WHEN partners IN ($offerNetworkNamesStr) THEN 1 END) AS offers_completed,
        COUNT(CASE WHEN partners IN ($surveyNetworkNamesStr) THEN 1 END) AS survey_completed,
        SUM(CASE WHEN partners IN ($offerNetworkNamesStr) THEN reward ELSE 0 END) AS offers_earning,
        SUM(CASE WHEN partners IN ($surveyNetworkNamesStr) THEN reward ELSE 0 END) AS survey_earning
    ")
            ->where('uid', $user->uid)
            ->first();

        // Get user's cashouts
        $cashouts = WithdrawalHistory::where('user_id', $user->id)->get();

        // Get offers and surveys details
        $tracks = Track::where('uid', $user->uid)
            ->whereIn('partners', array_merge($offerNetworkNamesArray, $surveyNetworkNamesArray))
            ->select('offer_name', 'reward', 'transaction_id', 'created_at', 'status', 'partners')
            ->get();

        // Separate offers and surveys based on partners
        $offers = $tracks->filter(function ($track) use ($offerNetworkNamesArray) {
            return in_array($track->partners, $offerNetworkNamesArray);
        });

        $surveys = $tracks->filter(function ($track) use ($surveyNetworkNamesArray) {
            return in_array($track->partners, $surveyNetworkNamesArray);
        });

        return view($activeTemplate . '.profile', [
            'offers_completed' => $trackStats->offers_completed ?? 0,
            'offers_earning' => $trackStats->offers_earning ?? 0,
            'survey_completed' => $trackStats->survey_completed ?? 0,
            'survey_earning' => $trackStats->survey_earning ?? 0,
            'cashouts' => $cashouts,
            'offers' => $offers,
            'surveys' => $surveys,
        ]);
    }

    private function prepareNetworkNames($networkNames): array
    {
        return $networkNames->isNotEmpty() ? $networkNames->pluck('network_name')->toArray() : [];
    }

    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'newpassword' => 'nullable|min:8',
            'name' => 'required|string|max:255',
            'oldpassword' => 'nullable|min:8',
            'gender' => 'required|string|in:male,female',
        ]);

        $user = auth()->user();

        // If old password is provided, ensure it matches
        if ($request->filled('oldpassword') && !Hash::check($request->oldpassword, $user->password)) {
            return back()->withErrors(['error' => 'Old password does not match.']);
        }

        $user->fill([
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
        ]);

        // Update password if provided
        if ($request->filled('newpassword')) {
            $user->password = Hash::make($request->newpassword);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }



}
