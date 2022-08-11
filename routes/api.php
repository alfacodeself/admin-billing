<?php

use App\Http\Controllers\Api\Mitra\Auth\{LoginMitraController, LogoutMitraController, RegisterMitraController, VerifikasiEmailMitraController};
use App\Http\Controllers\Api\Mitra\{DokumenMitraController, LanggananMitraController, PelangganMitraController, PemetaanLayananMitraController, ProfilMitraController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Pelanggan\Auth\{LoginController, LogoutApiController, RegisterController};
use App\Http\Controllers\Api\Pelanggan\{AlamatApiController, DashboardApiController, DokumenApiController, LanggananApiController, PelangganApiController, ProdukApiController, TransaksiApiController};
use App\Http\Controllers\TransaksiController;

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
Route::post('notification/transaction', [TransaksiController::class, 'notification']);
Route::get('syarat-dokumen', [DokumenApiController::class, 'dokumen']);
Route::get('provinsi', [AlamatApiController::class, 'provinsi']);
Route::get('kabupaten/{id}', [AlamatApiController::class, 'kabupaten']);
Route::get('kecamatan/{id}', [AlamatApiController::class, 'kecamatan']);
Route::get('desa/{id}', [AlamatApiController::class, 'desa']);


Route::prefix('mitra')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::post('login', LoginMitraController::class);
        Route::post('register', RegisterMitraController::class);
        Route::post('email-verifikasi', [VerifikasiEmailMitraController::class, 'verify']);
    });
    Route::middleware('auth:mitra')->prefix('langganan')->group(function(){
        Route::get('/', [LanggananMitraController::class, 'index']);
        Route::get('kadaluarsa', [LanggananMitraController::class, 'langganan_kadaluarsa']);
        Route::get('nonaktif', [LanggananMitraController::class, 'langganan_nonaktif']);
        Route::get('nonaktif', [LanggananMitraController::class, 'langganan_nonaktif']);
        Route::get('jadwal-instalasi', [LanggananMitraController::class, 'jadwal_instalasi']);
    });
    Route::middleware('auth:mitra')->prefix('pelanggan')->group(function(){
        Route::get('/', [PelangganMitraController::class, 'index']);
        Route::post('tambah-pelanggan', [PelangganMitraController::class, 'store']);
        Route::get('nonaktif', [PelangganMitraController::class, 'pelanggan_nonaktif']);
        Route::get('transaksi', [PelangganMitraController::class, 'transaksi_pelanggan']);
        Route::get('transaksi/detail-transaksi/{id_transaksi}', [PelangganMitraController::class, 'detail_transaksi']);
    });
    Route::get('pemetaan-layanan', PemetaanLayananMitraController::class)->middleware('auth:mitra');
    Route::middleware('auth:mitra')->prefix('profil')->group(function(){
        Route::get('/', [ProfilMitraController::class, 'index']);
        Route::put('update-profil', [ProfilMitraController::class, 'updateProfil']);
        Route::put('update-akun', [ProfilMitraController::class, 'updateAccount']);
    });
    Route::middleware('auth:mitra')->prefix('dokumen')->group(function(){
        Route::get('/', [DokumenMitraController::class, 'index']);
        Route::post('tambah-dokumen', [DokumenMitraController::class, 'store']);
        Route::post('update-dokumen', [DokumenMitraController::class, 'update']);
        Route::get('syarat-dokumen', [DokumenMitraController::class, 'dokumen']);
    });
    Route::post('logout', LogoutMitraController::class)->middleware('auth:mitra');
});
