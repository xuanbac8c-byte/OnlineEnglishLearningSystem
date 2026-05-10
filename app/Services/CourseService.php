<?php

namespace App\Services;

use App\Models\Course;
use ICourseService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CourseService implements ICourseService
{
    public function getAll(
        array $filters = [],
        int $perPage = 12
    ): LengthAwarePaginator
    {
        $query = Course::query();

        // filter by language
        if (!empty($filters['language_id'])) {
            $query->where(
                'language_id',
                $filters['language_id']
            );
        }

        // filter by level
        if (!empty($filters['level'])) {
            $query->where(
                'level',
                $filters['level']
            );
        }

        // search title
        if (!empty($filters['keyword'])) {
            $query->where(
                'title',
                'ILIKE',
                '%' . $filters['keyword'] . '%'
            );
        }

        return $query
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getPublished(
        array $filters = []
    ): LengthAwarePaginator
    {
        $query = Course::where(
            'is_published',
            true
        );

        if (!empty($filters['level'])) {
            $query->where(
                'level',
                $filters['level']
            );
        }

        return $query->paginate(12);
    }

    public function findById(int $id): Course
    {
        return Course::findOrFail($id);
    }

    public function create(array $data): Course
    {
        return Course::create([
            'language_id' => $data['language_id'],
            'teacher_id' => $data['teacher_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'level' => $data['level'],
            'price' => $data['price'],
            'thumbnail_url' => $data['thumbnail_url'] ?? null,
            'is_published' => false,
        ]);
    }

    public function update(
        int $id,
        array $data
    ): Course
    {
        $course = Course::findOrFail($id);

        $course->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'level' => $data['level'],
            'price' => $data['price'],
            'thumbnail_url' => $data['thumbnail_url'] ?? null,
        ]);

        return $course;
    }

    public function delete(int $id): bool
    {
        $course = Course::findOrFail($id);

        return $course->delete();
    }

    public function publish(int $id): Course
    {
        $course = Course::findOrFail($id);

        $course->update([
            'is_published' => true
        ]);

        return $course;
    }

    public function unpublish(int $id): Course
    {
        $course = Course::findOrFail($id);

        $course->update([
            'is_published' => false
        ]);

        return $course;
    }

    public function getByInstructor(
        int $teacherId
    ): Collection
    {
        return Course::where(
            'teacher_id',
            $teacherId
        )
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public function getWithDetails(
        int $id
    ): Course
    {
        return Course::with([
            'language',
            'teacher',
            'sections.lessons',
            'reviews.user'
        ])
        ->findOrFail($id);
    }
}