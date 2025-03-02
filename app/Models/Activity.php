<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use Sluggable;

    protected $fillable = [
        'partner_id',
        'student_id',
        'name',
        'description',
        'type',
        'slug',
        'document',
        'status',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // Many-to-many relations with pivot table (course conversions)
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'activity_course')->withTimestamps();
    }

    public function activityRegistrations(): HasMany
    {
        return $this->hasMany(ActivityRegistration::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->whereAny([
                'activities.name',
                'activities.description',
                'activities.type',
            ], 'REGEXP', $search)
                ->orWhereHas('partner', fn($query) => $query->where('name', 'REGEXP', $search))
                ->orWhereHas('student', function ($query) use ($search) {
                    $query->whereAny(['student_number'], 'REGEXP', $search)
                        ->orWhereHas('user', fn($query) => $query->whereAny(['name'], 'REGEXP', $search));
                });
        });
    }

    public function scopeSorting(Builder $query, array $sorts): void
    {
        $query->when($sorts['field'] ?? null && $sorts['direction'] ?? null, function ($query) use ($sorts) {
            match ($sorts['field']) {
                'partner_id' => $query->join('partners', 'activities.partner_id', '=', 'partners.id')
                    ->orderBy('partners.name', $sorts['direction']),
                'student_id' => $query->join('students', 'activities.student_id', '=', 'students.id')
                    ->join('users', 'students.user_id', '=', 'users.id')
                    ->orderBy('users.name', $sorts['direction']),
                default => $query->orderBy($sorts['field'], $sorts['direction']),
            };
        });
    }
}
