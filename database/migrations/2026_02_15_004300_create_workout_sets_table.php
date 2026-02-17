<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('workout_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_entry_id')
                ->constrained('workout_entries')
                ->cascadeOnDelete();

            $table->unsignedInteger('position')->nullable(); // set ordering within entry

            $table->decimal('weight', 8, 2)->nullable(); // kg/lb, you decide at UI level for v1
            $table->unsignedInteger('reps');

            $table->decimal('rir', 3, 1)->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['workout_entry_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_sets');
    }
};
