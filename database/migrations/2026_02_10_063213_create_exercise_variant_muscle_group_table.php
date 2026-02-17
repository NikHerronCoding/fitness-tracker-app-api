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
        Schema::create('exercise_variant_muscle_group', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exercise_variant_id')
                ->constrained('exercise_variants')
                ->cascadeOnDelete();

            $table->foreignId('muscle_group_id')
                ->constrained('muscle_groups')
                ->cascadeOnDelete();

            $table->decimal('proportion', 5, 4); // expect 0.0000–1.0000
            $table->string('role')->nullable();  // primary / secondary (optional)

            $table->timestamps();

            $table->unique(['exercise_variant_id', 'muscle_group_id']);
            $table->index(['exercise_variant_id']);
            $table->index(['muscle_group_id']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_variant_muscle_group');
    }
};
