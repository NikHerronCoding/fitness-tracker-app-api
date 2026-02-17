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
        Schema::create('exercise_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exercise_id')
                ->constrained('exercises')
                ->cascadeOnDelete();

            $table->string('name');                
            $table->text('default_cues')->nullable();

            $table->boolean('is_default')->default(false);

            $table->timestamps();

            // Prevent duplicate variant names per exercise
            $table->unique(['exercise_id', 'name']);

            $table->index(['exercise_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_variants');
    }
};
