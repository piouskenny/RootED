<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\CourseContentController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Instructor Routes
    Route::get('/instructor/courses/create', [CourseController::class, 'create'])->name('instructor.courses.create');
    Route::post('/instructor/courses', [CourseController::class, 'store'])->name('instructor.courses.store');
    
    Route::get('/instructor/content/create', [CourseContentController::class, 'create'])->name('instructor.content.create');
    Route::post('/instructor/content', [CourseContentController::class, 'store'])->name('instructor.content.store');
});

Route::get('/users/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/users/login', [AuthController::class, 'login']);

Route::get('/users/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/users/register', [AuthController::class, 'register']);

Route::post('/users/logout', [AuthController::class, 'logout'])->name('logout');
