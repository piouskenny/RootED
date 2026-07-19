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
    Route::get('/instructor/courses/{course}', [CourseController::class, 'show'])->name('instructor.courses.show');
    Route::post('/instructor/courses/{course}/toggle-status', [CourseController::class, 'toggleStatus'])->name('instructor.courses.toggle-status');

    Route::get('/instructor/content/create', [CourseContentController::class, 'create'])->name('instructor.content.create');
    Route::post('/instructor/content', [CourseContentController::class, 'store'])->name('instructor.content.store');
    Route::post('/instructor/courses/{course}/modules', [CourseContentController::class, 'storeModule'])->name('instructor.courses.modules.store');

    // Learner Course Routes
    Route::get('/courses/{course}', [\App\Http\Controllers\LearnerCourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{course}/enroll', [\App\Http\Controllers\LearnerCourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{course}/modules/{content}/toggle', [\App\Http\Controllers\LearnerCourseController::class, 'toggleModule'])->name('courses.modules.toggle');
});

Route::get('/users/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/users/login', [AuthController::class, 'login']);

Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

Route::get('/users/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/users/register', [AuthController::class, 'register']);

Route::post('/users/logout', [AuthController::class, 'logout'])->name('logout');
