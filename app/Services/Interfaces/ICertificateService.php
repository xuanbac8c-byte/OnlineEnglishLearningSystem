<?php

    use App\Models\Certificate;
    use Ramsey\Collection\Collection;

    interface ICertificateService {
    public function issue(int $userId, int $courseId): Certificate;
    public function canReceive(int $userId, int $courseId): bool; // kiểm tra đủ điều kiện
    public function verify(string $certCode): ?Certificate;
    public function getByUser(int $userId): Collection;
    public function getByCourse(int $courseId): Collection;
    public function delete(int $id): bool;
}
?>