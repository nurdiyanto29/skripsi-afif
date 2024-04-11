<?php

use App\Http\Controllers\Frontend\AgendaController;
use App\Http\Controllers\Frontend\DataDesaController;
use App\Http\Controllers\Frontend\DusunController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\KamlingController;
use App\Http\Controllers\Frontend\KontenController;
use App\Http\Controllers\Frontend\KotakSaranController;
use App\Http\Controllers\Frontend\OdgjController;
use App\Http\Controllers\Frontend\PbbController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\ProdukHukumController;
use App\Http\Controllers\Frontend\UmkmController;
use App\Http\Controllers\Frontend\VideoController;
use App\Http\Controllers\Frontend\PadukuhanController;

use Illuminate\Support\Facades\Route;

Route::get('/layanan', function () {
        abort(403, 'Sistem Dalam Tahap Pengembangan');
    });

Route::group(['prefix' => '', 'as' => 'home.'], function () {
        $class = HomeController::class;
        Route::get('/', [$class, 'index'])->name('index');
});
Route::group(['prefix' => 'konten', 'as' => 'konten.'], function () {
        $class = KontenController::class;
        Route::get('/{tipe}', [$class, 'index'])->name('index');
});
Route::group(['prefix' => 'kotak_saran', 'as' => 'kotak_saran.'], function () {
        $class = KotakSaranController::class;
        Route::get('/', [$class, 'index'])->name('index');
});
Route::group(['prefix' => 'kotak_saran', 'as' => 'kotak_saran.'], function () {
        $class = KotakSaranController::class;
        Route::get('/', [$class, 'index'])->name('index');
        Route::post('/ajax', [$class, 'store'])->name('store');
});
Route::group(['prefix' => 'data_desa', 'as' => 'data_desa.'], function () {
        $class = DataDesaController::class;
        Route::get('/{tipe}', [$class, 'index'])->name('index');
        Route::post('/ajax/{tipe}', [$class, 'ajax'])->name('ajax');
});
Route::group(['prefix' => 'dusun', 'as' => 'dusun.'], function () {
        $class = DusunController::class;
        Route::get('/', [$class, 'index'])->name('index');
        Route::post('/ajax', [$class, 'ajax'])->name('ajax');
});
Route::group(['prefix' => 'padukuhan', 'as' => 'padukuhan.'], function () {
        $class = PadukuhanController::class;
        Route::get('/', [$class, 'index'])->name('index');
        Route::get('/detail', [$class, 'show'])->name('detail');
});


Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
        $class = PostController::class;
        Route::get('/{type}', [$class, 'index'])->name('index');
        Route::get('/{type}/detail/{id}', [$class, 'detail'])->name('detail');
});

Route::group(['prefix' => 'umkm', 'as' => 'umkm.'], function () {
        $class = UmkmController::class;
        Route::get('/', [$class, 'index'])->name('index');
        Route::get('/detail/{id}', [$class, 'detail'])->name('detail');
});

Route::group(['prefix' => 'odgj', 'as' => 'odgj.'], function () {
        $class = OdgjController::class;
        Route::get('/', [$class, 'index'])->name('index');
        Route::get('/detail/{id}', [$class, 'detail'])->name('detail');
});

Route::group(['prefix' => 'produk_hukum', 'as' => 'produk_hukum.'], function () {
        $class = ProdukHukumController::class;
        Route::get('/', [$class, 'index'])->name('index');
        Route::get('/detail/{id}', [$class, 'detail'])->name('detail');
        Route::get('/download/{id}', [$class, 'download'])->name('download');
});

Route::group(['prefix' => 'pbb', 'as' => 'pbb.'], function () {
        $class = PbbController::class;
        Route::get('/', [$class, 'index'])->name('index');
        Route::get('/download/{type}/{id}', [$class, 'download'])->name('download');
});

Route::group(['prefix' => 'video', 'as' => 'video.'], function () {
        $class = VideoController::class;
        Route::get('/', [$class, 'index'])->name('index');

});

Route::group(['prefix' => 'agenda', 'as' => 'agenda.'], function () {
        $class = AgendaController::class;
        Route::get('/', [$class, 'index'])->name('index');
        Route::get('/detail/{id}', [$class, 'detail'])->name('detail');
        Route::post('/ajax', [$class, 'ajax'])->name('ajax');
});
Route::group(['prefix' => 'kamling', 'as' => 'kamling.'], function () {
        $class = KamlingController::class;
        Route::get('/', [$class, 'index'])->name('index');
        Route::post('/ajax', [$class, 'ajax'])->name('ajax');
        Route::get('/{id}', [$class, 'show'])->name('show');
        Route::get('/detail/{id}', [$class, 'detail'])->name('detail');
});