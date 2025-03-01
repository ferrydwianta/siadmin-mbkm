<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Enums\StudentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ActivityRegistrationGradesRequest;
use App\Http\Requests\Admin\ActivityRegistrationRequest;
use App\Http\Resources\Admin\ActivityRegistrationResource;
use App\Http\Resources\Student\ActivityRegistrationStudentResource;
use App\Models\ActivityRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Throwable;

use function Pest\Laravel\delete;

class ActivityRegistrationController extends Controller
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

        return inertia('Admin/ActivityRegistrations/Index', [
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
            ],
            'statuses' => StudentStatus::options(),
        ]);
    }

    public function destroy(ActivityRegistration $activityRegistration): RedirectResponse
    {
        try {
            $activityRegistration->delete();
            flashMessage(MessageType::DELETED->message('Pendaftaran MBKM'));
            return to_route('admin.activity-registrations.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.activity-registrations.index');
        }
    }

    public function approve(ActivityRegistration $activityRegistration, ActivityRegistrationRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $activityRegistration->update([
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            // if($activityRegistration->status->value === StudentStatus::APPROVED->value) {
            // do add or update or other task to other table maybe if the status is approved
            // }

            DB::commit();

            match ($activityRegistration->status->value) {
                StudentStatus::REJECT->value => flashMessage('Pendaftaran Kegiatan Mahasiswa berhasil ditolak', 'error'),
                StudentStatus::APPROVED->value => flashMessage('Pendaftaran Kegiatan Mahasiswa berhasil diterima'),
                default => flashMessage('Berhasil merubah status menjadi Pending!', 'warning')
            };
            return to_route('admin.activity-registrations.index');
        } catch (Throwable $e) {
            DB::rollBack();
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.activity-registrations.index');
        }
    }

    public function grades(ActivityRegistration $activityRegistration, ActivityRegistrationGradesRequest $request): RedirectResponse
    {   
        try {
            DB::beginTransaction();

            foreach ($request->conversions as $conversionData) {
                $activityRegistration->conversions()
                    ->where('id', $conversionData['id'])
                    ->update(['grade' => $conversionData['grade']]);
            }
            
            DB::commit();

            flashMessage('Berhasil menambahkan nilai konversi');
            return to_route('admin.activity-registrations.index');
        } catch (Throwable $e) {
            DB::rollBack();
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.activity-registrations.index');
        }
    }
}
