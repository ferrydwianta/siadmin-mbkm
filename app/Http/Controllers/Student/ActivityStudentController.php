<?php

namespace App\Http\Controllers\Student;

use App\Enums\StudentStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ActivityResource;
use App\Http\Resources\Lecturer\ActivityLecturerResource;
use App\Http\Resources\Student\ActivityStudentResource;
use App\Models\Activity;
use Illuminate\Http\Request;
use Inertia\Response;

class ActivityStudentController extends Controller
{
    public function index(): Response
    {
        $activities = Activity::query()
            ->select(['activities.id', 'activities.partner_id', 'activities.name', 'activities.description', 'activities.type', 'activities.slug', 'activities.created_at'])
            ->where('status', StudentStatus::APPROVED)
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->with('partner', 'courses')
            ->latest('created_at')
            ->paginate(request()->load ?? 9);
        
        return inertia('Students/Activities/Index', [
            'page_settings' => [
                'title' => 'Kegiatan MBKM',
                'subtitle' => 'Menampilkan semua kegiatan MBKM yang tersedia'
            ],

            'activities' => ActivityStudentResource::collection($activities)->additional([
                'meta' => [
                    'has_pages' => $activities->hasPages(),
                ],
            ]),

            'state' => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => 9,
            ],
        ]);
    }

    public function show(Activity $activity): Response
    {
        return inertia('Students/Activities/Show', [
            'page_settings' => [
                'title' => 'Detail Kegiatan MBKM',
                'subtitle' => 'Informasi Lengkap Kegiatan MBKM',
            ],
            'activity' => new ActivityStudentResource($activity->load('partner', 'courses'))
        ]);
    }
}
