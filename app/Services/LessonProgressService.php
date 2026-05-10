<?php
    namespace App\Services;

use App\Models\LessonProgress;
use App\Models\Lesson;
use App\Models\Section;
use ILessonProgressService;
use Illuminate\Support\Collection;

class LessonProgressService implements ILessonProgressService
{
    public function updateProgress(int $userId, int $lessonId, float $percent): LessonProgress 
    {
        return LessonProgress::updateOrCreate(
            ['user_id' => $userId, 'lesson_id' => $lessonId],
            ['is_completed' => $percent >= 100, 'completed_at' => $percent >= 100 ? now() : null]
        );
    }

    public function markCompleted(int $userId, int $lessonId): LessonProgress 
    {
        return $this->updateProgress($userId, $lessonId, 100);
    }

    public function getProgress(int $userId, int $lessonId): ?LessonProgress 
    {
        return LessonProgress::where('user_id', $userId)
                             ->where('lesson_id', $lessonId)
                             ->first();
    }

    public function getCourseProgress(int $userId, int $courseId): float 
    {
        // Lấy tổng số bài học trong khóa học
        $totalLessons = Lesson::whereHas('section', function($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->count();

        if ($totalLessons === 0) return 0;

        // Lấy số bài học đã hoàn thành
        $completedCount = $this->getCompletedLessons($userId, $courseId)->count();

        return round(($completedCount / $totalLessons) * 100, 2);
    }

    public function getCompletedLessons(int $userId, int $courseId): Collection 
    {
        return LessonProgress::where('user_id', $userId)
            ->where('is_completed', true)
            ->whereHas('lesson.section', function($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })->get();
    }

    public function isLessonCompleted(int $userId, int $lessonId): bool 
    {
        return LessonProgress::where('user_id', $userId)
            ->where('lesson_id', $lessonId)
            ->where('is_completed', true)
            ->exists();
    }
}
?>