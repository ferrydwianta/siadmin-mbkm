<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Enums\ScheduleDay;
use App\Enums\StudentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScheduleRequest;
use App\Http\Resources\Admin\ActivityRegistrationResource;
use App\Http\Resources\Admin\ScheduleResource;
use App\Models\ActivityRegistration;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Throwable;

class ScheduleController extends Controller
{
    public function index(): Response
    {
        $schedule = Schedule::query()
            ->select(['schedules.id', 'schedules.academic_year_id', 'schedules.start_time', 'schedules.end_time', 'schedules.date', 'schedules.created_at'])
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->with(['activityRegistrations', 'academicYear'])
            ->paginate(request()->load ?? 10);

        return inertia('Admin/Schedules/Index', [
            'page_settings' => [
                'title' => 'Jadwal Ujian',
                'subtitle' => 'Menampilkan jadwal ujian akhir'
            ],
            'schedules' => ScheduleResource::collection($schedule)->additional([
                'meta' => [
                    'has_pages' => $schedule->hasPages()
                ],
            ]),
            'state' => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => 10,
            ],
        ]);
    }

    public function create(): Response | RedirectResponse
    {
        $activityRegistrations = ActivityRegistration::query()
            ->where('academic_year_id', activeAcademicYear()->id)
            ->where('status', '=', StudentStatus::APPROVED)
            ->whereNull('schedule_id')
            ->with('student.user:id,name', 'activity:id,name')
            ->get();

        if ($activityRegistrations->isEmpty()) {
            flashMessage('Tidak bisa menambahkan jadwal ujian! Data pendaftaran tidak ada.', 'warning');
            return back();
        }

        return inertia('Admin/Schedules/Create', [
            'page_settings' => [
                'title' => 'Tambah Jadwal',
                'subtitle' => 'Buat jadwal baru disini, Klik simpan setelah selesai.',
                'method' => 'POST',
                'action' => route('admin.schedules.store'),
            ],
            'activityRegistrations' => $activityRegistrations->map(fn($registration) => [
                'value' => $registration->id,
                'label' => "{$registration->student->user->name} ({$registration->activity->name})",
            ])->sortBy('label')->values(),
        ]);
    }

    public function store(ScheduleRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $academicYearId = optional(activeAcademicYear())->id;
            if (!$academicYearId) {
                flashMessage(MessageType::ERROR->message('Tahun akademik tidak ditemukan. Pastikan tahun akademik aktif sudah diatur.'), 'error');
                return redirect()->back()->withInput();
            }

            $schedule = Schedule::create([
                'academic_year_id' => $academicYearId,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date' => $request->date,
            ]);

            ActivityRegistration::whereIn('id', $request->selected_registrations)
                ->update(['schedule_id' => $schedule->id]);

            DB::commit();
            flashMessage(MessageType::CREATED->message('Jadwal'));
            return to_route('admin.schedules.index');
        } catch (Throwable $e) {
            DB::rollBack();
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.schedules.index');
        }
    }

    public function edit(Schedule $schedule): Response
    {
        // Retrieve all registration Ids linked to this schedule
        $existingRegistrationIds = $schedule->activityRegistrations->pluck('id')->toArray();

        $existingRegistrations = collect($existingRegistrationIds)->isNotEmpty()
            ? ActivityRegistration::whereIn('id', $existingRegistrationIds)
            ->with('student.user:id,name', 'activity:id,name')
            ->get()
            ->map(fn($registration) => [
                'value' => $registration->id,
                'label' => "{$registration->student->user->name} ({$registration->activity->name})",
            ])
            : collect();

        $newRegistrations = ActivityRegistration::query()
            ->where('academic_year_id', activeAcademicYear()->id)
            ->where('status', '=', StudentStatus::APPROVED)
            ->whereNull('schedule_id')
            ->with('student.user:id,name', 'activity:id,name')
            ->get()
            ->map(fn($registration) => [
                'value' => $registration->id,
                'label' => "{$registration->student->user->name} ({$registration->activity->name})",
            ]);

        // Merge selected registrations from this schedule with new activityRegistrations that are available
        $activityRegistrations = $existingRegistrations->merge($newRegistrations)
            ->unique('value')
            ->sortBy('label')
            ->values();

        return inertia('Admin/Schedules/Edit', [
            'page_settings' => [
                'title' => 'Edit Jadwal',
                'subtitle' => 'Edit jadwal disini, Klik simpan setelah selesai.',
                'method' => 'PUT',
                'action' => route('admin.schedules.update', $schedule),
            ],
            'schedule' => $schedule,
            'selected_registrations' => $existingRegistrationIds,
            'activityRegistrations' => $activityRegistrations,
        ]);
    }

    public function update(Schedule $schedule, ScheduleRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $schedule->update([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date' => $request->date,
            ]);

            // Reset schedule_id for all existing activityRegistrations linked to this schedule
            ActivityRegistration::where('schedule_id', $schedule->id)
                ->update(['schedule_id' => null]);

            // Assign new schedule_id to selected registrations
            ActivityRegistration::whereIn('id', $request->selected_registrations)
                ->update(['schedule_id' => $schedule->id]);

            DB::commit();
            flashMessage(MessageType::UPDATED->message('Jadwal'));
            return to_route('admin.schedules.index');
        } catch (Throwable $e) {
            DB::rollBack();
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.schedules.index');
        }
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        try {
            DB::beginTransaction();
            
            ActivityRegistration::where('schedule_id', $schedule->id)
                ->update(['schedule_id' => null]);

            $schedule->delete();

            DB::commit();
            flashMessage(MessageType::DELETED->message('Jadwal'));
            return to_route('admin.schedules.index');
        } catch (Throwable $e) {
            DB::rollBack();
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.schedules.index');
        }
    }
}
