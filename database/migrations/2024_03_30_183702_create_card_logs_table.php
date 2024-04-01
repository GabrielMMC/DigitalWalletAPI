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
        Schema::create('card_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('last_four_digits');
            $table->string('brand');
            $table->string('holder_name');
            $table->bigInteger('holder_document');
            $table->string('expiration');
            $table->string('card_code')->nullable();
            $table->string('action');
            $table->string('platform');
            $table->string('ip_address');
            $table->foreignUuid('user_log_id')->references('id')->on('user_logs')->onDelete('cascade');
            $table->foreignUuid('address_log_id')->references('id')->on('address_logs')->onDelete('cascade');
            $table->foreignUuid('card_id')->references('id')->on('cards')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_logs');
    }
};
