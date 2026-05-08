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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id('quiz_question_id');

            $table->unsignedBigInteger('quiz_id');

            $table->text('question');
            $table->enum('question_type', ['single_choice', 'multiple_choice', 'fill_blank', 'true_false'])->default('single_choice'); 

            $table->integer('points')->default(1);

            $table->timestamps();

            // FK
            $table->foreign('quiz_id')
                ->references('quiz_id')
                ->on('quizzes')
                ->onDelete('cascade');

            $table->index('quiz_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
