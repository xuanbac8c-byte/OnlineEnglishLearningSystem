<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Lesson;
use App\Services\Interfaces\ICertificateService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CertificateService implements ICertificateService
{
    public function issue(int $userId, int $courseId): Certificate
    {
        if (!$this->canReceive($userId, $courseId)) {
            throw new \Exception('User chưa hoàn thành khóa học.');
        }

        // Tránh cấp trùng
        return Certificate::firstOrCreate(
            ['user_id' => $userId, 'course_id' => $courseId],
            ['cert_code' => strtoupper(Str::random(12)), 'issued_at' => now()]
        );
    }

    public function canReceive(int $userId, int $courseId): bool
    {
        // Dùng Eloquent thay raw query — tên bảng đúng
        $totalLessons = Lesson::whereHas('section', fn($q) => $q->where('course_id', $courseId))->count();

        if ($totalLessons === 0) {
            return false;
        }

        $completedLessons = \App\Models\LessonProgress::where('user_id', $userId)
            ->where('is_completed', true)
            ->whereHas('lesson.section', fn($q) => $q->where('course_id', $courseId))
            ->count();

        return $completedLessons >= $totalLessons;
    }

    public function verify(string $certCode): ?Certificate
    {
        return Certificate::where('cert_code', $certCode)->first();
    }

    public function getByUser(int $userId): Collection
    {
        return Certificate::where('user_id', $userId)
            ->orderByDesc('issued_at')
            ->get();
    }

    public function getByCourse(int $courseId): Collection
    {
        return Certificate::where('course_id', $courseId)
            ->orderByDesc('issued_at')
            ->get();
    }

    public function delete(int $id): bool
    {
        return Certificate::findOrFail($id)->delete();
    }
}

?>