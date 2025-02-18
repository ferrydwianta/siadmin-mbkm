<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Lecturers\StudentLecturerResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Response;

class StudentLecturerController extends Controller
{
    public function index(): Response
    {
        $students = Student::query()
            ->select('students.id', 'students.user_id', 'students.semester', 'students.batch', 'students.created_at', 'students.student_number')
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->with(['user'])
            ->whereHas('user', function($query){
                $query->whereHas('roles', fn($query) => $query->where('name', 'Student'));
            })
            ->paginate(request()->load ?? 10);
        
        return inertia('Lecturers/Students/Index', [
            'page_settings' => [
                'title' => 'Mahasiswa',
                'subtitle' => 'Menampilkan semua mahasiswa yang terdaftar.'
            ],
            'students' => StudentLecturerResource::collection($students)->additional([
                'meta' => [
                    'has_pages' => $students->hasPages(),
                ]
            ]),
            'state' => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => 10
            ],
        ]);
    }
}
