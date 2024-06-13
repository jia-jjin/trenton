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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seat_id')->constrained('seats');
            $table->foreignId('user_id')->constrained('users');
            $table->date('date');
            $table->foreignId('departing_destination')->constrained('train_destinations');
            $table->foreignId('arriving_destination')->constrained('train_destinations');
            $table->decimal('price',8,2)->default(0);
            $table->longText('qrCode');
            $table->boolean('isActive')->default(true);
            $table->boolean('hasInsurance')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
