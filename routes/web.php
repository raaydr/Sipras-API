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
Route::get('/QrCode/{id}', [App\Http\Controllers\QrpageController::class, 'PageQrcodePerlengkapan'])->name('PageQrcodePerlengkapan');  


Route::get('/ubah-password', [App\Http\Controllers\AkunController::class, 'ubah_password'])->name('general.ubah.password');
Route::post('/post-password-change', [App\Http\Controllers\AkunController::class, 'change_password'])->name('general.change.password');
Route::group(['middleware' => 'check-permission:superadmin'], function () {
    Route::group(['prefix' => 'superadmin'], function () {
        //Barang
        
        //Perlengkapan
        
        
        
        //Dokumen
        Route::get('/Dokumen/Dokumen-Edit', [App\Http\Controllers\DokumenController::class, 'dokumenEdit'])->name('dokumenEdit');    
        Route::post('/Dokumen/Dokumen-Search-Unit', [App\Http\Controllers\DokumenController::class, 'searchUnit'])->name('searchUnit');
        Route::post('/Dokumen/Dokumen-Update', [App\Http\Controllers\DokumenController::class, 'dokumenUpdate'])->name('dokumenUpdate');        
        Route::get('/Dokumen/Dokumen-Tabel', [App\Http\Controllers\DokumenController::class, 'tabelDokumen'])->name('tabelDokumen');
        Route::get('/Dokumen/Dokumen-Publish/{id}', [App\Http\Controllers\DokumenController::class, 'dokumenPublish'])->name('dokumenPublish');
        Route::get('/Dokumen/Dokumen-Delete/{id}', [App\Http\Controllers\DokumenController::class, 'dokumenDelete'])->name('dokumenDelete');
        Route::get('/Dokumen/Dokumen-Detail/{id}', [App\Http\Controllers\DokumenController::class, 'dokumenDetailAdmin'])->name('dokumenDetailAdmin');


        //Pembuatan Admin
        Route::get('/User/Admin-Edit', [App\Http\Controllers\AkunController::class, 'PembuatanAdmin'])->name('PembuatanAdmin');    
        Route::get('/User/Admin-Tabel', [App\Http\Controllers\AkunController::class, 'TabelAdmin'])->name('TabelAdmin');    
        Route::post('/User/Admin-Daftar', [App\Http\Controllers\AkunController::class, 'DaftarAdmin'])->name('DaftarAdmin');
        Route::get('/User/Admin-Level/{id}', [App\Http\Controllers\AkunController::class, 'LevelAdmin'])->name('LevelAdmin');            
        Route::get('/User/Ubah-Akun/{id}', [App\Http\Controllers\AkunController::class, 'ubah_Akun'])->name('ubah_Akun');    
        Route::post('/User/Change-Account', [App\Http\Controllers\AkunController::class, 'change_account'])->name('change_account');
    });
});
Route::group(['middleware' => 'check-permission:superadmin|admin'], function () {
    Route::group(['prefix' => 'admin'], function () {
        
        //Barang
        Route::get('/Barang/Barang-Edit', [App\Http\Controllers\BarangController::class, 'BarangEdit'])->name('BarangEdit');  
        Route::post('/Barang/Barang-Update', [App\Http\Controllers\BarangController::class, 'BarangUpdate'])->name('BarangUpdate');        
        Route::get('/Barang/Barang-Tabel', [App\Http\Controllers\BarangController::class, 'tabelBarang'])->name('tabelBarang');
        Route::get('/Barang/Barang-Publish/{id}', [App\Http\Controllers\BarangController::class, 'BarangPublish'])->name('BarangPublish');
        Route::get('/Barang/Barang-Delete/{id}', [App\Http\Controllers\BarangController::class, 'BarangDelete'])->name('BarangDelete');
        Route::get('/Barang/Barang-Detail/{barang:slug}', [App\Http\Controllers\BarangController::class, 'BarangDetail'])->name('BarangDetail');
        //Perlengkapan
        Route::get('/Perlengkapan/Perlengkapan-Edit', [App\Http\Controllers\PerlengkapanController::class, 'PerlengkapanEdit'])->name('PerlengkapanEdit');  
        Route::post('/Perlengkapan/Perlengkapan-Update', [App\Http\Controllers\PerlengkapanController::class, 'PerlengkapanUpdate'])->name('PerlengkapanUpdate');        
        Route::get('/Perlengkapan/Perlengkapan-Tabel', [App\Http\Controllers\PerlengkapanController::class, 'tabelPerlengkapan'])->name('tabelPerlengkapan');
        Route::get('/Perlengkapan/Perlengkapan-Tabel-Barang/{id}', [App\Http\Controllers\PerlengkapanController::class, 'tabelPerlengkapanBarang'])->name('tabelPerlengkapanBarang');
        Route::get('/Perlengkapan/Perlengkapan-Publish/{id}', [App\Http\Controllers\PerlengkapanController::class, 'PerlengkapanPublish'])->name('PerlengkapanPublish');
        Route::get('/Perlengkapan/Perlengkapan-Delete/{id}', [App\Http\Controllers\PerlengkapanController::class, 'PerlengkapanDelete'])->name('PerlengkapanDelete');
        Route::get('/Perlengkapan/Perlengkapan-Detail/{id}', [App\Http\Controllers\PerlengkapanController::class, 'PerlengkapanDetail'])->name('PerlengkapanDetail');
        Route::get('/Barang/Perlengkapan-QrCode/{id}', [App\Http\Controllers\PerlengkapanController::class, 'PerlengkapanQrcode'])->name('PerlengkapanQrcode');  
        Route::post('/Perlengkapan/Barang-Search', [App\Http\Controllers\PerlengkapanController::class, 'searchBarang'])->name('searchBarang');
        //Mutasi
        Route::get('/Perlengkapan/Mutasi-Edit', [App\Http\Controllers\MutasiController::class, 'MutasiEdit'])->name('MutasiEdit');  
        Route::post('/Mutasi/Mutasi-Update', [App\Http\Controllers\MutasiController::class, 'MutasiUpdate'])->name('MutasiUpdate');        
        Route::get('/Mutasi/Mutasi-Tabel', [App\Http\Controllers\MutasiController::class, 'tabelMutasi'])->name('tabelMutasi');
        Route::get('/Mutasi/Mutasi-Tabel-Perlengkapan/{id}', [App\Http\Controllers\MutasiController::class, 'tabelMutasiPerlengkapan'])->name('tabelMutasiPerlengkapan');
        Route::get('/Mutasi/Mutasi-Publish/{id}', [App\Http\Controllers\MutasiController::class, 'MutasiPublish'])->name('MutasiPublish');
        Route::get('/Mutasi/Mutasi-Delete/{id}', [App\Http\Controllers\MutasiController::class, 'MutasiDelete'])->name('MutasiDelete');
        Route::get('/Mutasi/Mutasi-Detail/{id}', [App\Http\Controllers\MutasiController::class, 'MutasiDetail'])->name('MutasiDetail');

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