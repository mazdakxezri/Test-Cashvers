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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('event_type'); // 'bonus_multiplier', 'special_offers', 'contest', 'announcement'
            $table->string('banner_image')->nullable();
            $table->string('banner_color')->default('#00B8D4'); // Background color
            $table->decimal('bonus_multiplier', 4, 2)->default(1.00); // e.g., 2.00 for 2x earnings
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->boolean('is_active')->default(true);
            $table->boolean('show_banner')->default(true);
            $table->boolean('send_notification')->default(false);
            $table->integer('priority')->default(0); // Higher = shows first
            $table->json('target_users')->nullable(); // null = all, or array of conditions
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

