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
        Schema::create('transfer_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->float('amount');
            $table->string('action');
            $table->string('platform');
            $table->string('ip_address');
            $table->foreignUuid('user_sender_log_id')->references('id')->on('user_logs')->onDelete('cascade');
            $table->foreignUuid('user_receiver_log_id')->references('id')->on('user_logs')->onDelete('cascade');
            $table->foreignUuid('transfer_id')->references('id')->on('transfers')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_logs');
    }
};
