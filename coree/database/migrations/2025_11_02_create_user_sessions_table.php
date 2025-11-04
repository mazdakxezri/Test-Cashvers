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
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('uid')->index();
            $table->string('ip_address', 45);
            $table->string('country_code', 2)->nullable();
            $table->string('city')->nullable();
            $table->string('timezone')->nullable();
            $table->string('device_type', 20)->nullable(); // mobile, desktop, tablet
            $table->string('os', 50)->nullable(); // Windows, Mac, iOS, Android
            $table->string('browser', 50)->nullable(); // Chrome, Firefox, etc
            $table->string('browser_version', 20)->nullable();
            $table->integer('screen_width')->nullable();
            $table->integer('screen_height')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_fingerprint', 64)->index(); // Unique device ID
            $table->timestamp('login_at');
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index('ip_address');
            $table->index('device_fingerprint');
            $table->index(['user_id', 'login_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};

