<?php

namespace App\Http\Controllers\Student;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardStudentController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Students/Dashboard', [
            'page_settings' => [
                'title' => 'Dashboard',
                'subtitle' => 'Menampilkan semua statistik pada platform ini',
            ],
        ]);
    }
}
