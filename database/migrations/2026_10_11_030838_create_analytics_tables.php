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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_id', 64)->index();
            $table->string('session_id', 64)->index();
            $table->string('path', 255)->index();
            $table->string('page_title', 255)->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('source', 100)->default('direct')->index();
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->string('device', 30)->default('desktop')->index();
            $table->string('browser', 50)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('ip_hash', 64)->index();
            $table->boolean('is_bot')->default(false)->index();
            $table->timestamp('created_at')->index();
        });

        Schema::create('click_events', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_id', 64)->index();
            $table->string('event', 60)->index();
            $table->string('label', 255)->nullable();
            $table->string('path', 255)->nullable();
            $table->timestamp('created_at')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('click_events');
        Schema::dropIfExists('page_views');
    }
};
