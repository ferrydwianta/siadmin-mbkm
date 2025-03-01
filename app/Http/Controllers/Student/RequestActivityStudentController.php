<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\ActivityStudentResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class RequestActivityStudentController extends Controller
{
    public function create(): Response | RedirectResponse
    {

        return inertia('Students/RequestActivities/Create', [
            'page_settings' => [
                'title' => 'Pengajuan Kegiatan MBKM',
                'subtitle' => 'Tambah Kegiatan MBKM yang Belum Terdaftar di Sistem!',
                'method' => 'POST',
                'action' => route('students.request-activities.store')
            ],
        ]);
    }
}
