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
        Schema::create('staff_duties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->references('id')->on('users');
            $table->foreignId('train_id')->constrained('trains');
            $table->date('date');
            $table->foreignId('departing_time')->constrained('train_destinations');
            $table->foreignId('arriving_time')->constrained('train_destinations');
            $table->foreignId('departing_destination')->constrained('destinations');
            $table->foreignId('arriving_destination')->constrained('destinations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_duties');
    }
};
