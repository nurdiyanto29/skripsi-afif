<?php

use App\Models\Travel;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CKEditorController;


use App\Http\Controllers\Admin\SopirController;

use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\TravelController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\RangkingController;
use App\Http\Controllers\Admin\PenjualanController;
use App\Http\Controllers\Admin\WisatawanController;
use App\Http\Controllers\Admin\KonfigurasiController;
use App\Http\Controllers\Admin\ObjekWisataController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\WisatawanPageController;

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
Route::get('/register', [AuthController::class, 'register'])->name('getregister');
Route::post('/post_register', [AuthController::class, 'post_register'])->name('post_register');
Route::post('/login', [AuthController::class, 'authenticate'])->name('postlogin');


Route::get('/', [WisatawanPageController::class, 'index'])->name('wisatawan.index');
Route::get('/destinasi', [WisatawanPageController::class, 'destinasi'])->name('wisatawan.destinasi');
Route::get('/destinasi_detail', [WisatawanPageController::class, 'destinasi_detail'])->name('wisatawan.destinasi_detail');
Route::get('/booking', [WisatawanPageController::class, 'booking'])->name('wisatawan.booking');
Route::get('/pesan_travel', [WisatawanPageController::class, 'pesan_travel'])->name('wisatawan.pesan_travel');
Route::get('/cari_travel', [WisatawanPageController::class, 'cari_travel'])->name('wisatawan.cari_travel');
Route::post('/buat_pesanan', [WisatawanPageController::class, 'buat_pesanan'])->name('wisatawan.buat_pesanan');




// Route::group([], __DIR__ . '/home.php');  //kondisi jika ada route lagi misal untuk frontend

//projek kali ini berfokus pada satu modul yaitu modul admin

Route::group(['middleware' => 'auth'], function () {
    
    //wisatawan
    Route::group(['middleware' => ['cekAuth:wisatawan']], function () {
        Route::get('/pesan_travel', [WisatawanPageController::class, 'pesan_travel'])->name('wisatawan.pesan_travel');
        
        Route::get('/pembayaran', [WisatawanPageController::class, 'pembayaran'])->name('wisatawan.pembayaran');
        Route::post('/proses_bayar', [WisatawanPageController::class, 'proses_bayar'])->name('wisatawan.proses_bayar');
        Route::get('/pesanan', [WisatawanPageController::class, 'pesanan'])->name('wisatawan.pesanan');
        Route::get('/etiket', [WisatawanPageController::class, 'etiket'])->name('wisatawan.etiket');
    });











    //ADMIN





    Route::group(['middleware' => ['cekAuth:admin,operator']], function () {
        Route::get('/admin', [HomeController::class, 'index'])->name('admin.index');

        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

            Route::get('/password', [AuthController::class, 'admin_password_get'])->name('password_get');
            Route::post('/password', [AuthController::class, 'admin_password_post'])->name('password_post');


            Route::group(['prefix' => 'sopir', 'as' => 'sopir.'], function () {
                $class = SopirController::class;

                Route::get('/', [$class, 'index'])->name('index');
                Route::get('/create', [$class, 'create'])->name('create');
                Route::post('/store', [$class, 'store'])->name('store');
                Route::post('/update', [$class, 'update'])->name('update');
                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::post('/delete', [$class, 'destroy'])->name('delete');
                Route::get('/cek/{id}', [$class, 'cek'])->name('cek');
            });

            Route::group(['prefix' => 'objek_wisata', 'as' => 'objek_wisata.'], function () {
                $class = ObjekWisataController::class;

                Route::get('/', [$class, 'index'])->name('index');
                Route::get('/create', [$class, 'create'])->name('create');
                Route::post('/store', [$class, 'store'])->name('store');
                Route::post('/update', [$class, 'update'])->name('update');
                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::post('/delete', [$class, 'destroy'])->name('delete');
                Route::get('/cek/{id}', [$class, 'cek'])->name('cek');
            });
            Route::group(['prefix' => 'travel', 'as' => 'travel.'], function () {
                $class = TravelController::class;

                Route::get('/', [$class, 'index'])->name('index');
                Route::get('/create', [$class, 'create'])->name('create');
                Route::post('/store', [$class, 'store'])->name('store');
                Route::post('/update', [$class, 'update'])->name('update');
                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::post('/delete', [$class, 'destroy'])->name('delete');
                Route::get('/cek/{id}', [$class, 'cek'])->name('cek');
            });
            Route::group(['prefix' => 'pesanan', 'as' => 'pesanan.'], function () {
                $class = PesananController::class;

                Route::get('/', [$class, 'index'])->name('index');
                Route::get('/create', [$class, 'create'])->name('create');
                Route::post('/store', [$class, 'store'])->name('store');
                Route::post('/update', [$class, 'update'])->name('update');
                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::get('/selesaikan', [$class, 'selesaikan'])->name('selesaikan');
                Route::post('/delete', [$class, 'destroy'])->name('delete');
                Route::get('/cek/{id}', [$class, 'cek'])->name('cek');
            });
            Route::group(['prefix' => 'pembayaran', 'as' => 'pembayaran.'], function () {
                $class = PembayaranController::class;

                Route::get('/', [$class, 'index'])->name('index');
                Route::get('/create', [$class, 'create'])->name('create');
                Route::post('/store', [$class, 'store'])->name('store');
                Route::post('/update', [$class, 'update'])->name('update');
                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::post('/delete', [$class, 'destroy'])->name('delete');
                Route::get('/cek/{id}', [$class, 'cek'])->name('cek');
                Route::get('/show', [$class, 'show'])->name('show');
                Route::post('/konfirmasi', [$class, 'konfirmasi'])->name('konfirmasi');
            });
            Route::group(['prefix' => 'wisatawan', 'as' => 'wisatawan.'], function () {
                $class = WisatawanController::class;

                Route::get('/', [$class, 'index'])->name('index');
                Route::get('/create', [$class, 'create'])->name('create');
                Route::post('/store', [$class, 'store'])->name('store');
                Route::post('/update', [$class, 'update'])->name('update');
                Route::get('/edit', [$class, 'edit'])->name('edit');
                Route::post('/delete', [$class, 'destroy'])->name('delete');
                Route::get('/cek/{id}', [$class, 'cek'])->name('cek');
            });
        }); // Admin


        Route::group(['prefix' => 'ckeditor', 'as' => 'ckeditor.'], function () {
            $class = CKEditorController::class;
            Route::post('/upload', [$class, 'upload'])->name('upload');
        });
    }); //'middleware' => ['cekAuth:admin']
}); //'middleware' => 'auth'
