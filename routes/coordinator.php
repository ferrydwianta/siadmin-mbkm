<?php

use App\Http\Controllers\Coordinator\DashboardCoordinatorController;
use Illuminate\Support\Facades\Route;

Route::prefix('coordinators')->group(function(){
    Route::get('dashboard', DashboardCoordinatorController::class)->name('coordinators.dashboard');
});