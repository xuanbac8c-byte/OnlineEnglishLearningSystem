<?php
    namespace App\Services\Interfaces;
    use App\Models\LessonProgress;
    use Illuminate\Support\Collection;

    interface ILessonProgressService 
    {
    public function updateProgress(int $userId, int $lessonId, float $percent): LessonProgress;
    public function markCompleted(int $userId, int $lessonId): LessonProgress;
    public function getProgress(int $userId, int $lessonId): ?LessonProgress;
    public function getCourseProgress(int $userId, int $courseId): float; // % hoàn thành khóa học
    public function getCompletedLessons(int $userId, int $courseId): Collection;
    public function isLessonCompleted(int $userId, int $lessonId): bool;
    }
?>