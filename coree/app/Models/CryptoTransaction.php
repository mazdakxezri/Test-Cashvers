<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_id',
        'order_id',
        'type',
        'status',
        'currency',
        'amount_crypto',
        'amount_usd',
        'wallet_address',
        'pay_address',
        'payment_url',
        'txn_id',
        'confirmations',
        'confirmed_at',
        'completed_at',
        'metadata',
    ];

    protected $casts = [
        'amount_crypto' => 'decimal:8',
        'amount_usd' => 'decimal:2',
        'confirmations' => 'integer',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for deposits only
     */
    public function scopeDeposits($query)
    {
        return $query->where('type', 'deposit');
    }

    /**
     * Scope for withdrawals only
     */
    public function scopeWithdrawals($query)
    {
        return $query->where('type', 'withdrawal');
    }

    /**
     * Scope for completed transactions
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending transactions
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', ['waiting', 'confirming', 'confirmed']);
    }
}

