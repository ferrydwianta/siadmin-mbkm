<?php

namespace App\Models;

use App\Enums\AcademicYearSemester;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'startDate',
        'end_date',
        'semester',
        'is_active',
    ];

    protected function casts(): array 
    {
        return [
            'semester' => AcademicYearSemester::class,
        ];
    }
}
