<?php

namespace App\Services;

use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Services\Interfaces\ILessonProgressService;
use Illuminate\Support\Collection;

    class LessonProgressService implements ILessonProgressService
    {
        public function updateProgress(int $userId, int $lessonId, float $percent): LessonProgress
        {
            $percent   = min(100, max(0, $percent));
            $completed = $percent >= 100;

            return LessonProgress::updateOrCreate(
                ['user_id' => $userId, 'lesson_id' => $lessonId],
                [
                    'completed_percent' => $percent,
                    'is_completed'      => $completed,
                    'completed_at'      => $completed ? now() : null,
                ]
            );
        }

        public function markCompleted(int $userId, int $lessonId): LessonProgress
        {
            return $this->updateProgress($userId, $lessonId, 100);
        }

        public function getProgress(int $userId, int $lessonId): ? LessonProgress
        {
            return LessonProgress::where('user_id', $userId)
                ->where('lesson_id', $lessonId)
                ->first();
        }

        public function getCourseProgress(int $userId, int $courseId): float
        {
            $totalLessons = Lesson::whereHas('section', fn($q) => $q->where('course_id', $courseId))->count();

            if ($totalLessons === 0) {
                return 0;
            }

            $completed = $this->getCompletedLessons($userId, $courseId)->count();

            return round(($completed / $totalLessons) * 100, 2);
        }

        public function getCompletedLessons(int $userId, int $courseId): Collection
        {
            return LessonProgress::where('user_id', $userId)
                ->where('is_completed', true)
                ->whereHas('lesson.section', fn($q) => $q->where('course_id', $courseId))
                ->get();
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