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
      Schema::create('payments', function (Blueprint $table) {
      $table->id('payment_id');

      $table->foreignId('user_id')
          ->constrained('users', 'user_id')
          ->onDelete('cascade');

      $table->foreignId('course_id')
          ->constrained('courses', 'course_id')
          ->onDelete('cascade');

      $table->decimal('amount', 10, 2);

      $table->string('transaction_ref')->unique();

      $table->enum('payment_method', [
        'credit_card',
        'momo',
        'vnpay',
        'bank_transfer',
        'zalopay'
      ])->default('credit_card');

      $table->enum('status', [
        'pending',
        'paid',
        'failed',
        'refunded'
      ])->default('pending');

      $table->timestamp('paid_at')->nullable();

      $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
