<?php

use App\Http\Controllers\Student\ActivityStudentController;
use App\Http\Controllers\Student\ActivityRegistrationStudentController;
use App\Http\Controllers\Student\DashboardStudentController;
use App\Http\Controllers\Student\RequestActivityStudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('students')->middleware(['auth', 'role:Student'])->group(function(){
    Route::get('dashboard', DashboardStudentController::class)->name('students.dashboard');

    Route::controller(ActivityRegistrationStudentController::class)->group(function(){
        Route::get('activity-registrations', 'index')->name('students.activity-registrations.index');
        Route::get('activity-registrations/create/{activity:slug}', 'create')->name('students.activity-registrations.create')->middleware('checkActiveAcademicYear');
        Route::post('activity-registrations/create/{activity:slug}', 'store')->name('students.activity-registrations.store');
        Route::get('activity-registrations/detail/{activityRegistration}', 'show')->name('students.activity-registrations.show');
    });

    Route::controller(ActivityStudentController::class)->group(function(){
        Route::get('activities', 'index')->name('students.activities.index');
        Route::get('activities/detail/{activity}', 'show')->name('students.activities.show');
    });

    Route::controller(RequestActivityStudentController::class)->group(function(){
        Route::get('request-activities/create', 'create')->name('students.request-activities.create');
        Route::post('request-activities/create', 'store')->name('students.request-activities.store');
        Route::get('request-activities/create-partner', 'createPartner')->name('students.request-activities.create-partner');
        Route::post('request-activities/create-partner', 'storePartner')->name('students.request-activities.store-partner');
        Route::get('request-activities/history', 'history')->name('students.request-activities.history');
    });
});