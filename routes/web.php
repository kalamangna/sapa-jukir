<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| AUTH CONTROLLER
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;


/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\JukirController;
use App\Http\Controllers\Admin\JenisJukirController;
use App\Http\Controllers\Admin\JenisParkirController;
use App\Http\Controllers\Admin\TitikParkirController;
use App\Http\Controllers\Admin\TarifController;
use App\Http\Controllers\Admin\PenempatanJukirController;
use App\Http\Controllers\Admin\SetoranController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\TargetPendapatanController;
use App\Http\Controllers\Admin\SumberPemasukanController;
use App\Http\Controllers\Admin\ObjekPendapatanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeringatanCapaianController;
use App\Http\Controllers\Admin\TagihanController;
use App\Http\Controllers\Admin\UnitUsahaController;
use App\Http\Controllers\Admin\PemanfaatanAsetController;
use App\Http\Controllers\Admin\OkupansiParkirController;
use App\Http\Controllers\Admin\UnitUsahaHistoryController;
use App\Http\Controllers\Admin\CapaianBulananController;


/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/berita', [PublicController::class, 'newsIndex'])->name('news.index');
Route::get('/berita/{news}', [PublicController::class, 'newsShow'])->name('news.show');
Route::view('/skm', 'skm')->name('skm');
Route::get('/guest/titik/{titikParkir}', [PublicController::class, 'titikParkirShow'])->name('guest.titik-parkir.show');

