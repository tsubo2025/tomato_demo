<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AdminAuthController;
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
Route::get('/diary/{diary}/edit', [DiaryController::class, 'edit'])->name('diary.edit');
Route::put('/diary/{diary}', [DiaryController::class, 'update'])->name('diary.update');
Route::delete('/diary/{diary}', [DiaryController::class, 'destroy'])->name('diary.destroy');

// ダッシュボードのルート




// 管理者用ルート
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // 設定関連のルート
    Route::get('settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('settings/pdf', [SettingController::class, 'updatePdf'])->name('admin.settings.pdf');
    Route::post('settings/wallpaper', [SettingController::class, 'updateWallpaper'])->name('admin.settings.wallpaper');
    Route::post('settings/theme', [SettingController::class, 'updateTheme'])->name('admin.settings.theme');
});

//仕様書ルート
Route::get('/specifications', [App\Http\Controllers\SpecificationController::class, 'index'])->name('specifications.index');
Route::get('/specifications/{filename}', [App\Http\Controllers\SpecificationController::class, 'showPdf'])->name('specifications.showPdf');

//カレンダーのルート
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard'); // 既存のダッシュボードルート
Route::get('/diary/{diary}', [DiaryController::class, 'show'])->name('diary.show');
