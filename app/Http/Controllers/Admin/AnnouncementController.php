<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnnouncementRequest;
use App\Http\Resources\Admin\AnnouncementResource;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Throwable;

class AnnouncementController extends Controller
{
    public function index(): Response
    {
        $announcements = Announcement::query()
            ->select(['id', 'title', 'description', 'created_at'])
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->paginate(request()->load ?? 10);

        return inertia('Admin/Announcements/Index', [
            'page_settings' => [
                'title' => 'Pengumuman',
                'subtitle' => 'Menampilkan semua pengumuman yang telah dibuat'
            ],

            'announcements' => AnnouncementResource::collection($announcements)->additional([
                'meta' => [
                    'has_pages' => $announcements->hasPages(),
                ],
            ]),

            'state' => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => 10,
            ]
        ]);
    }

    public function create(): Response 
    {
        return inertia('Admin/Announcements/Create', [
            'page_settings' => [
                'title' => 'Tambah Pengumuman',
                'subtitle' => 'Tambahkan Pengumuman baru. Klik simpan setelah selesai!',
                'method' => 'POST',
                'action' => route('admin.announcements.store'),
            ]
        ]);
    }

    public function store(AnnouncementRequest $request): RedirectResponse 
    {
        try {
            Announcement::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            flashMessage(MessageType::CREATED->message('Pengumuman'));
            return to_route('admin.announcements.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.announcements.index');
        }
    }

    public function edit(Announcement $announcement): Response 
    {
        return inertia('Admin/Announcements/Edit', [
            'page_settings' => [
                'title' => 'Edit Pengumuman',
                'subtitle' => 'Edit Data Pengumuman. Klik simpan setelah selesai!',
                'method' => 'PUT',
                'action' => route('admin.announcements.update', $announcement),
            ],
            'announcement' => $announcement,
        ]);
    }

    public function update(Announcement $announcement, AnnouncementRequest $request): RedirectResponse 
    {
        try {
            $announcement->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            flashMessage(MessageType::UPDATED->message('Pengumuman'));
            return to_route('admin.announcements.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.announcements.index');
        }
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        try {
            $announcement->delete();
            flashMessage(MessageType::DELETED->message('Pengumuman'));
            return to_route('admin.announcements.index');
        } catch(Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.announcements.index');
        }
    }
}
