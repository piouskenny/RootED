<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/users/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/users/login', [AuthController::class, 'login']);

Route::get('/users/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/users/register', [AuthController::class, 'register']);

Route::post('/users/logout', [AuthController::class, 'logout'])->name('logout');
