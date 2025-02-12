<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'name',
        'code',
        'credit',
        'semester'
    ];

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => strtoupper($value),
            set: fn(string $value) => strtolower($value)
        );
    }

    public function activityConversions(): HasMany
    {
        return $this->hasMany(ActivityConversion::class);
    }
}
