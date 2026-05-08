<?php 
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class QuizQuestion extends Model {
        protected $table = 'quiz_questions';
        protected $primaryKey = 'quiz_question_id';
        public $timestamps = true;

        protected $fillable = [
            'quiz_id',
            'question',
            'question_type',
            'points'
        ];

        protected $casts = [
            'quiz_id' => 'integer',
            'question' => 'string',
            'question_type' => 'string',
            'points' => 'integer'
        ];

        public function quiz() : BelongsTo {
            return $this->belongsTo(Quiz::class, 'quiz_id');
        }
        public function quizOptions() : HasMany {
            return $this->hasMany(QuizOption::class, 'question_id');
        }
        public function quizAnswers() : HasMany {
            return $this->hasMany(QuizAnswer::class, 'question_id');
        }
    }
?>