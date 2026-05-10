<?php

namespace App\Services;

use App\Models\Payment;
use App\Services\Interfaces\IPaymentService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PaymentService implements IPaymentService
{
    public function createPayment(int $userId, int $courseId, array $data): Payment
    {
        return Payment::create([
            'user_id'          => $userId,
            'course_id'        => $courseId,
            'amount'           => $data['amount'],
            'transaction_ref'  => $data['transaction_ref'] ?? strtoupper(Str::random(16)),
            'payment_method'   => $data['payment_method'] ?? 'credit_card',
            'status'           => 'pending',
        ]);
    }

    public function confirmPayment(string $transactionRef): Payment
    {
        $payment = Payment::where('transaction_ref', $transactionRef)->firstOrFail();
        $payment->update([
            'status'  => 'paid',
            'paid_at' => now(),
        ]);
        return $payment;
    }

    public function refund(int $paymentId): Payment
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->update(['status' => 'refunded']);
        return $payment;
    }

    public function getByUser(int $userId): Collection
    {
        return Payment::where('user_id', $userId)
            ->with('course')
            ->latest()
            ->get();
    }

    public function getByCourse(int $courseId): Collection
    {
        return Payment::where('course_id', $courseId)
            ->with('user')
            ->latest()
            ->get();
    }

    public function findByRef(string $transactionRef): ?Payment
    {
        return Payment::where('transaction_ref', $transactionRef)->first();
    }

    public function isPaid(int $userId, int $courseId): bool
    {
        return Payment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('status', 'paid')
            ->exists();
    }

    public function getRevenue(int $courseId): float
    {
        return (float) Payment::where('course_id', $courseId)
            ->where('status', 'paid')
            ->sum('amount');
    }
}

?>