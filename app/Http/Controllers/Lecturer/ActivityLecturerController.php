<?php

namespace App\Http\Controllers\Lecturer;

use App\Enums\StudentStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ActivityResource;
use App\Http\Resources\Lecturer\ActivityLecturerResource;
use App\Models\Activity;
use Illuminate\Http\Request;
use Inertia\Response;

class ActivityLecturerController extends Controller
{
    public function index(): Response
    {
        $activities = Activity::query()
            ->select(['activities.id', 'activities.partner_id', 'activities.name', 'activities.description', 'activities.slug', 'activities.created_at'])
            ->where('status', StudentStatus::APPROVED)
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->with('partner', 'courses')
            ->paginate(request()->load ?? 10);
        
        return inertia('Lecturers/Activities/Index', [
            'page_settings' => [
                'title' => 'Kegiatan MBKM',
                'subtitle' => 'Menampilkan semua kegiatan MBKM yang tersedia'
            ],

            'activities' => ActivityResource::collection($activities)->additional([
                'meta' => [
                    'has_pages' => $activities->hasPages(),
                ],
            ]),

            'state' => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => 10,
            ],
        ]);
    }
}
