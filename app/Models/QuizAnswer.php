<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAnswer extends Model
{
    protected $table = 'quiz_answers';

    protected $primaryKey = 'quiz_answer_id';

    public $timestamps = true;

    protected $fillable = [
        'quiz_attempt_id',
        'question_id',
        'selected_option_id',
        'answer_text',
        'is_correct',
        'points_earned'
    ];

    protected $casts = [
        'quiz_attempt_id' => 'integer',
        'question_id' => 'integer',
        'selected_option_id' => 'integer',
        'answer_text' => 'string',
        'is_correct' => 'boolean',
        'points_earned' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function quizAttempt(): BelongsTo
    {
        return $this->belongsTo(QuizAttempt::class, 'quiz_attempt_id');
    }
    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(QuizOption::class, 'selected_option_id');
    }
}