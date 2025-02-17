<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lecturer extends Model
{
    protected $fillable = [
        'user_id',
        'lecturer_number',
        'academic_title',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function($query, $search){
            $query->whereAny([
                'academic_title',
                'lecturer_number'
            ], 'REGEXP', $search)
                ->orWhereHas('user', fn($query) => $query->whereAny(['name', 'email'], 'REGEXP', $search));
        });
    }

    public function scopeSorting(Builder $query, array $sorts): void
    {
        $query->when($sorts['field'] ?? null && $sorts['direction'] ?? null, function($query) use ($sorts) {
            match ($sorts['field']) {
                'name' => $query->join('users', 'lecturers.user_id', '=', 'users.id')
                    ->orderBy('users.name', $sorts['direction']),
                'email' => $query->join('users', 'lecturers.user_id', '=', 'users.id')
                    ->orderBy('users.email', $sorts['direction']),
                default => $query->orderBy($sorts['field'], $sorts['direction']),
            };
        });
    }
}
