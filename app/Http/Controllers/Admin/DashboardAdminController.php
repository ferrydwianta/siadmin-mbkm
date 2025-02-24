<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StudentStatus;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityRegistration;
use App\Models\Partner;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Response;

class DashboardAdminController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Admin/Dashboard', [
            'page_settings' => [
                'title' => 'Dashboard',
                'subtitle' => 'Selamat datang di Sistem Informasi Administrasi MBKM',
            ],
            'count' => [
                'registrations' => ActivityRegistration::query()
                    ->where('status', StudentStatus::PENDING->value)
                    ->count(),
                'activities' => Activity::count(),
            ],
            'academicYear' => activeAcademicYear()
        ]);
    }
}
