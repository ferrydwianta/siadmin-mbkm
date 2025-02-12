<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PartnerController;
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
});