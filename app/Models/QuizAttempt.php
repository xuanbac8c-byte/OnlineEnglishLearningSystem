<?php 
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class QuizAttempt extends Model {
        protected $table = 'quiz_attempts';
        protected $primaryKey = 'quiz_attempt_id';
        public $timestamps = true;

        protected $fillable = [
            'user_id',
            'quiz_id',
            'attempt_number',
            'score',
            'is_passed',
            'started_at',
            'submitted_at'
        ];

        protected $casts = [
            'user_id' => 'integer',
            'quiz_id' => 'integer',
            'attempt_number' => 'integer',
            'score' => 'decimal:2',
            'is_passed' => 'boolean',
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];

        public function user() : BelongsTo {
            return $this->belongsTo(User::class, 'user_id');
        }
        public function quiz() : BelongsTo {
            return $this->belongsTo(Quiz::class, 'quiz_id');
        }
        public function quizAnswers() : HasMany {
            return $this->hasMany(QuizAnswer::class, 'quiz_attempt_id');
        }
    }
?>