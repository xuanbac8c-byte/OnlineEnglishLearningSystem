<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';

    protected $primaryKey = 'payment_id';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'course_id',
        'amount',
        'transaction_ref',
        'payment_method',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'course_id' => 'integer',
        'amount' => 'decimal:2',
        'transaction_ref' => 'string',
        'payment_method' => 'string',
        'status' => 'string',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}