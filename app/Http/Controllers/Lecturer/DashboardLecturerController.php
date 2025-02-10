<?php

namespace App\Http\Controllers\Lecturer;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardLecturerController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Lecturers/Dashboard', [
            'page_settings' => [
                'title' => 'Dashboard',
                'subtitle' => 'Menampilkan semua statistik pada platform ini',
            ],
        ]);
    }
}
