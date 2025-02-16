<?php

use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\RoleController;
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
});