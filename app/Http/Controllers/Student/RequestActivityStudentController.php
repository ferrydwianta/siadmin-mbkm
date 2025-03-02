<?php

namespace App\Http\Controllers\Student;

use App\Enums\ActivityType;
use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ActivityStudentRequest;
use App\Http\Requests\Student\PartnerStudentRequest;
use App\Http\Resources\Admin\ActivityResource;
use App\Http\Resources\Student\ActivityStudentResource;
use App\Models\Activity;
use App\Models\Partner;
use App\Traits\HasFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Throwable;

class RequestActivityStudentController extends Controller
{   
    use HasFile;
    public function create(): Response | RedirectResponse
    {

        return inertia('Students/RequestActivities/Create', [
            'page_settings' => [
                'title' => 'Pengajuan Kegiatan MBKM',
                'subtitle' => 'Tambah Kegiatan MBKM yang Belum Terdaftar di Sistem!',
                'method' => 'POST',
                'action' => route('students.request-activities.store')
            ],
            'types' => ActivityType::options(),
            'partners' => Partner::query()->select('id', 'name')->orderBy('name')->get()->map(fn($item) => [
                'value' => $item->id,
                'label' => $item->name, 
            ]),
        ]);
    }

    public function store(ActivityStudentRequest $request): RedirectResponse
    {
        try {
            $activity = Activity::create([
                'partner_id' => $request->partner_id,
                'student_id' => auth()->user()->student->id,
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'document' => $this->upload_file($request, 'document', 'activities'),
            ]);

            flashMessage('Berhasil mengajukan kegiatan MBKM, harap tunggu verifikasi admin!');
            return to_route('students.request-activities.history');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('students.request-activities.history');
        }
    }

    public function createPartner(): Response
    {
        return inertia('Students/RequestActivities/CreatePartner', [
            'page_settings' => [
                'title' => 'Tambah Mitra MBKM',
                'subtitle' => 'Tambahkan Data Mitra MBKM baru. Klik simpan setelah selesai!',
                'method' => 'POST',
                'action' => route('students.request-activities.store-partner'),
            ]
        ]);
    }

    public function storePartner(PartnerStudentRequest $request): RedirectResponse 
    {
        try {
            Partner::create([
                'name' => $request->name,
                'description' => $request->description,
                'logo' => $this->upload_file($request, 'logo', 'partners'),
                'address' => $request->address,
                'contact' => $request->contact,
            ]);

            flashMessage(MessageType::CREATED->message('Mitra MBKM'));
            return to_route('students.request-activities.create');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('students.request-activities.create');
        }
    }

    public function history(): Response
    {
        $activities = Activity::query()
            ->select(['activities.id', 'activities.partner_id', 'activities.student_id', 'activities.name', 'activities.description', 'activities.type', 'activities.slug', 'activities.status', 'activities.document', 'activities.created_at'])
            ->where('student_id', auth()->user()->student->id)
            ->with('partner')
            ->paginate(request()->load ?? 10);
        
        return inertia('Students/RequestActivities/History', [
            'page_settings' => [
                'title' => 'Riwayat Pengajuan',
                'subtitle' => 'Menampilkan semua riwayat pengajuan kegiatan MBKM.'
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
