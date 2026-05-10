<?php

namespace App\Services;

use App\Models\Lesson;
use App\Services\Interfaces\ILessonService;
use Illuminate\Support\Collection;

class LessonService implements ILessonService
{
    public function getBySection(int $sectionId): Collection
    {
        return Lesson::where('section_id', $sectionId)
            ->orderBy('sort_order')
            ->get();
    }

    public function findById(int $id): Lesson
    {
        return Lesson::findOrFail($id);
    }

    public function create(array $data): Lesson
    {
        return Lesson::create([
            'section_id'       => $data['section_id'],
            'title'            => $data['title'],
            'content'          => $data['content'] ?? null,
            'video_url'        => $data['video_url'] ?? null,
            'duration_minutes' => $data['duration_minutes'] ?? 0,
            'sort_order'       => $data['sort_order'] ?? 0,
        ]);
    }

    public function update(int $id, array $data): Lesson
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->update([
            'title'            => $data['title'] ?? $lesson->title,
            'content'          => $data['content'] ?? $lesson->content,
            'video_url'        => $data['video_url'] ?? $lesson->video_url,
            'duration_minutes' => $data['duration_minutes'] ?? $lesson->duration_minutes,
            'sort_order'       => $data['sort_order'] ?? $lesson->sort_order,
        ]);
        return $lesson;
    }

    public function delete(int $id): bool
    {
        return Lesson::findOrFail($id)->delete();
    }

    public function reorder(int $sectionId, array $orderedIds): bool
    {
        foreach ($orderedIds as $order => $lessonId) {
            Lesson::where('lesson_id', $lessonId)
                ->where('section_id', $sectionId)
                ->update(['sort_order' => $order + 1]);
        }
        return true;
    }

    public function getTotalDuration(int $courseId): int
    {
        return (int) Lesson::whereHas('section', fn($q) => $q->where('course_id', $courseId))
            ->sum('duration_minutes');
    }
}

?>