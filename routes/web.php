<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/student', [App\Http\Controllers\DashboardController::class, 'studentDashboard'])->name('dashboard.student');
    Route::get('/dashboard/teacher', [App\Http\Controllers\DashboardController::class, 'teacherDashboard'])->name('dashboard.teacher');
    Route::get('/dashboard/company', [App\Http\Controllers\DashboardController::class, 'companyDashboard'])->name('dashboard.company');

    // Routes stages (internships)
    Route::resource('internships', App\Http\Controllers\InternshipController::class);
    // Routes candidatures (applications)
    Route::resource('applications', App\Http\Controllers\ApplicationController::class);
    Route::put('applications/{application}/status', [App\Http\Controllers\ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');

    // Routes conventions
    Route::get('conventions', [App\Http\Controllers\ConventionController::class, 'index'])->name('conventions.index');
    Route::get('conventions/{id}', [App\Http\Controllers\ConventionController::class, 'show'])->name('conventions.show');
    Route::post('conventions/{id}/validate', [App\Http\Controllers\ConventionController::class, 'validate'])->name('conventions.validate');
    Route::post('conventions/{id}/reject', [App\Http\Controllers\ConventionController::class, 'reject'])->name('conventions.reject');
    Route::post('conventions/generate', [App\Http\Controllers\ConventionController::class, 'generate'])->name('conventions.generate');
});
