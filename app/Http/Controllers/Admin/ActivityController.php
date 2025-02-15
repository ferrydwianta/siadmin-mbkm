<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ActivityRequest;
use App\Http\Resources\Admin\ActivityResource;
use App\Models\Activity;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Throwable;

class ActivityController extends Controller
{
    public function index(): Response
    {
        $activities = Activity::query()
            ->select(['id', 'partner_id', 'name', 'description', 'slug', 'created_at'])
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->with('partner')
            ->paginate(request()->load ?? 10);
        
        return inertia('Admin/Activities/Index', [
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

    public function create(): Response
    {
        return inertia('Admin/Activities/Create', [
            'page_settings' => [
                'title' => 'Tambah Kegiatan MBKM',
                'subtitle' => 'Buat kegiatan MBKM baru. Klik simpan setelah selesai!',
                'method' => 'POST',
                'action' => route('admin.activities.store'),
            ],

            'partners' => Partner::query()->select('id', 'name')->orderBy('name')->get()->map(fn($item) => [
                'value' => $item->id,
                'label' => $item->name, 
            ]),
        ]);
    }

    public function store(ActivityRequest $request): RedirectResponse
    {
        try {
            Activity::create([
                'partner_id' => $request->partner_id,
                'name' => $request->name,
                'description' => $request->description,
            ]);
            flashMessage(MessageType::CREATED->message('Kegiatan MBKM'));
            return to_route('admin.activities.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.activities.index');
        }
    }

    public function edit(Activity $activity): Response
    {
        return inertia('Admin/Activities/Edit', [
            'page_settings' => [
                'title' => 'Edit Kegiatan MBKM',
                'subtitle' => 'Edit Kegiatan MBKM, klik simpan setelah selesai!',
                'method' => 'PUT',
                'action' => route('admin.activities.update', $activity),
            ],
            'activity' => $activity,
            'partners' => Partner::query()->select('id', 'name')->orderBy('name')->get()->map(fn($item) => [
                'value' => $item->id,
                'label' => $item->name, 
            ]),
        ]);
    }

    public function update(Activity $activity, ActivityRequest $request): RedirectResponse
    {
        try {
            $activity->update([
                'partner_id' => $request->partner_id,
                'name' => $request->name,
                'description' => $request->description,
            ]);
            flashMessage(MessageType::UPDATED->message('Kegiatan MBKM'));
            return to_route('admin.activities.index');
        } catch(Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.activities.index');
        }
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        try {
            $activity->delete();
            flashMessage(MessageType::DELETED->message('Kegiatan MBKM'));
            return to_route('admin.activities.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.activities.index');
        }
    }
}
