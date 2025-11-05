<?php

namespace App\Services;

use App\Models\LootBoxType;
use App\Models\LootBoxItem;
use App\Models\LootBoxPurchase;
use App\Models\UserLootBoxReward;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LootBoxService
{
    /**
     * Purchase a loot box with earnings
     *
     * @param User $user
     * @param int $lootBoxTypeId
     * @return array
     */
    public function purchaseWithEarnings(User $user, $lootBoxTypeId): array
    {
        $lootBoxType = LootBoxType::findOrFail($lootBoxTypeId);

        if (!$lootBoxType->can_buy_with_earnings) {
            return ['success' => false, 'message' => 'This loot box cannot be purchased with earnings'];
        }

        if ($user->balance < $lootBoxType->price_usd) {
            return ['success' => false, 'message' => 'Insufficient balance'];
        }

        return DB::transaction(function () use ($user, $lootBoxType) {
            // Deduct balance
            $user->decrement('balance', $lootBoxType->price_usd);

            // Create purchase record
            $purchase = LootBoxPurchase::create([
                'user_id' => $user->id,
                'loot_box_type_id' => $lootBoxType->id,
                'payment_method' => 'earnings',
                'price_paid' => $lootBoxType->price_usd,
            ]);

            return [
                'success' => true,
                'purchase_id' => $purchase->id,
                'message' => 'Loot box purchased! Open it to reveal your reward.',
            ];
        });
    }

    /**
     * Open a loot box and determine reward using weighted algorithm
     *
     * @param int $purchaseId
     * @param User $user
     * @return array
     */
    public function openLootBox($purchaseId, User $user): array
    {
        $purchase = LootBoxPurchase::where('id', $purchaseId)
            ->where('user_id', $user->id)
            ->where('opened', false)
            ->firstOrFail();

        return DB::transaction(function () use ($purchase, $user) {
            // Get all possible items for this loot box type
            $items = LootBoxItem::where('loot_box_type_id', $purchase->loot_box_type_id)
                ->where('is_active', true)
                ->get();

            if ($items->isEmpty()) {
                return ['success' => false, 'message' => 'No items available in this loot box'];
            }

            // Use weighted random selection (platform-favored algorithm)
            $selectedItem = $this->selectItemWithWeightedProbability($items);

            // Mark purchase as opened
            $purchase->update([
                'opened' => true,
                'opened_at' => now(),
            ]);

            // Determine actual value (add variance to make it more "house-favored")
            $actualValue = $this->calculateActualValue($selectedItem, $purchase->price_paid);

            // Create reward record
            $reward = UserLootBoxReward::create([
                'user_id' => $user->id,
                'loot_box_purchase_id' => $purchase->id,
                'loot_box_item_id' => $selectedItem->id,
                'value_received' => $actualValue,
                'claimed' => false,
            ]);

            return [
                'success' => true,
                'reward' => $reward,
                'item' => $selectedItem,
                'value' => $actualValue,
                'rarity' => $selectedItem->rarity,
            ];
        });
    }

    /**
     * Select item using weighted probability (favors lower rewards)
     *
     * @param Collection $items
     * @return LootBoxItem
     */
    protected function selectItemWithWeightedProbability($items)
    {
        // Calculate total weight (sum of all drop rates)
        $totalWeight = $items->sum('drop_rate');

        // Generate random number between 0 and total weight
        $random = mt_rand(0, $totalWeight * 100) / 100;

        // Select item based on cumulative probability
        $cumulativeWeight = 0;
        foreach ($items as $item) {
            $cumulativeWeight += $item->drop_rate;
            if ($random <= $cumulativeWeight) {
                return $item;
            }
        }

        // Fallback to first item (should never happen)
        return $items->first();
    }

    /**
     * Calculate actual value (with house edge)
     *
     * @param LootBoxItem $item
     * @param float $boxPrice
     * @return float
     */
    protected function calculateActualValue($item, $boxPrice): float
    {
        $baseValue = $item->value ?? 0;

        // Add variance based on rarity (±10-30%)
        $variance = match ($item->rarity) {
            'common' => [-20, 10],      // -20% to +10%
            'uncommon' => [-15, 15],    // -15% to +15%
            'rare' => [-10, 25],        // -10% to +25%
            'epic' => [0, 40],          // 0% to +40%
            'legendary' => [10, 100],   // +10% to +100%
            default => [-20, 10],
        };

        $randomVariance = mt_rand($variance[0], $variance[1]) / 100;
        $actualValue = $baseValue * (1 + $randomVariance);

        // Ensure house edge: max 85% of box price for common/uncommon
        if (in_array($item->rarity, ['common', 'uncommon'])) {
            $actualValue = min($actualValue, $boxPrice * 0.85);
        }

        // Ensure minimum value (never give nothing)
        $actualValue = max($actualValue, $boxPrice * 0.10);

        return round($actualValue, 2);
    }

    /**
     * Claim reward (add to user balance)
     *
     * @param int $rewardId
     * @param User $user
     * @return bool
     */
    public function claimReward($rewardId, User $user): bool
    {
        $reward = UserLootBoxReward::where('id', $rewardId)
            ->where('user_id', $user->id)
            ->where('claimed', false)
            ->first();

        if (!$reward) {
            return false;
        }

        DB::transaction(function () use ($reward, $user) {
            // Add to user balance
            $user->increment('balance', $reward->value_received);

            // Mark as claimed
            $reward->update([
                'claimed' => true,
                'claimed_at' => now(),
            ]);
        });

        return true;
    }

    /**
     * Get user's unopened loot boxes
     *
     * @param User $user
     * @return Collection
     */
    public function getUnopenedBoxes(User $user)
    {
        return LootBoxPurchase::where('user_id', $user->id)
            ->where('opened', false)
            ->with('lootBoxType')
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Get user's unclaimed rewards
     *
     * @param User $user
     * @return Collection
     */
    public function getUnclaimedRewards(User $user)
    {
        return UserLootBoxReward::where('user_id', $user->id)
            ->where('claimed', false)
            ->with(['item', 'purchase.lootBoxType'])
            ->orderByDesc('created_at')
            ->get();
    }
}

