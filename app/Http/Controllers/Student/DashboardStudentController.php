<?php

namespace App\Http\Controllers\Student;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Course;
use App\Models\Partner;

class DashboardStudentController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Students/Dashboard', [
            'page_settings' => [
                'title' => 'Dashboard',
                'subtitle' => 'Menampilkan semua statistik pada platform ini',
            ],
            'count' => [
                'partners' => Partner::count(),
                'activities' => Activity::count(),
                'courses' => Course::count(),
            ]
        ]);
    }
}
