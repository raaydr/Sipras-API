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
        //Barang
        Route::get('/Barang/Barang-Edit', [App\Http\Controllers\BarangController::class, 'BarangEdit'])->name('BarangEdit');  
        Route::post('/Barang/Barang-Update', [App\Http\Controllers\BarangController::class, 'BarangUpdate'])->name('BarangUpdate');        
        Route::get('/Barang/Barang-Tabel', [App\Http\Controllers\BarangController::class, 'tabelBarang'])->name('tabelBarang');
        Route::get('/Barang/Barang-Publish/{id}', [App\Http\Controllers\BarangController::class, 'BarangPublish'])->name('BarangPublish');
        Route::get('/Barang/Barang-Delete/{id}', [App\Http\Controllers\BarangController::class, 'BarangDelete'])->name('BarangDelete');
        Route::get('/Barang/Barang-Detail/{id}', [App\Http\Controllers\BarangController::class, 'BarangDetail'])->name('BarangDetail');

        //Dokumen
        Route::get('/Dokumen/Dokumen-Edit', [App\Http\Controllers\DokumenController::class, 'dokumenEdit'])->name('dokumenEdit');    
        Route::post('/Dokumen/Dokumen-Search-Unit', [App\Http\Controllers\DokumenController::class, 'searchUnit'])->name('searchUnit');
        Route::post('/Dokumen/Dokumen-Update', [App\Http\Controllers\DokumenController::class, 'dokumenUpdate'])->name('dokumenUpdate');        
        Route::get('/Dokumen/Dokumen-Tabel', [App\Http\Controllers\DokumenController::class, 'tabelDokumen'])->name('tabelDokumen');
        Route::get('/Dokumen/Dokumen-Publish/{id}', [App\Http\Controllers\DokumenController::class, 'dokumenPublish'])->name('dokumenPublish');
        Route::get('/Dokumen/Dokumen-Delete/{id}', [App\Http\Controllers\DokumenController::class, 'dokumenDelete'])->name('dokumenDelete');
        Route::get('/Dokumen/Dokumen-Detail/{id}', [App\Http\Controllers\DokumenController::class, 'dokumenDetailAdmin'])->name('dokumenDetailAdmin');

    });
});
Route::group(['middleware' => 'check-permission:admin'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/Data-Barang', [App\Http\Controllers\BarangController::class, 'dataBarang'])->name('admin.dataBarang');
    });
});