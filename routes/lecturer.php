<?php

use App\Http\Controllers\Lecturer\DashboardLecturerController;
use Illuminate\Support\Facades\Route;

Route::prefix('lecturers')->group(function(){
    Route::get('dashboard', DashboardLecturerController::class)->name('lecturers.dashboard');
});