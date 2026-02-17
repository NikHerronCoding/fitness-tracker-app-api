<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('workout_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_session_id')
                ->constrained('workout_sessions')
                ->cascadeOnDelete();

            $table->foreignId('exercise_variant_id')
                ->constrained('exercise_variants')
                ->restrictOnDelete();

            $table->unsignedInteger('position')->nullable(); // ordering within session
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['workout_session_id', 'position']);
            $table->index(['exercise_variant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_entries');
    }
};
