<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Pelanggan\Auth\{LoginController, RegisterController};
use App\Http\Controllers\Api\Pelanggan\{AlamatApiController, DokumenApiController, LanggananApiController, PelangganApiController, ProdukApiController};
use App\Http\Controllers\TransaksiController;
use App\Http\Resources\PelangganResource;
use App\Models\Pelanggan;

Route::prefix('pelanggan')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::post('login', LoginController::class);
        Route::post('register', RegisterController::class);
    });
    Route::middleware('auth:pelanggan')->group(function(){
        Route::prefix('profile')->group(function(){
            Route::get('/', [PelangganApiController::class, 'profil']);
            Route::post('update', [PelangganApiController::class, 'updateProfil']);
            Route::put('account-update', [PelangganApiController::class, 'updateAccount']);
        });
        Route::prefix('langganan')->group(function(){
            Route::get('/', [LanggananApiController::class, 'index']);
            Route::post('buat-langganan', [LanggananApiController::class, 'store']);
            Route::put('update-langganan/{kode}', [LanggananApiController::class, 'update']);
            Route::get('detail-langganan/{id}', [LanggananApiController::class, 'show']);
            Route::get('jenis-langganan', [LanggananApiController::class, 'jenis_langganan']);
        });
        Route::prefix('dokumen')->group(function(){
            Route::get('/', [DokumenApiController::class, 'index']);
            Route::post('tambah-dokumen', [DokumenApiController::class, 'store']);
            Route::post('update-dokumen', [DokumenApiController::class, 'update']);
        });
        Route::get('produk', [ProdukApiController::class, 'index']);
    });
});
Route::get('pelanggan/all', function(){
    return response()->json(Pelanggan::get());
});
Route::post('notification/transaction', [TransaksiController::class, 'notification']);
Route::get('syarat-dokumen', [DokumenApiController::class, 'dokumen']);
Route::get('provinsi', [AlamatApiController::class, 'provinsi']);
Route::get('kabupaten/{id}', [AlamatApiController::class, 'kabupaten']);
Route::get('kecamatan/{id}', [AlamatApiController::class, 'kecamatan']);
Route::get('desa/{id}', [AlamatApiController::class, 'desa']);
