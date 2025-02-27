<?php

namespace App\Http\Controllers\Student;

use App\Enums\MemberType;
use App\Enums\MessageType;
use App\Enums\StudentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ActivityRegistrationStudentRequest;
use App\Http\Resources\Admin\ActivityResource;
use App\Http\Resources\Student\ActivityRegistrationStudentResource;
use App\Http\Resources\Student\ActivityStudentResource;
use App\Models\Activity;
use App\Models\ActivityRegistration;
use App\Models\Conversion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Throwable;

class ActivityRegistrationStudentController extends Controller
{
    public function index(): Response
    {
        $activityRegistrations = ActivityRegistration::query()
            ->select(['id', 'student_id', 'academic_year_id', 'status', 'created_at', 'activity_id', 'notes', 'schedule_id'])
            ->where('student_id', auth()->user()->student->id)
            ->with(['academicYear', 'activity', 'schedule', 'conversions', 'conversions.course'])
            ->latest('created_at')
            ->paginate(request()->load ?? 10);
            
        return inertia('Students/ActivityRegistrations/Index', [
            'page_settings' => [
                'title' => 'KegiatanKu',
                'subtitle' => 'Daftar Kegiatan MBKM yang saya ikuti'
            ],
            'activityRegistrations' => ActivityRegistrationStudentResource::collection($activityRegistrations)->additional([
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

    public function create(Activity $activity): Response | RedirectResponse
    {
        if (!activeAcademicYear()) {
            flashMessage('Tidak ada tahun ajaran aktif! Silahkan hubungi koordinator', 'warning');
            return back();
        }

        $activityRegistration = ActivityRegistration::query()
            ->where('student_id', auth()->user()->student->id)
            ->where('activity_id', $activity->id)
            ->where('academic_year_id', activeAcademicYear()->id)
            ->where('status', '!=', StudentStatus::REJECT)
            ->exists();

        if ($activityRegistration) {
            flashMessage('Anda sudah mendaftar pada kegiatan ini', 'warning');
            return back();
        }

        return inertia('Students/ActivityRegistrations/Create', [
            'page_settings' => [
                'title' => 'Daftar Kegiatan MBKM',
                'subtitle' => 'Pilih konversi mata kuliah yang ingin diambil!',
                'method' => 'POST',
                'action' => route('students.activity-registrations.store', [$activity])
            ],
            'activity' => new ActivityStudentResource($activity->load('partner', 'courses')),
            'memberTypes' => MemberType::options()
        ]);
    }

    public function store(Activity $activity, ActivityRegistrationStudentRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $activityRegistration = ActivityRegistration::create([
                'student_id' => auth()->user()->student->id,
                'academic_year_id' => activeAcademicYear()->id,
                'activity_id' => $activity->id,
                'member_type' => $request->member_type
            ]);

            // Store each course as a conversion
            foreach ($request->conversions as $course_id) {
                Conversion::create([
                    'activity_registration_id' => $activityRegistration->id,
                    'course_id' => $course_id,
                    'grade' => null
                ]);
            }

            DB::commit();
            flashMessage(MessageType::CREATED->message('Pendaftaran Berhasil, tunggu verifikasi oleh koordinator MBKM!'));
            return to_route('students.activity-registrations.index');
        } catch (Throwable $e) {
            DB::rollBack();
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('students.activities.index');
        }
    }


    public function show(ActivityRegistration $activityRegistration): Response
    {
        return inertia('Students/ActivityRegistrations/Show', [
            'page_settings' => [
                'title' => 'Detail KegitanKu',
                'subtitle' => 'Informasi Lengkap Kegiatan MBKM yang Diikuti',
            ],
            'activityRegistration' => new ActivityRegistrationStudentResource($activityRegistration->load('academicYear', 'activity', 'activity.partner', 'schedule', 'conversions', 'conversions.course'))
        ]);
    }
}
