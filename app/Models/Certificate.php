<?php 
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class Certificate extends Model {
        protected $table = 'certificates';
        protected $primaryKey = 'certificate_id';
        public $timestamps = false;

        protected $fillable = [
            'user_id',
            'course_id',
            'cert_code',
            'issued_at'
        ];

        protected $casts = [
            'user_id' => 'integer',
            'course_id' => 'integer',
            'cert_code' => 'string',
            'issued_at' => 'datetime',
        ];

        protected static function boot(){
            parent::boot();
            static::creating(function($certificate){
                $certificate->issued_at = now();
            });
        }

        public function user() : BelongsTo {
            return $this->belongsTo(User::class, 'user_id');
        }
        

        public function course() : BelongsTo {
            return $this->belongsTo(Course::class, 'course_id');
        }
    }
?>