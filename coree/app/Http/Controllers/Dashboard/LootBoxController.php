<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\LootBoxService;
use App\Models\LootBoxType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LootBoxController extends Controller
{
    protected $lootBoxService;

    public function __construct(LootBoxService $lootBoxService)
    {
        $this->lootBoxService = $lootBoxService;
    }

    /**
     * Show loot boxes page
     */
    public function index()
    {
        $lootBoxTypes = LootBoxType::where('is_active', true)
            ->orderBy('order')
            ->get();

        $unopenedBoxes = $this->lootBoxService->getUnopenedBoxes(Auth::user());
        $unclaimedRewards = $this->lootBoxService->getUnclaimedRewards(Auth::user());

        return view('templates.garnet.lootbox.index', compact(
            'lootBoxTypes',
            'unopenedBoxes',
            'unclaimedRewards'
        ));
    }

    /**
     * Purchase loot box
     */
    public function purchase(Request $request)
    {
        $request->validate([
            'loot_box_type_id' => 'required|exists:loot_box_types,id',
            'payment_method' => 'required|in:earnings,crypto',
        ]);

        $result = $this->lootBoxService->purchaseWithEarnings(
            Auth::user(),
            $request->loot_box_type_id
        );

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    /**
     * Open loot box
     */
    public function open(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:loot_box_purchases,id',
        ]);

        try {
            $result = $this->lootBoxService->openLootBox(
                $request->purchase_id,
                Auth::user()
            );

            if ($result['success']) {
                return response()->json($result);
            }

            return response()->json($result, 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to open loot box: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Claim reward
     */
    public function claimReward(Request $request)
    {
        $request->validate([
            'reward_id' => 'required|exists:user_loot_box_rewards,id',
        ]);

        $success = $this->lootBoxService->claimReward(
            $request->reward_id,
            Auth::user()
        );

        if ($success) {
            return back()->with('success', 'Reward claimed successfully!');
        }

        return back()->with('error', 'Failed to claim reward');
    }
}

