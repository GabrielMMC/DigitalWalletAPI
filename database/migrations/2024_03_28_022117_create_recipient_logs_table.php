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
        Schema::create('recipient_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('recipient_code')->nullable();
            $table->float('balance')->default(0);
            $table->integer('document')->nullable();
            $table->string('type')->nullable();
            $table->string('action');
            $table->string('platform');
            $table->string('ip_address');
            $table->foreignUuid('user_log_id')->references('id')->on('user_logs')->onDelete('cascade');
            $table->foreignUuid('recipient_id')->references('id')->on('recipients')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipient_logs');
    }
};
