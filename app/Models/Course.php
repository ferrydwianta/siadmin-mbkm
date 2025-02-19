<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    // Many-to-many relations with pivot table (course conversions of activities)
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activity_course')->withTimestamps();
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function($query, $search) {
            $query->whereAny([
                'name',
                'code',
            ], 'REGEXP', $search);
        });
    }

    public function scopeSorting(Builder $query, array $sorts): void
    {
        $query->when($sorts['field'] ?? null && $sorts['direction'] ?? null, function($query) use ($sorts) {
            $query->orderBy($sorts['field'], $sorts['direction']);
        });
    }
}
