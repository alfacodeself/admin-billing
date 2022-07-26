<?php

use App\Http\Controllers\{AlamatController, BagiHasilController, DashboardController, KategoriController, LanggananController, MetodePembayaranController, MitraController, PelangganController, PetugasController, ProdukController, TagihanController, TransaksiController};
use App\Http\Controllers\Auth\{LoginController, VerifikasiEmailController};
use App\Http\Controllers\Pengaturan\{DokumenController, PembayaranController, ProfilController};
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
    Route::get('verifikasi-email', [VerifikasiEmailController::class, 'verifikasi'])->name('verifikasi-email');
    Route::post('verifikasi-email', [VerifikasiEmailController::class, 'verify']);
    Route::get('verifikasi-email/{token}/aktivasi', [VerifikasiEmailController::class, 'proses_verifikasi'])->name('verifikasi-email.verify');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
        Route::post('store', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });
    Route::prefix('produk')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
        Route::post('store', [ProdukController::class, 'store'])->name('produk.store');
        Route::put('update/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    });
    Route::prefix('petugas')->group(function () {
        Route::get('/', [PetugasController::class, 'index'])->name('petugas.index');
        Route::get('tambah-petugas', [PetugasController::class, 'create'])->name('petugas.create');
        Route::post('tambah-petugas/store', [PetugasController::class, 'store'])->name('petugas.store');
        Route::get('detail-petugas/{id}', [PetugasController::class, 'show'])->name('petugas.show');
        Route::put('detail-petugas/{id}/update-foto', [PetugasController::class, 'updateFoto'])->name('petugas.show.update-foto');
        Route::put('detail-petugas/{id}/update-profil', [PetugasController::class, 'updateProfil'])->name('petugas.show.update-profil');
        Route::put('detail-petugas/{id}/update-jabatan', [PetugasController::class, 'updateJabatan'])->name('petugas.show.update-jabatan');
    });
    Route::prefix('pelanggan')->group(function () {
        Route::get('/', [PelangganController::class, 'index'])->name('pelanggan.index');
        Route::get('tambah-pelanggan', [PelangganController::class, 'create'])->name('pelanggan.create');
        Route::post('tambah-pelanggan', [PelangganController::class, 'store']);
        Route::get('detail-pelanggan/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');
        Route::put('detail-pelanggan/{id}/update-foto', [PelangganController::class, 'updateFoto'])->name('pelanggan.show.update-foto');
        Route::put('detail-pelanggan/{id}/update-profil', [PelangganController::class, 'updateProfil'])->name('pelanggan.show.update-profil');
        Route::put('detail-pelanggan/{id}/update-dokumen', [PelangganController::class, 'updateDokumen'])->name('pelanggan.show.update-dokumen');
        Route::delete('delete-pelanggan/{id}/', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
    });
    Route::prefix('mitra')->group(function () {
        Route::get('/', [MitraController::class, 'index'])->name('mitra.index');
        Route::get('tambah-mitra', [MitraController::class, 'create'])->name('mitra.create');
        Route::post('tambah-mitra', [MitraController::class, 'store']);
        Route::get('detail-mitra/{id}', [MitraController::class, 'show'])->name('mitra.show');
        Route::put('detail-mitra/{id}/update-foto', [MitraController::class, 'updateFoto'])->name('mitra.show.update-foto');
        Route::put('detail-mitra/{id}/update-profil', [MitraController::class, 'updateProfil'])->name('mitra.show.update-profil');
        Route::put('detail-mitra/{id}/update-dokumen', [MitraController::class, 'updateDokumen'])->name('mitra.show.update-dokumen');
        Route::get('mitra-pelanggan', [MitraController::class, 'pelanggan_mitra'])->name('mitra.mitra-pelanggan.index');
        Route::delete('delete-pelanggan/{id}/', [MitraController::class, 'destroy'])->name('mitra.destroy');
        // Route::get('verifikasi-mitra', [MitraController::class, 'verifikasi_mitra'])->name('mitra.verifikasi.index');
    });
    Route::prefix('langganan')->group(function () {
        Route::get('/', [LanggananController::class, 'index'])->name('langganan.index');
        Route::get('buat-langganan', [LanggananController::class, 'create'])->name('langganan.create');
        Route::post('buat-langganan/store', [LanggananController::class, 'store'])->name('langganan.store');
        Route::get('verifikasi', [LanggananController::class, 'verifikasi'])->name('langganan.verifikasi.index');
        Route::put('verifikasi/{id}/ditolak', [LanggananController::class, 'reject'])->name('langganan.verifikasi.reject');
        Route::put('verifikasi/{id}/diterima', [LanggananController::class, 'verify'])->name('langganan.verifikasi.verify');
        Route::get('detail-langganan/{id}', [LanggananController::class, 'show'])->name('langganan.show');
    });
    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('buat-transaksi', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('buat-transaksi/{kode}/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('detail-transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    });
    Route::prefix('pengaturan')->group(function () {
        Route::prefix('dokumen')->group(function () {
            Route::get('/', [DokumenController::class, 'index'])->name('pengaturan.dokumen.index');
            Route::post('store', [DokumenController::class, 'store'])->name('pengaturan.dokumen.store');
            Route::put('{id}/update', [DokumenController::class, 'update'])->name('pengaturan.dokumen.update');
            Route::delete('{id}/delete', [DokumenController::class, 'destroy'])->name('pengaturan.dokumen.delete');
        });
        Route::prefix('pembayaran')->group(function () {
            Route::get('/', [PembayaranController::class, 'index'])->name('pengaturan.pembayaran.index');
            Route::prefix('metode-pembayaran')->group(function () {
                Route::post('/', [MetodePembayaranController::class, 'store'])->name('metode-pembayaran.store');
                Route::put('/{id}', [MetodePembayaranController::class, 'update'])->name('metode-pembayaran.update');
                Route::delete('/{id}', [MetodePembayaranController::class, 'destroy'])->name('metode-pembayaran.delete');
            });
            Route::prefix('pengaturan-bagi-hasil')->group(function () {
                Route::post('/', [BagiHasilController::class, 'store'])->name('bagi-hasil.store');
                Route::put('/{id}', [BagiHasilController::class, 'update'])->name('bagi-hasil.update');
                Route::delete('/{id}', [BagiHasilController::class, 'destroy'])->name('bagi-hasil.delete');
            });
        });
        Route::prefix('profil')->group(function () {
            Route::get('/', [ProfilController::class, 'index'])->name('pengaturan.profil.index');
            Route::put('update-foto', [ProfilController::class, 'updateFoto'])->name('pengaturan.profil.update.foto');
            Route::put('update-profil', [ProfilController::class, 'updateProfil'])->name('pengaturan.profil.update.profil');
            Route::put('update-password', [ProfilController::class, 'updatePassword'])->name('pengaturan.profil.update.password');
        });
    });
});

Route::get('kabupaten/{id}', [AlamatController::class, 'kabupaten'])->name('kabupaten.update');
Route::get('kecamatan/{id}', [AlamatController::class, 'kecamatan'])->name('kecamatan.update');
Route::get('desa/{id}', [AlamatController::class, 'desa'])->name('desa.update');
Route::get('metode-pembayaran/change-status', [AlamatController::class, 'status'])->name('change.status.metode-pembayaran');
Route::get('total/{kode}', [AlamatController::class, 'total'])->name('change-total');
