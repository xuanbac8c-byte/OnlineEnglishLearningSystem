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
        Schema::create('lessons', function (Blueprint $table) {
            
            $table->id('lesson_id');

            $table->foreignId('section_id')
                  ->constrained('sections', 'section_id')
                  ->onDelete('cascade');

            $table->string('title');

            $table->longText('content')->nullable();

            $table->string('video_url')->nullable();

            $table->integer('duration_minutes')
                  ->default(0);

            $table->integer('sort_order')
                  ->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
