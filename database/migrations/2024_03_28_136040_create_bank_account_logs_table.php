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
        Schema::create('bank_account_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('bank');
            $table->integer('branch_number');
            $table->integer('branch_digit');
            $table->integer('account_number');
            $table->integer('account_digit');
            $table->string('action');
            $table->string('platform');
            $table->string('ip_address');
            $table->foreignUuid('user_log_id')->references('id')->on('user_logs')->onDelete('cascade');
            $table->foreignUuid('bank_account_id')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_account_logs');
    }
};
