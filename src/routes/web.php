<?php

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\WorktimeController;
use App\Http\Controllers\BreaktimeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserdateController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/verify', function () {
    return view('auth.verify-email');
})->name('verify');

Route::middleware(['signed', 'throttle:6,1'])->group(function () {
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify');
    Route::get('/', [WorktimeController::class, 'todayWorkStart'])->name('todayWorkStart');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [WorktimeController::class, 'todayWorkStart'])->name('todayWorkStart');
    Route::post('/startwork', [WorktimeController::class, 'startWork'])->name('starttime');
    Route::post('/endwork', [WorktimeController::class, 'endWork'])->name('endtime');
    Route::post('/breakstart', [BreaktimeController::class, 'breakStart'])->name('breakStart');
    Route::post('/breakend', [BreaktimeController::class, 'breakEnd'])->name('breakEnd');
    Route::get('/attendance', [AttendanceController::class, 'attendance'])->name('attendance');
    Route::get('/users', [UserdateController::class, 'open'])->name('usersdate');
    Route::get('/worktime', [UserdateController::class, 'details'])->name('userWorkTime');
});

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('resent', true);
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
