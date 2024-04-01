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
        Schema::create('recharge_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->float('amount');
            $table->integer('installments');
            $table->string('action');
            $table->string('platform');
            $table->string('ip_address');
            $table->foreignUuid('card_log_id')->references('id')->on('card_logs')->onDelete('cascade');
            $table->foreignUuid('user_log_id')->references('id')->on('user_logs')->onDelete('cascade');
            $table->foreignUuid('recharge_id')->references('id')->on('recharges')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recharge_logs');
    }
};
