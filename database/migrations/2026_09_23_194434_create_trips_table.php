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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('budget')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_till')->nullable();
            $table->enum('status', ['visited', 'unvisited'])->default('unvisited')->nullable();
            $table->longText('description')->nullable();
            $table->enum('category', ['rest', 'nature', 'adventure'])->nullable();
            $table->string('image')->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
