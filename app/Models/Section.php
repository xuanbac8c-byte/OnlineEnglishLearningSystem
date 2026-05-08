<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Section extends Model {
        protected $table = 'sections';
        protected $primaryKey = 'section_id';
        public $timestamps = false;

        protected $fillable = [
            'course_id',
            'title',
            'sort_order'
        ];

        protected $casts = [
            'course_id' => 'integer',
            'title' => 'string',
            'sort_order' => 'integer'
        ];

        public function courses() : BelongsTo {
            return $this->belongsTo(Course::class, 'course_id');
        }
        public function lessons() : HasMany {
            return $this->hasMany(Lesson::class, 'section_id');
        }
    }
?>