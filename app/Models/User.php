<?php 
    namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class User extends Model {
        protected $table = 'users';
        protected $primaryKey = 'user_id';
        public $timestamps = true;

        protected $fillable = [
            'fullname',
            'email',
            'password_hash',
            'avatar_url',
            'role',
            'created_at',
            'updated_at'
        ];
        protected $casts = [
            'user_id' => 'integer',
            'fullname' => 'string',
            'email' => 'string',
            'password_hash' => 'string',
            'avatar_url' => 'string',
            'role' => UserRole::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];

        public function payments() : HasMany {
            return $this->hasMany(Payment::class,'user_id');
        }
        public function enrollments() : HasMany {
            return $this->hasMany(Enrollment::class, 'user_id');
        }
        public function courses() : HasMany {
            return $this->hasMany(Course::class, 'teacher_id','user_id');
        }
        public function courseReviews() : HasMany{
            return $this->hasMany(CourseReview::class, 'user_id');
        }
        public function lessonProgresses() : HasMany {
            return $this->hasMany(LessonProgress::class, 'user_id');
        }
        public function certificates() : HasMany {
            return $this->hasMany(Certificate::class, 'user_id');
        }
        public function quizAttempts() : HasMany {
            return $this->hasMany(QuizAttempt::class, 'user_id');
        }
    }
?>