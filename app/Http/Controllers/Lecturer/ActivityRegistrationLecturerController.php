<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ActivityRegistrationResource;
use App\Models\ActivityRegistration;
use Illuminate\Http\Request;
use Inertia\Response;

class ActivityRegistrationLecturerController extends Controller
{
    public function index(): Response
    {
        $activityRegistrations = ActivityRegistration::query()
            ->select(['activity_registrations.id', 'activity_registrations.student_id', 'activity_registrations.academic_year_id', 'activity_registrations.status', 'activity_registrations.member_type', 'activity_registrations.created_at', 'activity_registrations.activity_id', 'activity_registrations.notes', 'activity_registrations.schedule_id'])
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->with(['academicYear', 'activity', 'schedule', 'conversions', 'conversions.course', 'student', 'student.user'])
            ->latest('created_at')
            ->paginate(request()->load ?? 10);
            
        return inertia('Lecturers/ActivityRegistrations/Index', [
            'page_settings' => [
                'title' => 'Pendaftaran Kegiatan MBKM',
                'subtitle' => 'List Pendaftaran Kegiatan MBKM oleh mahasiswa'
            ],
            'activityRegistrations' => ActivityRegistrationResource::collection($activityRegistrations)->additional([
                'meta' => [
                    'has_pages' => $activityRegistrations->hasPages()
                ]
            ]),
            'state' => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => 10
            ]
        ]);
    }
}
