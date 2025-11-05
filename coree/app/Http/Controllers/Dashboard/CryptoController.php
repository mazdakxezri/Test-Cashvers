<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\NOWPaymentsService;
use App\Models\CryptoTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CryptoController extends Controller
{
    protected $nowPayments;

    public function __construct(NOWPaymentsService $nowPayments)
    {
        $this->nowPayments = $nowPayments;
    }

    /**
     * Show crypto deposit page
     */
    public function depositIndex()
    {
        $currencies = ['BTC', 'ETH', 'USDT', 'LTC', 'BCH', 'TRX'];
        $transactions = CryptoTransaction::where('user_id', Auth::id())
            ->deposits()
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('templates.garnet.crypto.deposit', compact('currencies', 'transactions'));
    }

    /**
     * Create crypto deposit
     */
    public function createDeposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:10000',
            'currency' => 'required|in:BTC,ETH,USDT,LTC,BCH,TRX',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $amount = $request->amount;
        $currency = $request->currency;

        // Create payment with NOWPayments
        $payment = $this->nowPayments->createPayment($amount, $currency, Auth::id(), 'deposit');

        if (!$payment) {
            return back()->with('error', 'Failed to create payment. Please try again.');
        }

        // Store transaction in database
        $transaction = CryptoTransaction::create([
            'user_id' => Auth::id(),
            'payment_id' => $payment['payment_id'],
            'order_id' => $payment['order_id'],
            'type' => 'deposit',
            'status' => $payment['payment_status'],
            'currency' => strtoupper($currency),
            'amount_crypto' => $payment['pay_amount'],
            'amount_usd' => $amount,
            'pay_address' => $payment['pay_address'],
            'payment_url' => $payment['invoice_url'] ?? null,
            'metadata' => json_encode($payment),
        ]);

        return redirect($payment['invoice_url'])->with('success', 'Payment created! Complete the transaction to add funds.');
    }

    /**
     * Handle NOWPayments IPN callback
     */
    public function handleCallback(Request $request)
    {
        // Verify IPN signature
        $signature = $request->header('x-nowpayments-sig');
        
        if (!$this->nowPayments->verifyIPNSignature($request->all(), $signature)) {
            Log::error('NOWPayments: Invalid IPN signature');
            return response('Invalid signature', 403);
        }

        $data = $request->all();
        $paymentId = $data['payment_id'] ?? null;

        if (!$paymentId) {
            return response('Payment ID missing', 400);
        }

        // Find transaction
        $transaction = CryptoTransaction::where('payment_id', $paymentId)->first();

        if (!$transaction) {
            Log::error('NOWPayments: Transaction not found for payment_id: ' . $paymentId);
            return response('Transaction not found', 404);
        }

        // Update transaction status
        $transaction->update([
            'status' => $data['payment_status'] ?? 'waiting',
            'txn_id' => $data['outcome_hash'] ?? null,
            'confirmations' => $data['confirmations'] ?? 0,
            'confirmed_at' => $data['payment_status'] === 'confirmed' ? now() : null,
            'completed_at' => $data['payment_status'] === 'finished' ? now() : null,
            'metadata' => json_encode($data),
        ]);

        // If payment is finished/confirmed, credit user's account
        if (in_array($data['payment_status'], ['finished', 'confirmed'])) {
            if ($transaction->type === 'deposit' && $transaction->status !== 'completed') {
                $user = $transaction->user;
                $user->increment('balance', $transaction->amount_usd);
                
                $transaction->update(['status' => 'completed']);
                
                Log::info('NOWPayments: Deposit completed for user ' . $user->uid . ' - $' . $transaction->amount_usd);
            }
        }

        return response('OK', 200);
    }

    /**
     * Show crypto withdrawal page
     */
    public function withdrawalIndex()
    {
        $currencies = ['BTC', 'ETH', 'USDT'];
        $minWithdrawal = 5.00; // Minimum $5 withdrawal
        
        $transactions = CryptoTransaction::where('user_id', Auth::id())
            ->withdrawals()
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('templates.garnet.crypto.withdrawal', compact('currencies', 'transactions', 'minWithdrawal'));
    }

    /**
     * Create crypto withdrawal
     */
    public function createWithdrawal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:5|max:' . Auth::user()->balance,
            'currency' => 'required|in:BTC,ETH,USDT',
            'wallet_address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $amount = $request->amount;
        $currency = $request->currency;
        $walletAddress = $request->wallet_address;

        // Estimate crypto amount
        $cryptoAmount = $this->nowPayments->estimatePrice($amount, $currency);

        if (!$cryptoAmount) {
            return back()->with('error', 'Failed to calculate crypto amount. Please try again.');
        }

        // Create payout
        $payout = $this->nowPayments->createPayout($walletAddress, $cryptoAmount, $currency);

        if (!$payout) {
            return back()->with('error', 'Failed to create withdrawal. Please try again.');
        }

        // Deduct from user balance
        $user = Auth::user();
        $user->decrement('balance', $amount);

        // Store transaction
        CryptoTransaction::create([
            'user_id' => $user->id,
            'payment_id' => $payout['id'] ?? 'payout_' . time(),
            'order_id' => 'withdrawal_' . $user->uid . '_' . time(),
            'type' => 'withdrawal',
            'status' => 'confirming',
            'currency' => strtoupper($currency),
            'amount_crypto' => $cryptoAmount,
            'amount_usd' => $amount,
            'wallet_address' => $walletAddress,
            'metadata' => json_encode($payout),
        ]);

        return back()->with('success', 'Withdrawal initiated! Your crypto will be sent shortly.');
    }
}

