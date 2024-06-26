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
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()
            ->cascadeOnDelete();
            $table->foreignId('type_id')
            ->constrained('measurement_types')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            $table->dateTime('measurement_time');
            $table->double('value', 8, 2)
            ->nullable();
            $table->double('value_systolic')
            ->nullable();
            $table->double('value_diastolic')
            ->nullable();
            $table->string('note', 255)
            ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
