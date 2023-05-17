<?php

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

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/ubah-password', [App\Http\Controllers\GeneralController::class, 'ubah_password'])->name('general.ubah.password');
Route::post('/change-password', [App\Http\Controllers\GeneralController::class, 'change_password'])->name('general.change.password');


Route::group(['middleware' => 'check-permission:superadmin'], function () {
    Route::group(['prefix' => 'superadmin'], function () {
        Route::get('/Data-Barang', [App\Http\Controllers\BarangController::class, 'dataBarang'])->name('superadmin.dataBarang');
        Route::get('/Detail-Barang/{id}', [App\Http\Controllers\BarangController::class, 'detailBarang'])->name('superadmin.detailBarang');
        Route::get('/Barang/Tabel-Barang', [App\Http\Controllers\BarangController::class, 'tabelBarang'])->name('superadmin.tabelBarang');
    });
});
Route::group(['middleware' => 'check-permission:admin'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/Data-Barang', [App\Http\Controllers\BarangController::class, 'dataBarang'])->name('admin.dataBarang');
    });
});