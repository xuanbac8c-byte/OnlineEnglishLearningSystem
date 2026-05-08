<?php 
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class CourseReview extends Model {
        protected $table = 'course_reviews';
        protected $primaryKey = 'course_review_id';
        public $timestamps = true;

        protected $fillable = [
            'user_id',
            'course_id',
            'rating',
            'comment',
        ];

        protected $casts = [
            'user_id' => 'integer',
            'course_id' => 'integer',
            'rating' => 'decimal:2',
            'comment' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];

        public function user() : BelongsTo {
            return $this->belongsTo(User::class, 'user_id');
        }
        public function course() : BelongsTo {
            return $this->belongsTo(Course::class, 'course_id');
        }
    }
?>