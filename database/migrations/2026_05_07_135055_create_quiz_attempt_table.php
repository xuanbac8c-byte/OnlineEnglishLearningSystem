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
        Schema::create('quiz_attempts', function (Blueprint $table) {
             $table->id('quiz_attempt_id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('quiz_id');

            $table->integer('attempt_number')->default(1);

            $table->decimal('score', 10, 2)->nullable();
            $table->boolean('is_passed')->default(false);

            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('quiz_id')
                ->references('quiz_id')
                ->on('quizzes')
                ->onDelete('cascade');

            $table->unique(['user_id', 'quiz_id', 'attempt_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
