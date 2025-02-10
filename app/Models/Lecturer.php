<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lecturer extends Model
{
    protected $fillable = [
        'user_id',
        'lecturer_number',
        'full_name',
        'academic_title',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
