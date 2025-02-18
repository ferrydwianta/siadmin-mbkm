<?php

use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\LecturerController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'role:Admin'])->group(function(){
    Route::get('dashboard', DashboardAdminController::class)->name('admin.dashboard');

    Route::controller(PartnerController::class)->group(function(){
        Route::get('partners', 'index')->name('admin.partners.index');
        Route::get('partners/create', 'create')->name('admin.partners.create');
        Route::post('partners/create', 'store')->name('admin.partners.store');
        Route::get('partners/edit/{partner:slug}', 'edit')->name('admin.partners.edit');
        Route::put('partners/edit/{partner:slug}', 'update')->name('admin.partners.update');
        Route::delete('partners/destroy/{partner:slug}', 'destroy')->name('admin.partners.destroy');
    });
    
    Route::controller(ActivityController::class)->group(function(){
        Route::get('activities', 'index')->name('admin.activities.index');
        Route::get('activities/create', 'create')->name('admin.activities.create');
        Route::post('activities/create', 'store')->name('admin.activities.store');
        Route::get('activities/edit/{activity:slug}', 'edit')->name('admin.activities.edit');
        Route::put('activities/edit/{activity:slug}', 'update')->name('admin.activities.update');
        Route::delete('activities/destroy/{activity:slug}', 'destroy')->name('admin.activities.destroy');
    });

    Route::controller(AcademicYearController::class)->group(function(){
        Route::get('academic-years', 'index')->name('admin.academic-years.index');
        Route::get('academic-years/create', 'create')->name('admin.academic-years.create');
        Route::post('academic-years/create', 'store')->name('admin.academic-years.store');
        Route::get('academic-years/edit/{academicYear:slug}', 'edit')->name('admin.academic-years.edit');
        Route::put('academic-years/edit/{academicYear:slug}', 'update')->name('admin.academic-years.update');
        Route::delete('academic-years/destroy/{academicYear:slug}', 'destroy')->name('admin.academic-years.destroy');
    });

    Route::controller(RoleController::class)->group(function(){
        Route::get('roles', 'index')->name('admin.roles.index');
        Route::get('roles/create', 'create')->name('admin.roles.create');
        Route::post('roles/create', 'store')->name('admin.roles.store');
        Route::get('roles/edit/{role}', 'edit')->name('admin.roles.edit');
        Route::put('roles/edit/{role}', 'update')->name('admin.roles.update');
        Route::delete('roles/destroy/{role}', 'destroy')->name('admin.roles.destroy');
    });

    Route::controller(StudentController::class)->group(function(){
        Route::get('students', 'index')->name('admin.students.index');
        Route::get('students/create', 'create')->name('admin.students.create');
        Route::post('students/create', 'store')->name('admin.students.store');
        Route::get('students/edit/{student:student_number}', 'edit')->name('admin.students.edit');
        Route::put('students/edit/{student:student_number}', 'update')->name('admin.students.update');
        Route::delete('students/destroy/{student:student_number}', 'destroy')->name('admin.students.destroy');
    });

    Route::controller(StudentController::class)->group(function(){
        Route::get('students', 'index')->name('admin.students.index');
        Route::get('students/create', 'create')->name('admin.students.create');
        Route::post('students/create', 'store')->name('admin.students.store');
        Route::get('students/edit/{student:student_number}', 'edit')->name('admin.students.edit');
        Route::put('students/edit/{student:student_number}', 'update')->name('admin.students.update');
        Route::delete('students/destroy/{student:student_number}', 'destroy')->name('admin.students.destroy');
    });

    Route::controller(LecturerController::class)->group(function(){
        Route::get('lecturers', 'index')->name('admin.lecturers.index');
        Route::get('lecturers/create', 'create')->name('admin.lecturers.create');
        Route::post('lecturers/create', 'store')->name('admin.lecturers.store');
        Route::get('lecturers/edit/{lecturer:lecturer_number}', 'edit')->name('admin.lecturers.edit');
        Route::put('lecturers/edit/{lecturer:lecturer_number}', 'update')->name('admin.lecturers.update');
        Route::delete('lecturers/destroy/{lecturer:lecturer_number}', 'destroy')->name('admin.lecturers.destroy');
    });

    Route::controller(CourseController::class)->group(function(){
        Route::get('courses', 'index')->name('admin.courses.index');
        Route::get('courses/create', 'create')->name('admin.courses.create');
        Route::post('courses/create', 'store')->name('admin.courses.store');
        Route::get('courses/edit/{course:code}', 'edit')->name('admin.courses.edit');
        Route::put('courses/edit/{course:code}', 'update')->name('admin.courses.update');
        Route::delete('courses/destroy/{course:code}', 'destroy')->name('admin.courses.destroy');
    });

    Route::controller(ScheduleController::class)->group(function(){
        Route::get('schedules', 'index')->name('admin.schedules.index');
        Route::get('schedules/create', 'create')->name('admin.schedules.create');
        Route::post('schedules/create', 'store')->name('admin.schedules.store');
        Route::get('schedules/edit/{schedule}', 'edit')->name('admin.schedules.edit');
        Route::put('schedules/edit/{schedule}', 'update')->name('admin.schedules.update');
        Route::delete('schedules/destroy/{schedule}', 'destroy')->name('admin.schedules.destroy');
    });
});