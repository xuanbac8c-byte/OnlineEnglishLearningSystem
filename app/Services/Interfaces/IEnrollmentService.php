<?php
    namespace App\Services\Interfaces;
    use App\Models\Enrollment;
    use Illuminate\Support\Collection;

    interface IEnrollmentService 
    {
    public function enroll(int $userId, int $courseId): Enrollment;
    public function unenroll(int $userId, int $courseId): bool;
    public function isEnrolled(int $userId, int $courseId): bool;
    public function getByUser(int $userId): Collection;
    public function getByCourse(int $courseId): Collection;
    public function countByCourse(int $courseId): int;
    }
?>