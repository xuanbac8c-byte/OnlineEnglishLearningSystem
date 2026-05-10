<?php
    use App\Models\Course;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Ramsey\Collection\Collection;

    interface ICourseService {

    public function getAll(array $filters = [], int $perPage = 12): LengthAwarePaginator;
    public function getPublished(array $filters = []): LengthAwarePaginator;
    public function findById(int $id): Course;
    public function create(array $data): Course;
    public function update(int $id, array $data): Course;
    public function delete(int $id): bool;
    public function publish(int $id): Course;
    public function unpublish(int $id): Course;
    public function getByInstructor(int $teacherId): Collection;
    public function getWithDetails(int $id): Course; // with sections, lessons, reviews
}
?>