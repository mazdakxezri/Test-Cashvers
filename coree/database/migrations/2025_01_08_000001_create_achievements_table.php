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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // unique identifier like 'first_offer'
            $table->string('name'); // Display name
            $table->text('description');
            $table->string('icon')->nullable(); // emoji or icon class
            $table->string('badge_image')->nullable(); // badge image path
            $table->string('category'); // 'earning', 'social', 'milestone', 'special'
            $table->string('tier')->default('bronze'); // bronze, silver, gold, platinum, diamond
            $table->integer('points')->default(10); // Achievement points
            $table->decimal('reward_amount', 10, 2)->default(0); // Cash reward
            $table->json('requirements')->nullable(); // {'type': 'offers_completed', 'count': 100}
            $table->integer('order')->default(0); // Display order
            $table->boolean('is_active')->default(true);
            $table->boolean('is_hidden')->default(false); // Hidden until unlocked
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};

