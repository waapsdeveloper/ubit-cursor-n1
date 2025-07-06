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
        Schema::create('auction_timer_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->constrained('auctions')->onDelete('cascade');
            $table->boolean('show_timer')->default(true);
            $table->boolean('show_days')->default(true);
            $table->boolean('show_hours')->default(true);
            $table->boolean('show_minutes')->default(true);
            $table->boolean('show_seconds')->default(true);
            $table->string('timer_style')->default('compact'); // compact, detailed, minimal
            $table->string('timer_color')->default('orange'); // orange, red, green, purple
            $table->boolean('auto_refresh')->default(true);
            $table->integer('refresh_interval')->default(1000); // milliseconds
            $table->string('expired_message')->default('Auction Ended');
            $table->boolean('show_warning')->default(true);
            $table->integer('warning_threshold')->default(3600); // seconds before end to show warning
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auction_timer_settings');
    }
};
