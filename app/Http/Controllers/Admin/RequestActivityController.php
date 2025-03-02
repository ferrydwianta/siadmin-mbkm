<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Enums\StudentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RequestActivityRequest;
use App\Http\Resources\Admin\ActivityResource;
use App\Models\Activity;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Throwable;

class RequestActivityController extends Controller
{
    public function index(): Response
    {
        $activities = Activity::query()
            ->select(['activities.id', 'activities.partner_id', 'activities.student_id', 'activities.name', 'activities.description', 'activities.type', 'activities.status', 'activities.document', 'activities.slug', 'activities.created_at'])
            ->whereNotNull('student_id')
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->with('partner', 'courses', 'student')
            ->latest('created_at')
            ->paginate(request()->load ?? 10);
        
        return inertia('Admin/RequestActivities/Index', [
            'page_settings' => [
                'title' => 'Pengajuan Kegiatan MBKM',
                'subtitle' => 'Menampilkan semua pengajuan kegiatan MBKM yang diajukan mahasiswa'
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
            'statuses' => StudentStatus::options(),
            'courses' => Course::query()->select('id', 'name', 'credit')->orderBy('name')->get()->map(fn($course) => [
                'value' => $course->id,
                'label' => $course->name,
                'credit' => $course->credit
            ]),
        ]);
    }

    public function approve(Activity $activity, RequestActivityRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $activity->update([
                'status' => $request->status,
            ]);

            if ($request->has('courses')) {
                $activity->courses()->sync($request->courses);
            }

            DB::commit();

            match ($activity->status) {
                StudentStatus::REJECT->value => flashMessage('Pengajuan Kegiatan MBKM berhasil ditolak', 'error'),
                StudentStatus::APPROVED->value => flashMessage('Pengajuan Kegiatan MBKM berhasil diterima'),
                default => flashMessage('Berhasil merubah status menjadi Pending!', 'warning')
            };
            return to_route('admin.request-activities.index');
        } catch (Throwable $e) {
            DB::rollBack();
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.request-activities.index');
        }
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        try {
            $activity->delete();
            flashMessage(MessageType::DELETED->message('Pengajuan Kegiatan MBKM'));
            return to_route('admin.request-activities.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.request-activities.index');
        }
    }
}
