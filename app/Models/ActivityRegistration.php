<?php

namespace App\Models;

use App\Enums\StudentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ActivityRegistration extends Model
{
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'activity_id',
        'schedule_id',
        'status',
        'notes',
        'member_type',
        'document',
    ];

    protected function casts(): array
    {
        return [
            'status' => StudentStatus::class,
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function conversions(): HasMany
    {
        return $this->hasMany(Conversion::class);
    }

    public function scopeApprove(Builder $query)
    {
        $query->where('status', StudentStatus::APPROVED->value);
    }

    public function scopePending(Builder $query)
    {
        $query->where('status', StudentStatus::PENDING->value);
    }

    public function scopeReject(Builder $query)
    {
        $query->where('status', StudentStatus::REJECT->value);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->whereAny([
                'status',
                'member_type'
            ], 'REGEXP', $search)
                ->orWhereHas('student', function ($query) use ($search) {
                    $query->whereAny(['student_number'], 'REGEXP', $search)
                        ->orWhereHas('user', fn($query) => $query->whereAny(['name'], 'REGEXP', $search));
                })
                ->orWhereHas('activity', function ($query) use ($search) {
                    $query->whereAny(['name'], 'REGEXP', $search)
                        ->orWhereHas('partner', fn($query) => $query->whereAny(['name'], 'REGEXP', $search));
                })
                ->orWhereHas('schedule', fn($query) => $query->whereAny(['start_time'], 'REGEXP', $search))
                ->orWhereHas('academicYear', fn($query) => $query->whereAny(['name', 'semester'], 'REGEXP', $search));
        });
    }

    public function scopeSorting(Builder $query, array $sorts): void
    {
        $query->when($sorts['field'] ?? null && $sorts['direction'] ?? null, function ($query) use ($sorts) {
            match ($sorts['field']) {
                'activity_id' => $query->join('activities', 'activity_registrations.activity_id', '=', 'activities.id')
                    ->orderBy('activities.name', $sorts['direction']),
    
                'student_id' => $query->join('students', 'activity_registrations.student_id', '=', 'students.id')
                    ->join('users', 'students.user_id', '=', 'users.id')
                    ->orderBy('users.name', $sorts['direction']),
    
                'schedule_id' => $query->join('schedules', 'activity_registrations.schedule_id', '=', 'schedules.id')
                    ->orderBy('schedules.start_time', $sorts['direction']),

                'academic_year_id' => $query->join('academic_years', 'activity_registrations.academic_year_id', '=', 'academic_years.id')
                    ->orderBy('academic_years.id', $sorts['direction']),
    
                default => $query->orderBy($sorts['field'], $sorts['direction']),
            };
        });
    }
}
