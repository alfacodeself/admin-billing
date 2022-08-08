<?php

use App\Http\Controllers\{AlamatController, BagiHasilController, DashboardController, JenisLanggananController, JenisPembayaranController, KategoriController, LanggananController, MetodePembayaranController, MitraController, PelangganController, PetugasController, ProdukController, TagihanController, TransaksiController};
use App\Http\Controllers\Auth\{LoginController, LogoutController, ResetPasswordController, VerifikasiEmailController};
use App\Http\Controllers\Informasi\PemetaanController;
use App\Http\Controllers\Pengaturan\{DokumenController, PembayaranController, ProfilController, RolePermissionController};
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
    Route::get('verifikasi-email', [VerifikasiEmailController::class, 'verifikasi'])->name('verifikasi-email');
    Route::post('verifikasi-email', [VerifikasiEmailController::class, 'verify']);
    Route::get('verifikasi-email/{token}/aktivasi', [VerifikasiEmailController::class, 'proses_verifikasi'])->name('verifikasi-email.verify');
    Route::get('email-reset-password', [ResetPasswordController::class, 'email_reset'])->name('reset-password.email');
    Route::post('email-reset-password', [ResetPasswordController::class, 'email_reset_post']);
    Route::get('reset-password/{token}/set-password', [ResetPasswordController::class, 'reset_password'])->name('reset_password');
    Route::post('reset-password/store/set-password', [ResetPasswordController::class, 'reset_password_post'])->name('reset_password.post');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('logout', LogoutController::class)->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::prefix('jenis-langganan')->group(function(){
        Route::get('/', [JenisLanggananController::class, 'index'])->name('jenis-langganan.index')->middleware('can:lihat jenis langganan');
        Route::post('store', [JenisLanggananController::class, 'store'])->name('jenis-langganan.store')->middleware('can:tambah jenis langganan');
        Route::put('update/{id}', [JenisLanggananController::class, 'update'])->name('jenis-langganan.update')->middleware('can:edit jenis langganan');
        Route::delete('delete/{id}', [JenisLanggananController::class, 'destroy'])->name('jenis-langganan.delete')->middleware('can:hapus jenis langganan');
    });
    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('kategori.index')->middleware('can:lihat kategori');
        Route::post('store', [KategoriController::class, 'store'])->name('kategori.store')->middleware('can:tambah kategori');
        Route::put('update/{id}', [KategoriController::class, 'update'])->name('kategori.update')->middleware('can:edit kategori');
        Route::delete('delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy')->middleware('can:hapus kategori');
    });
    Route::prefix('produk')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('produk.index')->middleware('can:lihat produk');
        Route::post('store', [ProdukController::class, 'store'])->name('produk.store')->middleware('can:tambah produk');
        Route::put('update/{id}', [ProdukController::class, 'update'])->name('produk.update')->middleware('can:edit produk');
        Route::delete('delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy')->middleware('can:hapus produk');
    });
    Route::prefix('petugas')->group(function () {
        Route::get('/', [PetugasController::class, 'index'])->name('petugas.index')->middleware('can:lihat petugas');
        Route::get('tambah-petugas', [PetugasController::class, 'create'])->name('petugas.create')->middleware('can:tambah petugas');
        Route::post('tambah-petugas/store', [PetugasController::class, 'store'])->name('petugas.store')->middleware('can:tambah petugas');
        Route::get('detail-petugas/{id}', [PetugasController::class, 'show'])->name('petugas.show')->middleware('can:lihat petugas');
        Route::put('detail-petugas/{id}/update-foto', [PetugasController::class, 'updateFoto'])->name('petugas.show.update-foto')->middleware('can:edit petugas');
        Route::put('detail-petugas/{id}/update-profil', [PetugasController::class, 'updateProfil'])->name('petugas.show.update-profil')->middleware('can:edit petugas');
    });
    Route::prefix('pelanggan')->group(function () {
        Route::get('/', [PelangganController::class, 'index'])->name('pelanggan.index')->middleware('can:lihat pelanggan');
        Route::get('tambah-pelanggan', [PelangganController::class, 'create'])->name('pelanggan.create')->middleware('can:tambah pelanggan');
        Route::post('tambah-pelanggan', [PelangganController::class, 'store'])->middleware('can:tambah pelanggan');
        Route::get('detail-pelanggan/{id}', [PelangganController::class, 'show'])->name('pelanggan.show')->middleware('can:detail pelanggan');
        Route::put('detail-pelanggan/{id}/update-foto', [PelangganController::class, 'updateFoto'])->name('pelanggan.show.update-foto')->middleware('can:edit pelanggan');
        Route::put('detail-pelanggan/{id}/update-profil', [PelangganController::class, 'updateProfil'])->name('pelanggan.show.update-profil')->middleware('can:edit pelanggan');
        Route::put('detail-pelanggan/{id}/update-dokumen', [PelangganController::class, 'updateDokumen'])->name('pelanggan.show.update-dokumen')->middleware('can:edit pelanggan');
        Route::put('detail-pelanggan/{id}/update-alamat', [PelangganController::class, 'updateAlamat'])->name('pelanggan.show.update-alamat')->middleware('can:edit pelanggan');
        Route::delete('delete-pelanggan/{id}/', [PelangganController::class, 'destroy'])->name('pelanggan.destroy')->middleware('can:hapus pelanggan');
    });
    Route::prefix('mitra')->group(function () {
        Route::get('/', [MitraController::class, 'index'])->name('mitra.index')->middleware('can:lihat mitra');
        Route::get('tambah-mitra', [MitraController::class, 'create'])->name('mitra.create')->middleware('can:tambah mitra');
        Route::post('tambah-mitra', [MitraController::class, 'store'])->middleware('can:tambah mitra');
        Route::get('detail-mitra/{id}', [MitraController::class, 'show'])->name('mitra.show')->middleware('can:detail mitra');
        Route::put('detail-mitra/{id}/update-foto', [MitraController::class, 'updateFoto'])->name('mitra.show.update-foto')->middleware('can:edit mitra');
        Route::put('detail-mitra/{id}/update-profil', [MitraController::class, 'updateProfil'])->name('mitra.show.update-profil')->middleware('can:edit mitra');
        Route::put('detail-mitra/{id}/update-dokumen', [MitraController::class, 'updateDokumen'])->name('mitra.show.update-dokumen')->middleware('can:edit mitra');
        Route::put('detail-mitra/{id}/update-bagi-hasil', [MitraController::class, 'updateBagiHasil'])->name('mitra.show.update-bagi-hasil')->middleware('can:pengaturan pembayaran');
        Route::get('mitra-pelanggan', [MitraController::class, 'pelanggan_mitra'])->name('mitra.mitra-pelanggan.index')->middleware('can:detail mitra');
        Route::delete('delete-mitra/{id}', [MitraController::class, 'destroy'])->name('mitra.destroy')->middleware('can:hapus mitra');
        // Route::get('verifikasi-mitra', [MitraController::class, 'verifikasi_mitra'])->name('mitra.verifikasi.index');
    });
    Route::prefix('langganan')->group(function () {
        Route::get('/', [LanggananController::class, 'index'])->name('langganan.index')->middleware('can:lihat langganan');
        Route::get('buat-langganan', [LanggananController::class, 'create'])->name('langganan.create')->middleware('can:tambah langganan');
        Route::post('buat-langganan/store', [LanggananController::class, 'store'])->name('langganan.store')->middleware('can:tambah langganan');
        Route::get('verifikasi', [LanggananController::class, 'verifikasi'])->name('langganan.verifikasi.index')->middleware('can:verifikasi langganan');
        Route::put('verifikasi/{id}/ditolak', [LanggananController::class, 'reject'])->name('langganan.verifikasi.reject')->middleware('can:verifikasi langganan');
        Route::put('verifikasi/{id}/diterima', [LanggananController::class, 'verify'])->name('langganan.verifikasi.verify')->middleware('can:verifikasi langganan');
        Route::get('detail-langganan/{id}', [LanggananController::class, 'show'])->name('langganan.show')->middleware('can:detail langganan');
        Route::get('detail-langganan/{id}/edit-jenis-langganan', [LanggananController::class, 'editJenisLangganan'])->name('langganan.editjenislangganan')->middleware(['can:detail langganan']);
        Route::post('detail-langganan/{id}/update-jenis-langganan', [LanggananController::class, 'updateJenisLangganan'])->name('langganan.updatejenislangganan')->middleware(['can:detail langganan']);
        Route::get('jadwal-instalasi', [LanggananController::class, 'schedule'])->name('langganan.schedule')->middleware('can:jadwal langganan');
        Route::get('cari-langganan', [LanggananController::class, 'searchSchedule'])->name('cari.langganan')->middleware('can:tambah jadwal langganan');
        Route::post('pengajuan-instalasi-langganan', [LanggananController::class, 'makeSchedule'])->name('pengajuan.instalasi.store')->middleware('can:tambah jadwal langganan');
    });
    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index')->middleware('can:lihat transaksi');
        Route::get('buat-transaksi', [TransaksiController::class, 'create'])->name('transaksi.create')->middleware('can:tambah transaksi');
        Route::post('buat-transaksi/{kode}/store', [TransaksiController::class, 'store'])->name('transaksi.store')->middleware('can:tambah transaksi');
        Route::get('detail-transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show')->middleware('can:detail transaksi');
    });
    Route::prefix('informasi')->group(function(){
        Route::prefix('pemetaan')->group(function(){
            Route::get('/', [PemetaanController::class, 'index'])->name('pemetaan.index')->middleware('can:pemetaan langganan');
            Route::get('pemetaan-informasi', [PemetaanController::class, 'get_alamat'])->name('pemetaan.informasi')->middleware('can:pemetaan langganan');
            Route::get('status-informasi', [PemetaanController::class, 'set_status'])->name('pemetaan.set-status')->middleware('can:pemetaan langganan');
        });
    });
    Route::prefix('pengaturan')->group(function () {
        Route::prefix('dokumen')->group(function () {
            Route::get('/', [DokumenController::class, 'index'])->name('pengaturan.dokumen.index')->middleware('can:pengaturan dokumen');
            Route::post('store', [DokumenController::class, 'store'])->name('pengaturan.dokumen.store')->middleware('can:pengaturan dokumen');
            Route::put('{id}/update', [DokumenController::class, 'update'])->name('pengaturan.dokumen.update')->middleware('can:pengaturan dokumen');
            Route::delete('{id}/delete', [DokumenController::class, 'destroy'])->name('pengaturan.dokumen.delete')->middleware('can:pengaturan dokumen');
        });
        Route::prefix('role-permission')->group(function () {
            Route::get('/', [RolePermissionController::class, 'index'])->name('pengaturan.rolepermission.index')->middleware('can:pengaturan role permission');
            Route::get('{id}/histori-jabatan-permisssion', [RolePermissionController::class, 'show'])->name('pengaturan.rolepermission.show')->middleware('can:pengaturan role permission');
            Route::get('{id}/edit', [RolePermissionController::class, 'edit'])->name('pengaturan.rolepermission.edit')->middleware('can:pengaturan role permission');
            Route::post('{id}/update', [PetugasController::class, 'updateJabatan'])->name('pengaturan.rolepermission.store')->middleware('can:pengaturan role permission');
            Route::put('{id}/off', [PetugasController::class, 'offPermission'])->name('pengaturan.rolepermission.offPermission')->middleware('can:pengaturan role permission');
        });
        Route::prefix('pembayaran')->group(function () {
            Route::get('/', [PembayaranController::class, 'index'])->name('pengaturan.pembayaran.index')->middleware('can:pengaturan pembayaran');
            Route::prefix('metode-pembayaran')->group(function () {
                Route::post('/', [MetodePembayaranController::class, 'store'])->name('metode-pembayaran.store')->middleware('can:pengaturan pembayaran');
                Route::put('/{id}', [MetodePembayaranController::class, 'update'])->name('metode-pembayaran.update')->middleware('can:pengaturan pembayaran');
                Route::delete('/{id}', [MetodePembayaranController::class, 'destroy'])->name('metode-pembayaran.delete')->middleware('can:pengaturan pembayaran');
            });
            Route::prefix('pengaturan-bagi-hasil')->group(function () {
                Route::post('/', [BagiHasilController::class, 'store'])->name('bagi-hasil.store')->middleware('can:pengaturan pembayaran');
            });
            Route::prefix('jenis-pembayaran')->group(function(){
                Route::post('/', [JenisPembayaranController::class, 'store'])->name('jenis-bayar.store')->middleware('can:pengaturan pembayaran');
                Route::put('/{id}', [JenisPembayaranController::class, 'update'])->name('jenis-bayar.update')->middleware('can:pengaturan pembayaran');
                Route::delete('/{id}', [JenisPembayaranController::class, 'destroy'])->name('jenis-bayar.delete')->middleware('can:pengaturan pembayaran');
            });
        });

        Route::prefix('profil')->group(function () {
            Route::get('/', [ProfilController::class, 'index'])->name('pengaturan.profil.index')->middleware('can:pengaturan profil');
            Route::put('update-foto', [ProfilController::class, 'updateFoto'])->name('pengaturan.profil.update.foto')->middleware('can:pengaturan profil');
            Route::put('update-profil', [ProfilController::class, 'updateProfil'])->name('pengaturan.profil.update.profil')->middleware('can:pengaturan profil');
            Route::put('update-password', [ProfilController::class, 'updatePassword'])->name('pengaturan.profil.update.password')->middleware('can:pengaturan profil');
        });
    });
});

Route::get('kabupaten/{id}', [AlamatController::class, 'kabupaten'])->name('kabupaten.update');
Route::get('kecamatan/{id}', [AlamatController::class, 'kecamatan'])->name('kecamatan.update');
Route::get('desa/{id}', [AlamatController::class, 'desa'])->name('desa.update');
Route::get('metode-pembayaran/change-status', [AlamatController::class, 'status'])->name('change.status.metode-pembayaran');
Route::get('total/{kode}', [AlamatController::class, 'total'])->name('change-total');
