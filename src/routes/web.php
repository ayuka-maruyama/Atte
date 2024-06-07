<?php

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\WorktimeController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware('auth')->group(function () {
    Route::get('/', [WorktimeController::class, 'todayWorkStart'])->name('todayWorkStart');
    Route::post('/startwork', [WorktimeController::class, 'startWork'])->name('starttime');
    Route::post('/endwork', [WorktimeController::class, 'endWork'])->name('endtime');
});
