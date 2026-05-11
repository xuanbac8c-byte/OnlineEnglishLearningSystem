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
        Schema::create('quiz_options', function (Blueprint $table) {
            $table->id('quiz_option_id');

            $table->unsignedBigInteger('question_id');

            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
            $table->integer('sort_order')->default(0);

            // FK
            $table->foreign('question_id')
                ->references('quiz_question_id')
                ->on('quiz_questions')
                ->onDelete('cascade');

            // tối ưu truy vấn đáp án theo câu hỏi
            $table->index('question_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_options');
    }
};
