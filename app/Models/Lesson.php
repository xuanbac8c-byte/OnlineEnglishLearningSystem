<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Lesson extends Model {
        protected $table = 'lessons';
        protected $primaryKey = 'lesson_id';
        public $timestamps = true;

        protected $fillable = [
            'section_id',
            'title',
            'content',
            'video_url',
            'duration_minutes',
            'sort_order',
        ];

        protected $casts = [
            'section_id' => 'integer',
            'title' => 'string',
            'content' => 'string',
            'video_url' => 'string',
            'duration_minutes' => 'integer',
            'sort_order' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];

        public function section() : BelongsTo {
            return $this->belongsTo(Section::class, 'section_id');
        }
        public function lessonProgresses() : HasMany {
            return $this->hasMany(LessonProgress::class, 'lesson_id');
        }
        public function quizzes() : HasMany {
            return $this->hasMany(Quiz::class, 'lesson_id');
        }
    }
?>