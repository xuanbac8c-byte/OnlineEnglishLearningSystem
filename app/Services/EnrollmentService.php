<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Services\Interfaces\IEnrollmentService;
use Illuminate\Support\Collection;

class EnrollmentService implements IEnrollmentService
{
    public function enroll(int $userId, int $courseId): Enrollment
    {
        $existing = Enrollment::where('user_id', $userId)
        ->where('course_id', $courseId)
        ->first();

        if ($existing) {
            return $existing;
        }

        return Enrollment::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrolled_at' => now()
        ]);
    }

    public function unenroll(int $userId, int $courseId): bool
    {
        return Enrollment::where('user_id', $userId)
        ->where('course_id', $courseId)
        ->delete();
    }

    public function isEnrolled(int $userId, int $courseId): bool
    {
        return Enrollment::where('user_id', $userId)
        ->where('course_id', $courseId)
        ->exists();
    }

    public function getByUser(int $userId): Collection
    {
        return Enrollment::where('user_id', $userId)->get();
    }

    public function getByCourse(int $courseId): Collection
    {
        return Enrollment::where('course_id', $courseId)->get();
    }

    public function countByCourse(int $courseId): int
    {
        return Enrollment::where('course_id', $courseId)->count();
    }
}