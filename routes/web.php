<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\TicketController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TicketDetailController;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('tickets', TicketController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('ticket-details', TicketDetailController::class);
    Route::resource('user-profiles', UserProfileController::class);
});
