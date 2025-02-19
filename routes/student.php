<?php

use App\Http\Controllers\Student\ActivityRegistrationStudentController;
use App\Http\Controllers\Student\DashboardStudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('students')->middleware(['auth', 'role:Student'])->group(function(){
    Route::get('dashboard', DashboardStudentController::class)->name('students.dashboard');

    Route::controller(ActivityRegistrationStudentController::class)->group(function(){
        Route::get('activity-registrations', 'index')->name('students.activity-registrations.index');
        Route::get('activity-registrations/create', 'create')->name('students.activity-registrations.create');
        Route::post('activity-registrations/create', 'store')->name('students.activity-registrations.store');
        Route::get('activity-registrations/detail/{activityRegistration}', 'show')->name('students.activity-registrations.show');
    });
});