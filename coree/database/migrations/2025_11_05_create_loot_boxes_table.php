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
        // Loot box types (admin creates these)
        Schema::create('loot_box_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price_usd', 10, 2);
            $table->boolean('can_buy_with_earnings')->default(true);
            $table->boolean('can_buy_with_crypto')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Loot box items/rewards (admin creates these)
        Schema::create('loot_box_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loot_box_type_id');
            $table->string('name');
            $table->string('type'); // 'cash', 'bonus_multiplier', 'free_boxes', 'cosmetic', 'mystery'
            $table->decimal('value', 10, 2)->nullable(); // For cash rewards
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->enum('rarity', ['common', 'uncommon', 'rare', 'epic', 'legendary'])->default('common');
            $table->decimal('drop_rate', 5, 2); // Percentage (0.01 to 100.00)
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('loot_box_type_id')->references('id')->on('loot_box_types')->onDelete('cascade');
            $table->index('loot_box_type_id');
            $table->index('rarity');
        });

        // User's loot box purchases
        Schema::create('loot_box_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('loot_box_type_id');
            $table->enum('payment_method', ['earnings', 'crypto'])->default('earnings');
            $table->decimal('price_paid', 10, 2);
            $table->string('crypto_currency')->nullable();
            $table->boolean('opened')->default(false);
            $table->timestamp('opened_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('loot_box_type_id')->references('id')->on('loot_box_types')->onDelete('cascade');
            $table->index('user_id');
            $table->index('opened');
        });

        // User's loot box inventory/rewards
        Schema::create('user_loot_box_rewards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('loot_box_purchase_id');
            $table->unsignedBigInteger('loot_box_item_id');
            $table->decimal('value_received', 10, 2)->nullable();
            $table->boolean('claimed')->default(false);
            $table->timestamp('claimed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('loot_box_purchase_id')->references('id')->on('loot_box_purchases')->onDelete('cascade');
            $table->foreign('loot_box_item_id')->references('id')->on('loot_box_items')->onDelete('cascade');
            $table->index('user_id');
            $table->index('claimed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_loot_box_rewards');
        Schema::dropIfExists('loot_box_purchases');
        Schema::dropIfExists('loot_box_items');
        Schema::dropIfExists('loot_box_types');
    }
};

