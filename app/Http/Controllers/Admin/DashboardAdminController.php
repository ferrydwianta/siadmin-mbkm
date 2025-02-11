<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Course;
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
                'subtitle' => 'Menampilkan semua statistik pada platform ini',
            ],
            'count' => [
                'courses' => Course::count(),
                'activities' => Activity::count(),
                'students' => Student::count(),
            ]
        ]);
    }
}
