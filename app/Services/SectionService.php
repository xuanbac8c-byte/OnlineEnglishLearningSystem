<?php

namespace App\Services;

use App\Models\Section;
use Illuminate\Support\Collection;
use ISectionService;

class SectionService implements ISectionService
{
    public function getByCourse(int $courseId): Collection
    {
        return Section::where('course_id', $courseId)
            ->orderBy('sort_order')
            ->get();
    }

    public function findById(int $id): Section
    {
        return Section::findOrFail($id);
    }

    public function create(array $data): Section
    {
        return Section::create([
            'course_id'  => $data['course_id'],
            'title'      => $data['title'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);
    }

    public function update(int $id, array $data): Section
    {
        $section = Section::findOrFail($id);
        $section->update([
            'title'      => $data['title'] ?? $section->title,
            'sort_order' => $data['sort_order'] ?? $section->sort_order,
        ]);
        return $section;
    }

    public function delete(int $id): bool
    {
        return Section::findOrFail($id)->delete();
    }

    public function reorder(int $courseId, array $orderedIds): bool
    {
        foreach ($orderedIds as $order => $sectionId) {
            Section::where('section_id', $sectionId)
                ->where('course_id', $courseId)
                ->update(['sort_order' => $order + 1]);
        }
        return true;
    }
}

?>