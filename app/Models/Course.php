<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

    class Course extends Model {
        protected $table = 'courses';
        protected $primaryKey = 'course_id';
        public $timestamps = true; // insert created_at and updated_at automatically

        protected $fillable = [
            'language_id',
            'teacher_id',
            'title',
            'description',
            'level',
            'price',
            'thumbnail_url',
            'is_published',
        ]; // allow mass assignment for these fields

        protected $casts = [
            'teacher_id' => 'integer',
            'language_id' => 'integer',
            'price' => 'decimal:2',
            'is_published' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];

        public function user() : BelongsTo {
            return $this->belongsTo(User::class, 'teacher_id');
        }
        public function courseReviews() : HasMany {
            return $this->hasMany(CourseReview::class, 'course_id');
        }
        public function certificates() : HasMany {
            return $this->hasMany(Certificate::class, 'course_id');
        }
        public function sections() : HasMany {
            return $this->hasMany(Section::class, 'course_id');
        }
        public function language() : BelongsTo {
            return $this->belongsTo(Language::class, 'language_id');
        }
        public function enrollments() : HasMany {
            return $this->hasMany(Enrollment::class, 'course_id');
        }
        public function payments() : HasMany {
            return $this->hasMany(Payment::class, 'course_id');
        }
    }
?>