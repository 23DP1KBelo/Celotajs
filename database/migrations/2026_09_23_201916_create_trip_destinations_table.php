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
        Schema::create('trip_destinations', function (Blueprint $table) {
            $table->id();
            $table->boolean('recommendations')->default(0);
            $table->foreignId('trip_id')->references('id')->on('trips');
            $table->foreignId('destinantion_id')->references('id')->on('destinations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_destinations');
    }
};
