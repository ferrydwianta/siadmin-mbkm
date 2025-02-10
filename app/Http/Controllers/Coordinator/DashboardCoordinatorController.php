<?php

namespace App\Http\Controllers\Coordinator;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardCoordinatorController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Coordinators/Dashboard', [
            'page_settings' => [
                'title' => 'Dashboard',
                'subtitle' => 'Menampilkan semua statistik pada platform ini',
            ],
        ]);
    }
}
