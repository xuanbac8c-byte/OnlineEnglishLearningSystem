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
        Schema::create('courses', function (Blueprint $table) {
            $table->id('course_id');

            $table->foreignId('teacher_id')
                  ->constrained('users', 'user_id')
                  ->onDelete('cascade');

            $table->foreignId('language_id')
                  ->constrained('languages', 'language_id')
                  ->onDelete('cascade');

            $table->string('title');

            $table->text('description')->nullable();

            $table->string('level');

            $table->decimal('price', 10, 2)->default(0);

            $table->string('thumbnail_url')->nullable();

            $table->boolean('is_published')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
