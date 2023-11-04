<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!

|

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

*/
    
    Route::post('/login', [App\Http\Controllers\Api\LoginController::class, 'Login'])->name('Login');
    Route::middleware('auth:sanctum')->group( function () {
        Route::get('/logout', [App\Http\Controllers\Api\LoginController::class, 'Logout'])->name('Logout');
        Route::get('/identify', [App\Http\Controllers\Api\LoginController::class, 'IdentifyUser'])->name('IdentifyUser');
        Route::get('/perlengkapan-detail/{id}', [App\Http\Controllers\Api\PerlengkapanController::class, 'PerlengkapanDetail'])->name('PerlengkapanDetail');    
        Route::get('/perlengkapan', [App\Http\Controllers\Api\PerlengkapanController::class, 'PerlengkapanEdit'])->name('PerlengkapanEdit');
        
    });
    //Route::post('/User/Change-Account', [App\Http\Controllers\AkunController::class, 'change_account'])->name('change_account');

