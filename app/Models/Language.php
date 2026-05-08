<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Language extends Model {
        protected $table = 'languages';
        protected $primaryKey = 'language_id';
        public $timestamps = true;

        protected $fillable = [
            'name',
            'code'
        ];

        protected $casts = [
            'name' => 'string',
            'code' => 'string'
        ];

        public function courses() : HasMany {
            return $this->hasMany(Course::class, 'language_id');
        }
    }
?>