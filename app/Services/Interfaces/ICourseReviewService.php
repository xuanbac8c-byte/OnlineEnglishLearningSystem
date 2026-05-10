<?php
    namespace App\Services\Interfaces;
    use App\Models\CourseReview;
    use Illuminate\Support\Collection;

    interface ICourseReviewService 
    {
    public function getByCourse(int $courseId): Collection;
    public function getByUser(int $userId): Collection;
    public function create(int $userId, int $courseId, array $data): CourseReview;
    public function update(int $reviewId, array $data): CourseReview;
    public function delete(int $reviewId): bool;
    public function getAverageRating(int $courseId): float;
    public function hasReviewed(int $userId, int $courseId): bool;
    }
?>