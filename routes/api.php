<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Pelanggan\Auth\{LoginController, LogoutApiController, RegisterController};
use App\Http\Controllers\Api\Pelanggan\{AlamatApiController, DashboardApiController, DokumenApiController, LanggananApiController, PelangganApiController, ProdukApiController, TransaksiApiController};
use App\Http\Controllers\TransaksiController;
use App\Models\Pelanggan;

Route::prefix('pelanggan')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::post('login', LoginController::class);
        Route::post('register', RegisterController::class);
    });
    Route::middleware('auth:pelanggan')->group(function(){
        Route::get('dashboard', DashboardApiController::class);
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
            Route::get('transaksi-langganan/{kode}', [LanggananApiController::class, 'transaksiLangganan']);
            Route::put('pengajuan-langganan/{kode}', [LanggananApiController::class, 'pengajuan']);
            Route::put('pengajuan-instalasi-langganan/{kode}', [LanggananApiController::class, 'set_tanggal_instalasi']);
            Route::get('penyelesaian-instalasi/{kode}', [LanggananApiController::class, 'approve']);
        });
        Route::prefix('dokumen')->group(function(){
            Route::get('/', [DokumenApiController::class, 'index']);
            Route::post('tambah-dokumen', [DokumenApiController::class, 'store']);
            Route::post('update-dokumen', [DokumenApiController::class, 'update']);
        });
        Route::prefix('transaksi')->group(function(){
            Route::get('/', [TransaksiApiController::class, 'transaksi_pelanggan']);
            Route::post('total-bayar/{kode}', [TransaksiApiController::class, 'total']);
            Route::get('tagihan-langganan/{kode}', [TransaksiApiController::class, 'tagihan']);
            Route::get('detail-transaksi/{id_transaksi}', [TransaksiApiController::class, 'detail_transaksi']);
            Route::post('buat-transaksi/{kode}', [TransaksiApiController::class, 'buat_transaksi']);
            Route::get('transaksi-berjalan', [TransaksiApiController::class, 'transaksi_berjalan']);
        });
        Route::get('produk', [ProdukApiController::class, 'index']);
        Route::get('metode-pembayaran', [TransaksiApiController::class, 'metode_bayar']);
        Route::post('logout', LogoutApiController::class);
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
