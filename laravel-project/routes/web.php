<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginWithGoogleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/google', [LoginWithGoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [LoginWithGoogleController::class, 'authGoogleCallback']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    // Route::get('/',[AttendanceController::class, 'index']);
    // Route::post('/',[AttendanceController::class, 'store']);

    // Route::get('/teacher/attendance', [AttendanceController::class, 'show']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/',[AttendanceController::class, 'index']);
Route::post('/',[AttendanceController::class, 'store']);

Route::get('/teacher/attendance', [AttendanceController::class, 'show']);
Route::get('/teacher/id', [TeacherController::class, 'unique_id']);

// ミドルウェアの外にルートの情報を記述するとHeroku上でも問題なく表示される
// やはり、Googleログイン認証が問題？
// teacher/attendanceでデータベースからデータを取得できた
// となると、500エラーの原因は、Googleログイン認証とJqueryからデータをバックエンドに渡せていないこと