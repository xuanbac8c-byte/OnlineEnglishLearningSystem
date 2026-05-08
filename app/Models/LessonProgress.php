<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class LessonProgress extends Model {
        protected $table = 'lesson_progresses';
        protected $primaryKey = 'progress_id';
        public $timestamps = true;

        protected $fillable = [
            'user_id',
            'lesson_id',
            'completed_percent',
            'is_completed',
            'completed_at',
        ];

        protected $casts = [
            'user_id' => 'integer',
            'lesson_id' => 'integer',
            'completed_percent' => 'decimal:2',
            'is_completed' => 'bool',
            'completed_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];

        public function user() : BelongsTo {
            return $this->belongsTo(User::class, 'user_id');
        }
        public function lesson() : BelongsTo {
            return $this->belongsTo(Lesson::class, 'lesson_id');
        }
    }
?>