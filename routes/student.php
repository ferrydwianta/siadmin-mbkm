<?php

use App\Http\Controllers\Student\DashboardStudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('students')->middleware(['auth', 'role:Student'])->group(function(){
    Route::get('dashboard', DashboardStudentController::class)->name('students.dashboard');
});