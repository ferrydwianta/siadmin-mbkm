<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Enums\ScheduleDay;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScheduleRequest;
use App\Http\Resources\Admin\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Throwable;

class ScheduleController extends Controller
{
    public function index(): Response
    {
        $schedule = Schedule::query()
            ->select(['schedules.id', 'schedules.academic_year_id', 'schedules.start_time', 'schedules.end_time', 'schedules.date', 'schedules.quota', 'schedules.created_at'])
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->with(['academicYear'])
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

    public function create(): Response
    {
        return inertia('Admin/Schedules/Create', [
            'page_settings' => [
                'title' => 'Tambah Jadwal',
                'subtitle' => 'Buat jadwal baru disini, Klik simpan setelah selesai.',
                'method' => 'POST',
                'action' => route('admin.schedules.store'),
            ]
        ]);
    }

    public function store(ScheduleRequest $request): RedirectResponse
    {
        try {
            $academicYearId = optional(activeAcademicYear())->id;
            if (!$academicYearId) {
                flashMessage(MessageType::ERROR->message('Tahun akademik tidak ditemukan. Pastikan tahun akademik aktif sudah diatur.'), 'error');
                return redirect()->back()->withInput();
            }

            Schedule::create([
                'academic_year_id' => $academicYearId,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date' => $request->date,
                'quota' => $request->quota,
            ]);

            flashMessage(MessageType::CREATED->message('Jadwal'));
            return to_route('admin.schedules.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.schedules.index');
        }
    }

    public function edit(Schedule $schedule): Response
    {
        return inertia('Admin/Schedules/Edit', [
            'page_settings' => [
                'title' => 'Edit Jadwal',
                'subtitle' => 'Edit jadwal disini, Klik simpan setelah selesai.',
                'method' => 'PUT',
                'action' => route('admin.schedules.update', $schedule),
            ],
            'schedule' => $schedule,
            'days' => ScheduleDay::options(),
        ]);
    }

    public function update(Schedule $schedule, ScheduleRequest $request): RedirectResponse
    {
        try {
            $schedule->update([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date' => $request->date,
                'quota' => $request->quota,
            ]);

            flashMessage(MessageType::UPDATED->message('Jadwal'));
            return to_route('admin.schedules.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.schedules.index');
        }
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        try {
            $schedule->delete();
            flashMessage(MessageType::DELETED->message('Jadwal'));
            return to_route('admin.schedules.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.schedules.index');
        }
    }
}
