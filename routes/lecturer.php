<?php

use App\Http\Controllers\Lecturer\ActivityLecturerController;
use App\Http\Controllers\Lecturer\DashboardLecturerController;
use App\Http\Controllers\Lecturer\StudentLecturerController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::prefix('lecturers')->middleware(['auth', 'role:Lecturer'])->group(function(){
    Route::get('dashboard', DashboardLecturerController::class)->name('lecturers.dashboard');

    Route::controller(StudentLecturerController::class)->group(function(){
        Route::get('students', 'index')->name('lecturers.students.index');
        Route::get('students/create', 'create')->name('lecturers.students.create');
        Route::post('students/create', 'store')->name('lecturers.students.store');
        Route::get('students/edit/{student:student_number}', 'edit')->name('lecturers.students.edit');
        Route::put('students/edit/{student:student_number}', 'update')->name('lecturers.students.update');
        Route::delete('students/destroy/{student:student_number}', 'destroy')->name('lecturers.students.destroy');
    });

    Route::controller(ActivityLecturerController::class)->group(function(){
        Route::get('activities', 'index')->name('lecturers.activities.index');
    });
});