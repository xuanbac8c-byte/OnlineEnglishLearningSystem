<?php

namespace App\Services;

use App\Models\CourseReview;
use App\Services\Interfaces\ICourseReviewService;
use Illuminate\Support\Collection;

class CourseReviewService implements ICourseReviewService
{
    public function getByCourse(int $courseId): Collection
    {
        return CourseReview::where('course_id', $courseId)
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public function getByUser(int $userId): Collection
    {
        return CourseReview::where('user_id', $userId)->get();
    }

    public function create(int $userId, int $courseId, array $data): CourseReview
    {
        return CourseReview::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'rating' => $data['rating'],
            'comment' => $data['comment']
        ]);
    }

    public function update(int $reviewId, array $data): CourseReview
    {
        $review = CourseReview::findOrFail($reviewId);
        $review->update([
            'rating' => $data['rating'],
            'comment' => $data['comment']
        ]);
        return $review;
    }

    public function delete(int $reviewId): bool
    {
        return CourseReview::findOrFail($reviewId)->delete();
    }

    public function getAverageRating(int $courseId): float
    {
        return round(CourseReview::where('course_id',$courseId)->avg('rating') ?? 0, 1);
    }

    public function hasReviewed(int $userId, int $courseId): bool
    {
        return CourseReview::where('user_id', $userId)
        ->where('course_id', $courseId)
        ->exists();
    }
}
?>