Route::get('/pengaduan', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/pengaduan', [PengaduanController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('pengaduan.store');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
|
| Halaman login dapat dibuka kembali meskipun sesi login lama masih aktif.
|
*/

Route::get(
    '/login',
    [LoginController::class, 'showLoginForm']
)->name('login');

Route::post(
    '/login',
    [LoginController::class, 'login']
)->middleware('throttle:5,1')->name('login.process');


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
|
| Logout menggunakan POST untuk keamanan.
|
*/

Route::post(
    '/logout',
    [LoginController::class, 'logout']
)->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
|
| Semua halaman administrator wajib login.
| Hak akses dibatasi berdasarkan role pengguna.
|
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        |
        | Semua pengguna yang login dan aktif dapat melihat dashboard.
        |
        */

        Route::get(
            '/',
            [DashboardController::class, 'index']
        )->middleware('role:admin,operator,pimpinan')->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | MASTER DATA
        |--------------------------------------------------------------------------
        |
        | Hanya ADMIN yang dapat mengelola master data.
        |
        */

        Route::middleware('role:admin')->group(function () {

            Route::get('audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit-logs.index');

            /*
            |--------------------------------------------------------------------------
            | JUKIR
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'jukir',
                JukirController::class
            );


            /*
            |--------------------------------------------------------------------------
            | JENIS JUKIR
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'jenis-jukir',
                JenisJukirController::class
            );


            /*
            |--------------------------------------------------------------------------
            | JENIS PARKIR
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'jenis-parkir',
                JenisParkirController::class
            );


            /*
            |--------------------------------------------------------------------------
            | TITIK PARKIR
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'titik-parkir',
                TitikParkirController::class
            );

            Route::resource(
                'gallery',
                \App\Http\Controllers\Admin\GalleryController::class
            );
            Route::resource('news', NewsController::class)->except(['show']);

            Route::get('karcis', [\App\Http\Controllers\Admin\KarcisAllocationController::class, 'index'])->name('karcis.index');
            Route::post('karcis', [\App\Http\Controllers\Admin\KarcisAllocationController::class, 'store'])->name('karcis.store');

            Route::get('site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
            Route::post('site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');

            Route::get('sambutan', [\App\Http\Controllers\Admin\SambutanController::class, 'index'])->name('sambutan.index');
            Route::post('sambutan', [\App\Http\Controllers\Admin\SambutanController::class, 'store'])->name('sambutan.store');
            Route::put('sambutan/{sambutan}', [\App\Http\Controllers\Admin\SambutanController::class, 'update'])->name('sambutan.update');

            Route::resource(
                'target-pendapatan',
                TargetPendapatanController::class
            )->parameters(['target-pendapatan' => 'targetPendapatan'])
                ->except(['show']);

            Route::resource(
                'sumber-pemasukan',
                SumberPemasukanController::class
            )->parameters(['sumber-pemasukan' => 'sumberPemasukan'])
                ->except(['show']);

            Route::resource('objek-pendapatan', ObjekPendapatanController::class)
                ->parameters(['objek-pendapatan' => 'objekPendapatan'])
                ->except(['show']);

            Route::resource('capaian-bulanan', CapaianBulananController::class)
                ->parameters(['capaian-bulanan' => 'capaianBulanan'])
                ->except(['show']);

            Route::resource('users', UserController::class)->except(['show']);

            Route::get('pengaduan', [AdminPengaduanController::class, 'index'])->name('pengaduan.index');
            Route::get('pengaduan/{pengaduan}', [AdminPengaduanController::class, 'show'])->name('pengaduan.show');
            Route::put('pengaduan/{pengaduan}', [AdminPengaduanController::class, 'update'])->name('pengaduan.update');
            Route::delete('pengaduan/{pengaduan}', [AdminPengaduanController::class, 'destroy'])->name('pengaduan.destroy');


            /*
            |--------------------------------------------------------------------------
            | TARIF
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'tarif',
                TarifController::class
            );

        });



        /*
        |--------------------------------------------------------------------------
        | OPERASIONAL
        |--------------------------------------------------------------------------
        |
        | ADMIN dan OPERATOR dapat menjalankan kegiatan operasional.
        |
        */

        Route::middleware('role:admin,operator')->group(function () {

            Route::get('tagihan/create', [TagihanController::class, 'create'])->name('tagihan.create');
            Route::post('tagihan', [TagihanController::class, 'store'])->name('tagihan.store');
            Route::post('tagihan/{tagihan}/bayar', [TagihanController::class, 'bayar'])->name('tagihan.bayar');
            Route::resource('unit-usaha', UnitUsahaController::class)
                ->parameters(['unit-usaha' => 'unitUsaha'])
                ->only(['create', 'store', 'edit', 'update', 'destroy']);
            Route::resource('pemanfaatan-aset', PemanfaatanAsetController::class)
                ->parameters(['pemanfaatan-aset' => 'pemanfaatanAset'])
                ->only(['create', 'store', 'edit', 'update', 'destroy']);
            Route::get('okupansi-parkir/create', [OkupansiParkirController::class, 'create'])->name('okupansi-parkir.create');
            Route::post('okupansi-parkir', [OkupansiParkirController::class, 'store'])->name('okupansi-parkir.store');
            Route::resource('penempatan-jukir', PenempatanJukirController::class)
                ->only(['create', 'store', 'edit', 'update', 'destroy']);
            Route::resource('setoran', SetoranController::class)
                ->only(['create', 'store', 'edit', 'update', 'destroy']);
            Route::put('setoran/{setoran}/verifikasi', [SetoranController::class, 'verifikasi'])->name('setoran.verifikasi');

        });

        Route::middleware('role:admin,operator,pimpinan')->group(function () {

            Route::get('tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
            Route::get('unit-usaha', [UnitUsahaController::class, 'index'])->name('unit-usaha.index');
            Route::get('unit-usaha/{unitUsaha}/history', [UnitUsahaHistoryController::class, 'index'])->name('unit-usaha.history');
            Route::get('pemanfaatan-aset', [PemanfaatanAsetController::class, 'index'])->name('pemanfaatan-aset.index');
            Route::get('okupansi-parkir', [OkupansiParkirController::class, 'index'])->name('okupansi-parkir.index');
            Route::resource('penempatan-jukir', PenempatanJukirController::class)
                ->only(['index', 'show']);
            Route::resource('setoran', SetoranController::class)
                ->only(['index', 'show']);

        });


        /*
        |--------------------------------------------------------------------------
        | LAPORAN
        |--------------------------------------------------------------------------
        |
        | ADMIN, OPERATOR, dan PIMPINAN dapat mengakses laporan.
        |
        */

        Route::middleware('role:admin,pimpinan')->group(function () {

            Route::get('peringatan-capaian', [PeringatanCapaianController::class, 'index'])->name('peringatan-capaian.index');
            Route::put('peringatan-capaian/{peringatanCapaian}', [PeringatanCapaianController::class, 'update'])->name('peringatan-capaian.update');


            /*
            |--------------------------------------------------------------------------
            | LAPORAN UTAMA
            |--------------------------------------------------------------------------
            */

            Route::get(
                'laporan',
                [LaporanController::class, 'index']
            )->name('laporan.index');

            Route::get(
                'laporan/analisis-pendapatan',
                [LaporanController::class, 'analisisPendapatan']
            )->name('laporan.analisis-pendapatan');
            Route::get(
                'laporan/capaian-realisasi',
                [LaporanController::class, 'analisisPendapatan']
            )->name('laporan.capaian-realisasi');

            Route::get('laporan/capaian-realisasi/cetak', [LaporanController::class, 'analisisPendapatan'])->name('laporan.capaian-realisasi.cetak');
            Route::get('laporan/capaian-realisasi/pdf', [LaporanController::class, 'analisisPendapatan'])->name('laporan.capaian-realisasi.pdf');
            Route::get('laporan/capaian-realisasi/xlsx', [LaporanController::class, 'analisisPendapatan'])->name('laporan.capaian-realisasi.xlsx');
            Route::get('laporan/capaian-realisasi/export', [LaporanController::class, 'exportAnalisisPendapatan'])->name('laporan.capaian-realisasi.export');

            Route::get(
                'laporan/jenis/{sumberPemasukan}',
                [LaporanController::class, 'jenis']
            )->name('laporan.jenis');

            Route::get(
                'laporan/tunggakan',
                [LaporanController::class, 'tunggakan']
            )->name('laporan.tunggakan');

            Route::get(
                'laporan/analisis-pendapatan/cetak',
                [LaporanController::class, 'analisisPendapatan']
            )->name('laporan.analisis-pendapatan.cetak');

            Route::get(
                'laporan/analisis-pendapatan/pdf',
                [LaporanController::class, 'analisisPendapatan']
            )->name('laporan.analisis-pendapatan.pdf');

            Route::get(
                'laporan/analisis-pendapatan/excel',
                [LaporanController::class, 'analisisPendapatan']
            )->name('laporan.analisis-pendapatan.excel');

            Route::get(
                'laporan/analisis-pendapatan/xlsx',
                [LaporanController::class, 'analisisPendapatan']
            )->name('laporan.analisis-pendapatan.xlsx');

            Route::get(
                'laporan/analisis-pendapatan/export',
                [LaporanController::class, 'exportAnalisisPendapatan']
            )->name('laporan.analisis-pendapatan.export');


            /*
            |--------------------------------------------------------------------------
            | LAPORAN JUKIR
            |--------------------------------------------------------------------------
            */

            Route::get(
                'laporan/jukir/cetak',
                [LaporanController::class, 'cetak']
            )->name('laporan.jukir.cetak');


            /*
            |--------------------------------------------------------------------------
            | LAPORAN TITIK PARKIR
            |--------------------------------------------------------------------------
            */

            Route::get(
                'laporan/titik-parkir',
                [LaporanController::class, 'titikParkir']
            )->name('laporan.titik-parkir');


            /*
            |--------------------------------------------------------------------------
            | CETAK TITIK PARKIR
            |--------------------------------------------------------------------------
            */

            Route::get(
                'laporan/titik-parkir/cetak',
                [LaporanController::class, 'cetakTitikParkir']
            )->name('laporan.titik-parkir.cetak');


            /*
            |--------------------------------------------------------------------------
            | LAPORAN PENEMPATAN JUKIR
            |--------------------------------------------------------------------------
            */

            Route::get(
                'laporan/penempatan-jukir',
                [LaporanController::class, 'penempatanJukir']
            )->name('laporan.penempatan-jukir');


            /*
            |--------------------------------------------------------------------------
            | CETAK PENEMPATAN JUKIR
            |--------------------------------------------------------------------------
            */

            Route::get(
                'laporan/penempatan-jukir/cetak',
                [LaporanController::class, 'cetakPenempatanJukir']
            )->name('laporan.penempatan-jukir.cetak');


            /*
            |--------------------------------------------------------------------------
            | LAPORAN TARIF
            |--------------------------------------------------------------------------
            */

            Route::get(
                'laporan/tarif',
                [LaporanController::class, 'tarif']
            )->name('laporan.tarif');


            /*
            |--------------------------------------------------------------------------
            | CETAK TARIF
            |--------------------------------------------------------------------------
            */

            Route::get(
                'laporan/tarif/cetak',
                [LaporanController::class, 'cetakTarif']
            )->name('laporan.tarif.cetak');


            /*
            |--------------------------------------------------------------------------
            | LAPORAN SETORAN
            |--------------------------------------------------------------------------
            */

            Route::get(
                'laporan/setoran',
                [LaporanController::class, 'setoran']
            )->name('laporan.setoran');


            /*
            |--------------------------------------------------------------------------
            | CETAK SETORAN
            |--------------------------------------------------------------------------
            */

            Route::get(
                'laporan/setoran/cetak',
                [LaporanController::class, 'cetakSetoran']
            )->name('laporan.setoran.cetak');

        });

    });