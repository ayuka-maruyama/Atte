<?php

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\WorktimeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

// GETメソッドでログイン画面を表示
Route::get('/login', function () {
    return view('auth.login'); // ログインビューを表示
});

// POSTメソッドでログイン処理を実行
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware('auth')->group(function () {
    Route::get('/', [WorktimeController::class, 'todayWorkStart'])->name('todayWorkStart');
    Route::post('/', [WorktimeController::class, 'startWork'])->name('starttime');
});
