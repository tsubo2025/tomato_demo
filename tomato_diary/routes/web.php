<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryController;

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

Route::get('/', [DiaryController::class, 'index'])->name('diary.index');
Route::get('/diary/create', [DiaryController::class, 'create'])->name('diary.create');
Route::post('/diary', [DiaryController::class, 'store'])->name('diary.store');
Route::get('/diary/{diary}', [DiaryController::class, 'show'])->name('diary.show');
Route::get('/diary/{diary}/edit', [DiaryController::class, 'edit'])->name('diary.edit');
Route::put('/diary/{diary}', [DiaryController::class, 'update'])->name('diary.update');
Route::delete('/diary/{diary}', [DiaryController::class, 'destroy'])->name('diary.destroy');



