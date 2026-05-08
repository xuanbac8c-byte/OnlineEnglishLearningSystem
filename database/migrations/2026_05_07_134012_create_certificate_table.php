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
        Schema::create('certificates', function (Blueprint $table) {
            
            $table->id('certificate_id');

            $table->foreignId('user_id')
                  ->constrained('users', 'user_id')
                  ->onDelete('cascade');

            $table->foreignId('course_id')
                  ->constrained('courses', 'course_id')
                  ->onDelete('cascade');

            $table->string('cert_code')->unique();

            $table->timestamp('issued_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
