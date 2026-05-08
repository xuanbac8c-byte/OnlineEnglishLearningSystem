<?php 
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class Enrollment extends Model {
        protected $table = 'enrollments';
        protected $primaryKey = 'enrollment_id';
        public $timestamps = true;

        protected $fillable = [
            'user_id',
            'course_id',
            'enrolled_at'
        ];

        protected $casts = [
            'user_id' => 'integer',
            'course_id' => 'integer',
            'enrolled_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];

        public function user() : BelongsTo {
            return $this->belongsTo(User::class, 'user_id');
        }
        public function course() : BelongsTo {
            return $this->belongsTo(Course::class, 'course_id');
        }
    }
?>