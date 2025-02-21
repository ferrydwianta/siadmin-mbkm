<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversion extends Model
{
    protected $fillable = [
        'activity_registration_id',
        'course_id',
        'grade',
    ];

    public function activityRegistration(): BelongsTo
    {
        return $this->belongsTo(ActivityRegistration::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
