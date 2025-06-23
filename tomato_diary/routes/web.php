<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
// 閲覧者用ルート
Route::get('/public', [DiaryController::class, 'publicIndex'])->name('diary.public.index');

Route::get('/top', [DiaryController::class, 'index'])->name('diary.index');
Route::get('/diary/create', [DiaryController::class, 'create'])->name('diary.create');
Route::post('/diary', [DiaryController::class, 'store'])->name('diary.store');
Route::get('/diary/{diary}', [DiaryController::class, 'show'])->name('diary.show');
Route::get('/diary/{diary}/edit', [DiaryController::class, 'edit'])->name('diary.edit');
Route::put('/diary/{diary}', [DiaryController::class, 'update'])->name('diary.update');
Route::delete('/diary/{diary}', [DiaryController::class, 'destroy'])->name('diary.destroy');

// ダッシュボードのルート


// 管理者用ルート
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminController::class, 'login']);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
});

//仕様書ルート
Route::get('/specifications', [App\Http\Controllers\SpecificationController::class, 'index'])->name('specifications.index');
Route::get('/specifications/{filename}', [App\Http\Controllers\SpecificationController::class, 'showPdf'])->name('specifications.showPdf');
