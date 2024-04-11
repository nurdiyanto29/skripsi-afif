<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JadwalController;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LapanganController;
use App\Http\Controllers\Api\LapanganDetailController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\PembayaranController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::group(['prefix' => 'lapangan', 'as' => 'lapangan.'], function () {
    Route::get('/', [LapanganController::class, 'index'])->name('index');
    Route::get('/show/{id}', [LapanganController::class, 'show'])->name('show');

});

Route::group(['prefix' => 'lapangan_detail', 'as' => 'lapangan_detail.'], function () {
    Route::get('/', [LapanganDetailController::class, 'index'])->name('index');
    Route::get('/show/{id}', [LapanganDetailController::class, 'show'])->name('show');
});



Route::group(['prefix' => 'jadwal', 'as' => 'jadwal.'], function () {
    Route::get('/', [JadwalController::class, 'index'])->name('index');
    Route::get('/show/{id}', [JadwalController::class, 'show'])->name('show');

});


Route::middleware('auth:sanctum')->group(function () {
    Route::group(['middleware' => ['cekAuth:admin,penyewa']], function () {

        Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        });

        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::get('/show/{id}', [UserController::class, 'show'])->name('show');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('update');

            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        });

   


        Route::group(['prefix' => 'pesanan', 'as' => 'pesanan.'], function () {
            Route::get('/', [PesananController::class, 'index'])->name('index');
            Route::get('/create', [PesananController::class, 'create'])->name('create');
            Route::get('/show/{id}', [PesananController::class, 'show'])->name('show');
            Route::put('/update/{id}', [PesananController::class, 'update'])->name('update');

            Route::post('/store', [PesananController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [PesananController::class, 'destroy'])->name('delete');
        });

        Route::group(['prefix' => 'pembayaran', 'as' => 'pembayaran.'], function () {
            Route::get('/', [PembayaranController::class, 'index'])->name('index');
            Route::get('/create', [PembayaranController::class, 'create'])->name('create');
            Route::get('/show/{id}', [PembayaranController::class, 'show'])->name('show');
            Route::put('/update/{id}', [PembayaranController::class, 'update'])->name('update');

            Route::post('/store', [PembayaranController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [PembayaranController::class, 'destroy'])->name('delete');
        });
    });

    Route::group(['middleware' => ['cekAuth:admin']], function () {
        Route::group(['prefix' => 'lapangan', 'as' => 'lapangan.'], function () {
            Route::get('/create', [LapanganController::class, 'create'])->name('create');
            Route::get('/show/{id}', [LapanganController::class, 'show'])->name('show');
            Route::put('/update/{id}', [LapanganController::class, 'update'])->name('update');

            Route::post('/store', [LapanganController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [LapanganController::class, 'destroy'])->name('delete');
        });

         Route::group(['prefix' => 'lapangan_detail', 'as' => 'lapangan_detail.'], function () {
            Route::get('/create', [LapanganDetailController::class, 'create'])->name('create');
            Route::get('/show/{id}', [LapanganDetailController::class, 'show'])->name('show');
            Route::put('/update/{id}', [LapanganDetailController::class, 'update'])->name('update');

            Route::post('/store', [LapanganDetailController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [LapanganDetailController::class, 'destroy'])->name('delete');
        });

        Route::group(['prefix' => 'jadwal', 'as' => 'jadwal.'], function () {
            Route::get('/create', [JadwalController::class, 'create'])->name('create');
            Route::get('/show/{id}', [JadwalController::class, 'show'])->name('show');
            Route::put('/update/{id}', [JadwalController::class, 'update'])->name('update');

            Route::post('/store', [JadwalController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [JadwalController::class, 'destroy'])->name('delete');
        });
    });
});
