<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use Sluggable;

    protected $fillable = [
        'partner_id',
        'name',
        'description',
        'slug'
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

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function($query, $search) {
            $query->whereAny([
                'name',
            ], 'REGEXP', $search)
                ->orWhereHas('partner', fn($query) => $query->where('name', 'REGEXP', $search));
        });
    }

    // public function scopeSorting(Builder $query, array $sorts): void
    // {
    //     $query->when($sorts['field'] ?? null && $sorts['direction'] ?? null, function($query) use ($sorts) {
    //         match($sorts['field']) {
    //             'partner_id' => $query->join('partners', 'activities.partner_id', '=', 'partners.id')
    //                 ->orderBy('partners.name', $sorts['direction']),
    //             default => $query->orderBy($sorts['field'], $sorts['direction']),
    //         };
    //     });
    // }

    public function scopeSorting(Builder $query, array $sorts): void
    {
        $query->select('activities.*') // Ensure only activities columns are selected
            ->when($sorts['field'] ?? null && $sorts['direction'] ?? null, function ($query) use ($sorts) {
            match ($sorts['field']) {
                'partner_id' => $query
                    ->join('partners', 'activities.partner_id', '=', 'partners.id')
                    ->orderBy('partners.name', $sorts['direction']),
                default => $query ->orderBy("activities.{$sorts['field']}", $sorts['direction']),
            };
        });
    }
}