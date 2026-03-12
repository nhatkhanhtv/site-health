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
        Schema::create('sites', function (Blueprint $table) {
            $table->unsignedMediumInteger('id')->autoIncrement();
            $table->string('site_name')->index();
            $table->unsignedTinyInteger('time_interval');
            $table->dateTime('next_checked_at')->nullable()->index();
            $table->dateTime('ssl_expire_date')->nullable()->index();
            $table->dateTime('ssl_last_checked_at')->nullable();
            $table->string('ssl_issuer')->nullable();
            $table->boolean('ssl_is_valid')->default(false);
            $table->string('error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
