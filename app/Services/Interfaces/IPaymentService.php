<?php

    use App\Models\Payment;
    use Illuminate\Support\Collection;

    interface IPaymentService {
    public function createPayment(int $userId, int $courseId, array $data): Payment;
    public function confirmPayment(string $transactionRef): Payment;
    public function refund(int $paymentId): Payment;
    public function getByUser(int $userId): Collection;
    public function getByCourse(int $courseId): Collection;
    public function findByRef(string $transactionRef): ?Payment;
    public function isPaid(int $userId, int $courseId): bool;
    public function getRevenue(int $courseId): float;
}
?>