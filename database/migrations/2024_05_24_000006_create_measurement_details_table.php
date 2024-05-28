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
        Schema::create('measurement_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('measurement_id')->constrained()
            ->cascadeOnDelete();
            $table->string('location', 255)
            ->nullable();
            $table->boolean('after_meal')
            ->nullable();
            $table->string('device', 255)
            ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurement_details');
    }
};
