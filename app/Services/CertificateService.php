<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\Course;
use ICertificateService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CertificateService implements ICertificateService
{
    public function issue(
        int $userId,
        int $courseId
    ): Certificate
    {
        // kiểm tra điều kiện
        if (!$this->canReceive(
            $userId,
            $courseId
        )) {
            throw new \Exception(
                'User chưa hoàn thành khóa học'
            );
        }

        // tránh cấp trùng
        $existing = Certificate::where(
            'user_id',
            $userId
        )
        ->where(
            'course_id',
            $courseId
        )
        ->first();

        if ($existing) {
            return $existing;
        }

        return Certificate::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'cert_code' => strtoupper(
                Str::random(12)
            ),
            'issued_at' => now()
        ]);
    }

    public function canReceive(
        int $userId,
        int $courseId
    ): bool
    {
        // tổng số lesson
        $totalLessons = DB::table('lesson')
            ->join(
                'section',
                'lesson.section_id',
                '=',
                'section.id'
            )
            ->where(
                'section.course_id',
                $courseId
            )
            ->count();

        // số lesson completed
        $completedLessons = DB::table(
            'lesson_progress'
        )
        ->join(
            'lesson',
            'lesson_progress.lesson_id',
            '=',
            'lesson.id'
        )
        ->join(
            'section',
            'lesson.section_id',
            '=',
            'section.id'
        )
        ->where(
            'lesson_progress.user_id',
            $userId
        )
        ->where(
            'lesson_progress.is_completed',
            true
        )
        ->where(
            'section.course_id',
            $courseId
        )
        ->count();

        if ($totalLessons === 0) {
            return false;
        }

        return $completedLessons >= $totalLessons;
    }

    public function verify(
        string $certCode
    ): ?Certificate
    {
        return Certificate::where(
            'cert_code',
            $certCode
        )
        ->first();
    }

    public function getByUser(
        int $userId
    ): Collection
    {
        return Certificate::where(
            'user_id',
            $userId
        )
        ->orderBy(
            'issued_at',
            'desc'
        )
        ->get();
    }

    public function getByCourse(
        int $courseId
    ): Collection
    {
        return Certificate::where(
            'course_id',
            $courseId
        )
        ->orderBy(
            'issued_at',
            'desc'
        )
        ->get();
    }

    public function delete(
        int $id
    ): bool
    {
        $certificate = Certificate::findOrFail($id);

        return $certificate->delete();
    }
}