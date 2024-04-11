<?php

use App\Http\Controllers\Admin\KonfigurasiController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CKEditorController;


use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\PenjualanController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\RangkingController;

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







//auth
Route::get('/logout', [AuthController::class, 'logout'])->name('getlogout');
Route::get('/login', [AuthController::class, 'login'])->name('getlogin');
Route::post('/login', [AuthController::class, 'authenticate'])->name('postlogin');





// Route::group([], __DIR__ . '/home.php');  //kondisi jika ada route lagi misal untuk frontend

//projek kali ini berfokus pada satu modul yaitu modul admin

Route::group(['middleware' => 'auth'], function () {

    //ADMIN
    Route::group(['middleware' => ['cekAuth:pemilik,operator']], function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.index');

        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

            Route::get('/password', [AuthController::class, 'admin_password_get'])->name('password_get');
            Route::post('/password', [AuthController::class, 'admin_password_post'])->name('password_post');

            Route::group(['prefix' => 'kriteria', 'as' => 'kriteria.'], function () {
                $class = KriteriaController::class;

                Route::get('/', [$class, 'index'])->name('index');
                Route::get('/create', [$class, 'create'])->name('create');
                Route::post('/store', [$class, 'store'])->name('store');
                Route::post('/update', [$class, 'update'])->name('update');

                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::post('/delete/{id}', [$class, 'destroy'])->name('delete');


                Route::get('/sub_kriteria', [$class, 'sub_kriteria'])->name('sub_kriteria');
                Route::post('/sub_delete/{id}', [$class, 'sub_destroy'])->name('sub_delete');
                Route::post('/sub_kriteria/store', [$class, 'sub_kriteria_store'])->name('sub_kriteria_store');
            });

            Route::group(['prefix' => 'produk', 'as' => 'produk.'], function () {
                $class = ProdukController::class;

                Route::get('/', [$class, 'index'])->name('index');
                Route::get('/create', [$class, 'create'])->name('create');
                Route::post('/store', [$class, 'store'])->name('store');

                Route::post('/update', [$class, 'update'])->name('update');
                Route::get('/edit', [$class, 'edit'])->name('edit');

                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::post('/delete', [$class, 'destroy'])->name('delete');


                Route::get('/cek/{id}', [$class, 'cek'])->name('cek');
            });
            Route::group(['prefix' => 'penjualan', 'as' => 'penjualan.'], function () {
                $class = PenjualanController::class;

                Route::get('/', [$class, 'index'])->name('index');
                Route::get('/create', [$class, 'create'])->name('create');
                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::post('/store', [$class, 'store'])->name('store');
                Route::post('/update', [$class, 'update'])->name('update');

                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::post('/delete', [$class, 'destroy'])->name('delete');
            });
            Route::group(['prefix' => 'ranking', 'as' => 'ranking.'], function () {
                $class = RangkingController::class;

                Route::get('/', [$class, 'index'])->name('index');
                Route::get('/create', [$class, 'create'])->name('create');
                Route::post('/store', [$class, 'store'])->name('store');

                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::post('/delete', [$class, 'destroy'])->name('delete');
            });


        
        }); // Admin


        Route::group(['prefix' => 'ckeditor', 'as' => 'ckeditor.'], function () {
            $class = CKEditorController::class;
            Route::post('/upload', [$class, 'upload'])->name('upload');
        });
    }); //'middleware' => ['cekAuth:admin']



    Route::group(['middleware' => ['cekAuth:pemilik']], function () {
        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
            Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::get('/edit', [UserController::class, 'edit'])->name('edit');
                Route::post('/update', [UserController::class, 'update'])->name('update');
                Route::post('/store', [UserController::class, 'store'])->name('store');
                Route::post('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
            });
            Route::group(['prefix' => 'konfigurasi', 'as' => 'konfigurasi.'], function () {
                $class = KonfigurasiController::class;
    
                Route::get('/', [$class, 'index'])->name('index');
                Route::get('/create', [$class, 'create'])->name('create');
                Route::post('/store', [$class, 'store'])->name('store');
    
                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::post('/delete', [$class, 'destroy'])->name('delete');
            });
        });

    }); //'middleware' => ['cekAuth:admin']

}); //'middleware' => 'auth'
