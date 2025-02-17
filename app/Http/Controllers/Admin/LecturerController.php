<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LecturerRequest;
use App\Http\Resources\Admin\LecturerResource;
use App\Models\Lecturer;
use App\Models\User;
use App\Traits\HasFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Response;
use Throwable;

class LecturerController extends Controller
{
    use HasFile;

    public function index(): Response
    {
        $lecturers = Lecturer::query()
            ->select(['lecturers.id', 'lecturers.user_id', 'lecturers.lecturer_number', 'lecturers.academic_title', 'lecturers.created_at'])
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->with(['user'])
            ->whereHas('user', function($query) {
                $query->whereHas('roles', fn($query) => $query->where('name', 'Lecturer'));
            })
            ->paginate(request()-> load ?? 10);

        return inertia('Admin/Lecturers/Index', [
            'page_settings' => [
                'title' => 'Dosen',
                'subtitle' => 'Menampilkan data dosen yang tersedia.'
            ],
            'lecturers' => LecturerResource::collection($lecturers)->additional([
                'meta' => [
                    'has_pages' => $lecturers->hasPages(),
                ]
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
        return inertia('Admin/Lecturers/Create', [
            'page_settings' => [
                'title' => 'Tambah Dosen',
                'subtitle' => 'Buat dosen baru. Klik simpan setelah selesai!',
                'method' => 'POST',
                'action' => route('admin.lecturers.store'),
            ],
        ]);
    }

    public function store(LecturerRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'avatar' => $this->upload_file($request, 'avatar', 'users'),
            ]);

            $user->lecturer()->create([
                'lecturer_number' => $request->lecturer_number,
                'academic_title' => $request->academic_title,
            ]);

            $user->assignRole('Lecturer');

            DB::commit();

            flashMessage(MessageType::CREATED->message('Dosen'));
            return to_route('admin.lecturers.index');
        } catch (Throwable $e) {
            DB::rollBack();
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.lecturers.index');
        }
    }

    public function edit(Lecturer $lecturer): Response
    {
        return inertia('Admin/Lecturers/Edit', [
            'page_settings' => [
                'title' => 'Edit Dosen',
                'subtitle' => 'Edit dosen disini. Klik simpan setelah selesai!',
                'method' => 'PUT',
                'action' => route('admin.lecturers.update', $lecturer),
            ],

            'lecturer' => $lecturer->load('user'),
        ]);
    }

    public function update(Lecturer $lecturer, LecturerRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $lecturer->update([
                'lecturer_number' => $request->lecturer_number,
                'academic_title' => $request->academic_title,
            ]);

            $lecturer->user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $lecturer->user->password,
                'avatar' => $this->update_file($request, $lecturer->user, 'avatar', 'users'),
            ]);

            DB::commit();

            flashMessage(MessageType::UPDATED->message('Dosen'));
            return to_route('admin.lecturers.index');
        } catch (Throwable $e) {
            DB::rollBack();
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.lecturers.index');
        }
    }

    public function destroy(Lecturer $lecturer): RedirectResponse
    {
        try {
            $this->delete_file($lecturer->user, 'avatar');
            $lecturer->delete();

            flashMessage(MessageType::DELETED->message('Dosen'));
            return to_route('admin.lecturers.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.lecturers.index');
        }
    }
}
