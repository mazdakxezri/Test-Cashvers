<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaderboardSettings;
use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboardSettings = LeaderboardSettings::first();

        return view('admin.leaderboard', compact('leaderboardSettings'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateRequest($request);
        $topRanksPrizes = $this->processTopRanksPrizes($request->top_ranks_prizes);

        $this->validateTopRanksPrizes($validatedData['total_prize'], $topRanksPrizes);
        $this->validateUserCount($validatedData['number_of_users']);

        $this->saveLeaderboardSettings($validatedData, $topRanksPrizes);

        return redirect()->route('admin.leaderboard.index')->with('success', 'Leaderboard settings saved successfully.');
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'total_prize' => 'required|numeric|min:0',
            'number_of_users' => 'required|integer|min:1|max:100',
            'distribution_method' => 'required|in:linear,exponential',
            'status' => 'required|boolean',
            'duration' => 'required|in:daily,weekly,monthly',
            'top_ranks_prizes' => 'required|string',
        ]);
    }

    private function processTopRanksPrizes(string $topRanksPrizesInput): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $topRanksPrizesInput))));
    }

    private function validateTopRanksPrizes(float $totalPrize, array $topRanksPrizes): void
    {
        $totalTopRanksPrizes = array_sum($topRanksPrizes);
        if ($totalTopRanksPrizes > $totalPrize) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'top_ranks_prizes' => 'Total of top ranks prizes must be less than or equal to the total prize.',
            ]);
        }
    }

    private function validateUserCount(int $numberOfUsers): void
    {
        $totalUsers = User::where('status', 'active')->count();
        if ($numberOfUsers > $totalUsers) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'number_of_users' => 'Number of users cannot exceed total users on the website.',
            ]);
        }
    }

    private function saveLeaderboardSettings(array $validatedData, array $topRanksPrizes): void
    {
        LeaderboardSettings::updateOrCreate(
            [],
            [
                'total_prize' => $validatedData['total_prize'],
                'number_of_users' => $validatedData['number_of_users'],
                'distribution_method' => $validatedData['distribution_method'],
                'status' => $validatedData['status'],
                'duration' => $validatedData['duration'],
                'top_ranks_prizes' => json_encode($topRanksPrizes),
            ]
        );
    }
}
