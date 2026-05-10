<?php

use App\Models\Lesson;
use Ramsey\Collection\Collection;

    interface ILessonService {
    public function getBySection(int $sectionId): Collection;
    public function findById(int $id): Lesson;
    public function create(array $data): Lesson;
    public function update(int $id, array $data): Lesson;
    public function delete(int $id): bool;
    public function reorder(int $sectionId, array $orderedIds): bool;
    public function getTotalDuration(int $courseId): int; // tổng phút
}
?>