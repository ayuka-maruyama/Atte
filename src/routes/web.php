<?php

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\WorktimeController;
use App\Http\Controllers\BreaktimeController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/confirm', function () {
    return view('confirm');
})->name('confirm');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware('auth')->group(function () {
    Route::get('/', [WorktimeController::class, 'todayWorkStart'])->name('todayWorkStart');
    Route::post('/startwork', [WorktimeController::class, 'startWork'])->name('starttime');
    Route::post('/endwork', [WorktimeController::class, 'endWork'])->name('endtime');
    Route::post('/breakstart', [BreaktimeController::class, 'breakStart'])->name('breakStart');
    Route::post('/breakend', [BreaktimeController::class, 'breakEnd'])->name('breakEnd');
    Route::get('/attendance', [AttendanceController::class, 'attendance'])->name('attendance');
});
