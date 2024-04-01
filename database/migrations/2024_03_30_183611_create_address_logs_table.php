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
        Schema::create('address_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('zip_code');
            $table->string('state');
            $table->string('city');
            $table->string('nbhd');
            $table->string('street');
            $table->string('complement')->nullable();
            $table->integer('number');
            $table->string('action');
            $table->string('platform');
            $table->string('ip_address');
            $table->foreignUuid('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreignUuid('user_log_id')->references('id')->on('user_logs')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_logs');
    }
};
