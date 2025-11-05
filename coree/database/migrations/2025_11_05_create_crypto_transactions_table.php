<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('crypto_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('payment_id')->unique();
            $table->string('order_id')->unique();
            $table->enum('type', ['deposit', 'withdrawal'])->default('deposit');
            $table->enum('status', ['waiting', 'confirming', 'confirmed', 'completed', 'failed', 'refunded', 'cancelled'])->default('waiting');
            $table->string('currency', 10); // BTC, ETH, USDT, etc
            $table->decimal('amount_crypto', 20, 8); // Amount in crypto
            $table->decimal('amount_usd', 10, 2); // Amount in USD
            $table->string('wallet_address')->nullable();
            $table->string('pay_address')->nullable(); // Address user pays to (for deposits)
            $table->text('payment_url')->nullable();
            $table->string('txn_id')->nullable(); // Blockchain transaction ID
            $table->integer('confirmations')->default(0);
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('metadata')->nullable(); // JSON for additional data
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
            $table->index('status');
            $table->index('type');
            $table->index('payment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_transactions');
    }
};

