<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;

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



Route::get('/', function () {
    return view('landing-page');
});
// Route::middleware('guest')->group(function () {
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/postLogin', [AuthController::class, 'postLogin'])->name('postLogin');
// });

Route::middleware('auth')->group(function () {

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::prefix('/reports')->name('report.')->group(function () {
        Route::get('/article', [ReportController::class, 'index'])->name('index');
        Route::post('/comments', [ReportController::class, 'storeComment'])->name('storeComment');
        Route::get('/index/{id}', [ReportController::class, 'indexCommet'])->name('indexComment');
        // Route::get('/{id}', [ReportController::class, 'detail'])->name('detail');
        Route::get('/{id}', [ReportController::class, 'detail'])->name('detail');
        Route::get('/me/proses', [ReportController::class, 'me'])->name('me');
        Route::get('/create/form', [ReportController::class, 'create'])->name('create');
        Route::post('/store', [ReportController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [ReportController::class, 'delete'])->name('delete');
        Route::get('/prosess', [ReportController::class, 'prosess'])->name('proses.data');
        Route::post('/{id}/vote', [ReportController::class, 'vote'])->name('vote');
        Route::delete('/delete/{id}', [ReportController::class, 'delete'])->name('delete');
    });

    Route::view('/dashboard', 'user.dashboard');

    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::post('/reset/{id}', [UserController::class, 'reset'])->name('reset');
    });

    Route::prefix('response')->name('response.')->group(function () {
        Route::get('/report', [ResponseController::class, 'index'])->name('index');
        Route::get('/report/export', [ResponseController::class, 'exportExcel'])->name('exportExcel');
        Route::get('/report/export-by-date', [ResponseController::class, 'exportByDate'])->name('exportByDate');
        Route::get('/report/progres/{id}', [ResponseController::class, 'progres'])->name('progres');
        Route::post('/report/{id}/store', [ResponseController::class, 'store'])->name('store'); // Ubah ini
        Route::post('/report/progres/{id}', [ResponseController::class, 'progresStore'])->name('progres.store');
        Route::post('/report/reject/{id}', [ResponseController::class, 'reject'])->name('reject');
        Route::delete('/response/{id}/content/{index}', [ResponseController::class, 'destroyContent'])->name('content.destroy');
    });
    
});
