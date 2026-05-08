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
        Schema::create('lesson_progresses', function (Blueprint $table) {
             $table->id('progress_id');

            $table->foreignId('user_id')
                  ->constrained('users', 'user_id')
                  ->onDelete('cascade');

            $table->foreignId('lesson_id')
                  ->constrained('lessons', 'lesson_id')
                  ->onDelete('cascade');

            $table->decimal('completed_percent', 5, 2)
                  ->default(0);

            $table->boolean('is_completed')
                  ->default(false);

            $table->timestamp('completed_at')
                  ->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_progresses');
    }
};
