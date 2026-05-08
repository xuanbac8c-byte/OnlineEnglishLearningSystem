<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Quiz extends Model {
        protected $table = 'quizzes';
        protected $primaryKey = 'quiz_id';
        public $timestamps = true;

        protected $fillable = [
            'lesson_id',
            'title',
            'description',
            'pass_score',
            'time_limit_sec',
            'max_attempts',
        ];

        protected $casts = [
            'lesson_id' => 'integer',
            'title' => 'string',
            'description' => 'string',
            'pass_score' => 'decimal:2',
            'time_limit_sec' => 'integer',
            'max_attempts' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];

        public function lesson() : BelongsTo {
            return $this->belongsTo(Lesson::class, 'lesson_id');
        }
        public function quizAttempts() : HasMany {
            return $this->hasMany(QuizAttempt::class, 'quiz_id');
        }
        public function quizQuestions() : HasMany {
            return $this->hasMany(QuizQuestion::class, 'quiz_id');
        }
    }
?>