<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\JenisController;
use App\Http\Controllers\Admin\MetodePembayaranController;
use App\Http\Controllers\Admin\PemasukanController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\MetodeController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\DetailTransaksiController;

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

//Clear All:
Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('optimize');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    return '<h1>Berhasil dibersihkan</h1>';
});

Route::get('/', function () {
    return view('auth.login');
});

// Authentication
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/keluar', [HomeController::class, 'keluar']);
Route::get('/admin/home', [HomeController::class, 'index']);
Route::get('/admin/change', [HomeController::class, 'change']);
Route::post('/admin/change_password', [HomeController::class, 'change_password']);

// Kategori
Route::prefix('admin/kategori')
    ->name('admin.kategori.')
    ->middleware('cekLevel:1 2')
    ->controller(KategoriController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Jenis
Route::prefix('admin/jenis')
    ->name('admin.jenis.')
    ->middleware('cekLevel:1 2')
    ->controller(JenisController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Metode Pembayaran
Route::prefix('admin/metode-pembayaran')
    ->name('admin.metode_pembayaran.')
    ->middleware('cekLevel:1 2')
    ->controller(MetodePembayaranController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Pemasukan
Route::prefix('admin/pemasukan')
    ->name('admin.pemasukan.')
    ->middleware('cekLevel:1 2')
    ->controller(PemasukanController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Pengeluaran
Route::prefix('admin/pengeluaran')
    ->name('admin.pengeluaran.')
    ->middleware('cekLevel:1 2')
    ->controller(PengeluaranController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Barang
Route::prefix('admin/barang')
    ->name('admin.barang.')
    ->middleware('cekLevel:1 2')
    ->controller(BarangController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Metode
Route::prefix('admin/metode')
    ->name('admin.metode.')
    ->middleware('cekLevel:1 2')
    ->controller(MetodeController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Transaksi
Route::prefix('admin/transaksi')
    ->name('admin.transaksi.')
    ->middleware('cekLevel:1 2')
    ->controller(TransaksiController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Detail Transaksi
Route::prefix('admin/detail-transaksi')
    ->name('admin.detail_transaksi.')
    ->middleware('cekLevel:1 2')
    ->controller(DetailTransaksiController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });