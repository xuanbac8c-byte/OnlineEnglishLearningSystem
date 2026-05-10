<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class QuizOption extends Model {
        protected $table = 'quiz_options';
        protected $primaryKey = 'quiz_option_id';
        public $timestamps = false;

        protected $fillable = [
            'question_id',
            'option_text',
            'is_correct',
            'sort_order'
        ];

        protected $casts = [
            'question_id' => 'integer',
            'is_correct' => 'bool',
            'sort_order' => 'integer',
        ];
        
        public function quizQuestion() : BelongsTo {
            return $this->belongsTo(QuizQuestion::class, 'question_id');
        }
        public function quizAnswers() : HasMany {
            return $this->hasMany(QuizAnswer::class, 'selected_option_id');
        }
    }
?>