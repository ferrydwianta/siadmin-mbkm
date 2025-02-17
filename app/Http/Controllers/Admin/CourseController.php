<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Http\Resources\Admin\CourseResource;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Throwable;

class CourseController extends Controller
{
    public function index(): Response
    {
        $courses = Course::query()
            ->select(['courses.id', 'courses.name', 'courses.credit', 'courses.code', 'courses.semester', 'courses.created_at'])
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->paginate(request()->load ?? 10);

        return inertia('Admin/Courses/Index', [
            'page_settings' => [
                'title' => 'Mata Kuliah',
                'subtitle' => 'Menampilkan data mata kuliah yang terdaftar',
            ],
            'courses' => CourseResource::collection($courses)->additional([
                'meta' => [
                    'has_pages' => $courses->hasPages(),
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
        return inertia('Admin/Courses/Create', [
            'page_settings' => [
                'title' => 'Tambah data mata kuiah',
                'subtitle' => 'Buat mata kuliah baru, klik simpan setelah selesai!',
                'method' => 'POST',
                'action' => route('admin.courses.store'),
            ]
        ]);
    }

    public function store(CourseRequest $request): RedirectResponse
    {
        try {
            Course::create([
                'code' => $request->code,
                'name' => $request->name,
                'credit' => $request->credit,
                'semester' => $request->semester,
            ]);

            flashMessage(MessageType::CREATED->message('Mata Kuliah'));
            return to_route('admin.courses.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.courses.index');
        }
    }

    public function edit(Course $course): Response
    {
        return inertia('Admin/Courses/Edit', [
            'page_settings' => [
                'title' => 'Edit data mata kuiah',
                'subtitle' => 'Edit mata kuliah, klik simpan setelah selesai!',
                'method' => 'PUT',
                'action' => route('admin.courses.update', $course),
            ],
            'course' => $course,
        ]);
    }

    public function update(Course $course, CourseRequest $request): RedirectResponse
    {
        try {
            $course->update([
                'code' => $request->code,
                'name' => $request->name,
                'credit' => $request->credit,
                'semester' => $request->semester,
            ]);

            flashMessage(MessageType::UPDATED->message('Mata Kuliah'));
            return to_route('admin.courses.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.courses.index');
        }
    }

    public function destroy(Course $course): RedirectResponse
    {
        try {
            $course->delete();
            flashMessage(MessageType::DELETED->message('Mata Kuliah'));
            return to_route('admin.courses.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.courses.index');
        }
    }
}
