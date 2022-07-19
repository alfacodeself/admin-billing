<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Pelanggan\Auth\{LoginController, RegisterController};
use App\Http\Controllers\Api\Pelanggan\{DokumenApiController, PelangganApiController};
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
            Route::put('update', [PelangganApiController::class, 'updateProfil']);
            Route::put('account-update', [PelangganApiController::class, 'updateAccount']);
        });
        Route::prefix('dokumen')->group(function(){
            Route::get('/', [DokumenApiController::class, 'index']);
            Route::post('tambah-dokumen', [DokumenApiController::class, 'store']);
            Route::put('update-dokumen', [DokumenApiController::class, 'update']);
        });
    });
});
Route::get('pelanggan/all', function(){
    // return (new PelangganResource(Pelanggan::get()))->additional([
    //     "success" => true,
    //     "message" => "Berhasil mengambil data pelanggan!"
    // ]);
    return response()->json(Pelanggan::get());
});
