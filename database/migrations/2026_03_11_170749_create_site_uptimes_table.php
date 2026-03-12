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
        Schema::create('site_uptimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('site_id')->index();
            $table->string('status');
            $table->unsignedSmallInteger('http_status')->nullable();
            $table->unsignedSmallInteger('response_time_ms')->nullable();
            $table->string('error')->nullable();
            $table->dateTime('checked_at')->useCurrent();

            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_uptimes');
    }
};
