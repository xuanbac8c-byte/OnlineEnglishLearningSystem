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
        Schema::create('quizzes', function (Blueprint $table) {
             $table->id('quiz_id');

            $table->foreignId('lesson_id')
                  ->constrained('lessons', 'lesson_id')
                  ->onDelete('cascade');

            $table->string('title');

            $table->text('description')->nullable();

            $table->decimal('pass_score', 5, 2)
                  ->default(0);

            $table->integer('time_limit_sec')
                  ->nullable();

            $table->integer('max_attempts')
                  ->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
