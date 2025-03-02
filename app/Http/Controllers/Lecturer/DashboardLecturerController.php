<?php

namespace App\Http\Controllers\Lecturer;

use App\Enums\StudentStatus;
use Inertia\Response;
use App\Models\Course;
use App\Models\Student;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Partner;

class DashboardLecturerController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Lecturers/Dashboard', [
            'page_settings' => [
                'title' => 'Dashboard',
                'subtitle' => 'Selamat datang di Sistem Informasi Administrasi MBKM',
            ],
            'count' => [
                'activities' => Activity::query()
                    ->where('status', StudentStatus::APPROVED->value)
                    ->count(),
                'students' => Student::count(),
                'partners' => Partner::count(),
            ],
            'academicYear' => activeAcademicYear()
        ]);
    }
}
