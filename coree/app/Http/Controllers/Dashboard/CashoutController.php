<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawalCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\WithdrawalSubCategory;
use App\Models\WithdrawalHistory;


class CashoutController extends Controller
{
    
    public function index()
    {
        $activeTemplate = getActiveTemplate();
        $userBalance = Auth::user()->balance;

        $withdrawals = WithdrawalCategory::with('subCategories')->get();

        $amounts = $withdrawals->flatMap->subCategories->pluck('amount')->sort();
        
        $withdrawalAmount = $amounts->first(fn($amount) => $amount >= $userBalance);

        $progressPercentage = $withdrawalAmount > 0
            ? min(($userBalance / $withdrawalAmount) * 100, 100)
            : 0;

        return view($activeTemplate . '.cashout', compact('withdrawals', 'userBalance', 'withdrawalAmount', 'progressPercentage'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'withdrawal_categories_id' => 'required|exists:withdrawal_categories,id',
            'wallet' => 'required|string',
            'amount' => 'nullable|numeric|min:0',
            'item_id' => 'nullable|exists:withdrawal_sub_categories,id',
        ]);
    
        $user = auth()->user();
        $category = WithdrawalCategory::with('subCategories')->findOrFail($validated['withdrawal_categories_id']);
    
        if ($category->subCategories->isNotEmpty()) {
            if (empty($validated['item_id'])) {
                return redirect()->back()->with('error', 'Please select a withdrawal option.');
            }
    
            $item = WithdrawalSubCategory::findOrFail($validated['item_id']);
            $amount = $item->amount;
    
        } else {
            if (empty($validated['amount'])) {
                return redirect()->back()->with('error', 'Please enter an amount.');
            }
    
            $amount = $validated['amount'];
        }
    
        if ($amount < $category->minimum) {
            return redirect()->back()->with('error', 'The minimum withdrawal amount is ' . $category->minimum . ' ' . siteSymbol());
        }
    
        if ($user->balance < $amount) {
            return redirect()->back()->with('error', 'Insufficient funds! Please ensure you have enough balance to complete this transaction.');
        }
    
        if (is_null($user->email_verified_at)) {
            return redirect()->back()->with('error', 'Your email is not verified! Please verify your email to proceed.');
        }
    
        $user->decrement('balance', $amount);
    
        WithdrawalHistory::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'withdrawal_categories_id' => $category->id,
            'redeem_wallet' => str_replace(' ', '', $validated['wallet']),
        ]);
    
        return redirect()->route('profile.show')->with('success', 'Withdrawal request submitted successfully!');
}


}
