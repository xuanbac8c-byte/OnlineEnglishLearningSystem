<?php
    namespace App\Services\Interfaces;
    use App\Models\Section;
    use Illuminate\Support\Collection;

    interface ISectionService 
    {
    public function getByCourse(int $courseId): Collection;
    public function findById(int $id): Section;
    public function create(array $data): Section;
    public function update(int $id, array $data): Section;
    public function delete(int $id): bool;
    public function reorder(int $courseId, array $orderedIds): bool; // drag-drop sort
    }
?>