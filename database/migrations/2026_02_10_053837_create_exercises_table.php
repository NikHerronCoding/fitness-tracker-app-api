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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('category')->nullable();
            $table->string('equipment')->nullable();

            $table->string('movement_pattern')->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('created_by_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->boolean('is_archived')->default('false');

            $table->timestamps();

            $table->index(['name']);
            $table->index(['category']);
            $table->index(['equipment']);
            $table->index(['movement_pattern']);
            $table->index(['created_by_user_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
