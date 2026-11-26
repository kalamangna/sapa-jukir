<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;


/*
|--------------------------------------------------------------------------
| AUTH CONTROLLER
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PengaduanController;
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
use App\Models\Kecamatan;
use App\Models\JenisParkir;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Jukir;
use App\Models\Setoran;
use App\Models\Sambutan;
use App\Models\SiteSetting;
use App\Models\TitikParkir;
use App\Models\SumberPemasukan;
use App\Models\TargetPendapatan;
use App\Models\ObjekPendapatan;
use App\Models\CapaianBulanan;


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

Route::get('/', function () {
    $tahunAktif = now()->year;
    $totalJukir = Jukir::count();
    $totalTitikParkir = TitikParkir::count();
    $titikParkirAktif = TitikParkir::where('status', 'aktif')->count();
    $totalKecamatan = TitikParkir::where('status', 'aktif')
        ->whereNotNull('kecamatan_id')
        ->distinct('kecamatan_id')
        ->count('kecamatan_id');
    $totalJenisParkir = SumberPemasukan::where('status', true)
        ->whereIn('kode', ['R-PJTU', 'R-TKP', 'R-TKU', 'R-JASA-USAHA', 'R-SPATKT'])
        ->count();
    $totalJasaUsaha = TitikParkir::whereHas('sumberPemasukan', fn ($query) => $query->whereIn('kode', ['R-JASA-USAHA', 'R-SPATKT']))
        ->where('status', 'aktif')
        ->count()
        + ObjekPendapatan::whereHas('sumberPemasukan', fn ($query) => $query->whereIn('kode', ['R-JASA-USAHA', 'R-SPATKT']))
            ->where('status', 'aktif')
            ->count();
    $totalSetoran = Setoran::count();
    $totalPenerimaan = Setoran::sum('jumlah_setoran');
    $activeSources = SumberPemasukan::where('status', true)
        ->whereIn('kode', ['R-PJTU', 'R-TKP', 'R-TKU', 'R-JASA-USAHA'])
        ->orderBy('nama')
        ->get(['id', 'kode', 'nama']);
    $totalSumberPemasukan = $activeSources->count();
    $tanggalPembaruanPublik = now()->format('d/m/Y H:i');
    $setoranHariIni = Setoran::whereDate('tanggal', today())->sum('jumlah_setoran');
    $potensiHarian = TitikParkir::sum('potensi_harian')
        + ObjekPendapatan::where('status', 'aktif')->sum('potensi_harian');
    $potensiBulananPublik = TitikParkir::sum('potensi_bulanan')
        + ObjekPendapatan::where('status', 'aktif')->sum('potensi_bulanan');
    $targetTahunanOtomatis = 1_170_500_000;
    $targetBulananOtomatisMap = collect(range(1, 12))->mapWithKeys(function ($bulan) use ($targetTahunanOtomatis) {
        $basic = intdiv($targetTahunanOtomatis, 12);
        $remainder = $targetTahunanOtomatis % 12;
        $value = $bulan <= $remainder ? $basic + 1 : $basic;

        return [$bulan => (int) $value];
    });
    $namaBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];
    $setoranBulanan = Setoran::query()
        ->where('status', 'terverifikasi')
        ->whereYear('tanggal', $tahunAktif)
        ->get(['tanggal', 'jumlah_setoran'])
        ->groupBy(fn ($setoran) => (int) $setoran->tanggal->format('n'))
        ->map(fn ($setorans) => (float) $setorans->sum('jumlah_setoran'));
    $targetPendapatanTahun = TargetPendapatan::query()
        ->where('tahun', $tahunAktif)
        ->get(['bulan', 'titik_parkir_id', 'objek_pendapatan_id', 'target'])
        ->groupBy('bulan')
        ->map(function ($targets) use ($targetBulananOtomatisMap) {
            $memilikiTargetLokasi = $targets->contains(fn ($target) => $target->titik_parkir_id !== null || $target->objek_pendapatan_id !== null);

            return round((float) $targets
                ->filter(fn ($target) => $memilikiTargetLokasi
                    ? $target->titik_parkir_id !== null || $target->objek_pendapatan_id !== null
                    : $target->titik_parkir_id === null && $target->objek_pendapatan_id === null)
                ->sum('target'));
        });
    $capaianManualTahun = CapaianBulanan::query()
        ->where('tahun', $tahunAktif)
        ->get()
        ->keyBy('bulan');
    $targetTahunan = (int) round(collect(range(1, 12))->sum(function ($bulan) use ($targetPendapatanTahun, $targetBulananOtomatisMap) {
        return (int) ($targetPendapatanTahun->get($bulan) ?: $targetBulananOtomatisMap->get($bulan, 0));
    }));
    $potensiPerSumber = SumberPemasukan::query()
        ->where('status', true)
        ->withSum(['titikParkirs as potensi_titik' => fn ($query) => $query->where('status', 'aktif')], 'potensi_bulanan')
        ->withSum(['objekPendapatans as potensi_objek' => fn ($query) => $query->where('status', 'aktif')], 'potensi_bulanan')
        ->orderBy('nama')
        ->get();
    $targetPerSumberTahun = TargetPendapatan::query()
        ->where('tahun', $tahunAktif)
        ->get(['sumber_pemasukan_id', 'titik_parkir_id', 'objek_pendapatan_id', 'target'])
        ->groupBy('sumber_pemasukan_id')
        ->map(function ($targets) {
            $scoped = $targets->contains(fn ($target) => $target->titik_parkir_id !== null || $target->objek_pendapatan_id !== null);
            return round((float) $targets->filter(fn ($target) => $scoped
                ? $target->titik_parkir_id !== null || $target->objek_pendapatan_id !== null
                : $target->titik_parkir_id === null && $target->objek_pendapatan_id === null)->sum('target'));
        });
    $realisasiPerSumberTahun = Setoran::query()
        ->where('status', 'terverifikasi')
        ->whereYear('tanggal', $tahunAktif)
        ->selectRaw('sumber_pemasukan_id, SUM(jumlah_setoran) AS total')
        ->groupBy('sumber_pemasukan_id')
        ->pluck('total', 'sumber_pemasukan_id');
    $capaianPerSumber = $potensiPerSumber->map(function ($sumber) use ($targetPerSumberTahun, $realisasiPerSumberTahun) {
        $target = (float) $targetPerSumberTahun->get($sumber->id, 0);
        $realisasi = (float) $realisasiPerSumberTahun->get($sumber->id, 0);
        $potensi = (float) ($sumber->potensi_titik ?? 0) + (float) ($sumber->potensi_objek ?? 0);
        return [
            'nama' => $sumber->nama,
            'potensi' => $potensi,
            'target' => $target,
            'realisasi' => $realisasi,
            'selisih' => $target - $realisasi,
            'belum_tergali' => max(0, $potensi - $realisasi),
            'persentase' => $target > 0 ? min(100, ($realisasi / $target) * 100) : 0,
        ];
    });
    $achievementBulanan = collect(range(1, 12))->map(function ($bulan) use ($setoranBulanan, $targetPendapatanTahun, $capaianManualTahun, $namaBulan, $tahunAktif, $targetBulananOtomatisMap) {
        $manual = $capaianManualTahun->get($bulan);
        $target = $manual ? (float) $manual->target : ((int) ($targetPendapatanTahun->get($bulan) ?: $targetBulananOtomatisMap->get($bulan, 0)));
        $total = $manual ? (float) $manual->realisasi : $setoranBulanan->get($bulan, 0);
        return [
            'tahun' => $tahunAktif,
            'bulan' => $namaBulan[$bulan],
            'target' => round($target),
            'total' => round($total),
            'persentase' => $target > 0 ? min(100, ($total / $target) * 100) : 0,
            'manual' => (bool) $manual,
        ];
    });
    $trenPendapatanPublik = collect(range(1, 12))->map(function ($bulan) use ($targetPendapatanTahun, $setoranBulanan, $capaianManualTahun, $namaBulan, $tahunAktif, $targetBulananOtomatisMap, $potensiBulananPublik) {
        $manual = $capaianManualTahun->get($bulan);
        $target = $manual ? (float) $manual->target : ((int) ($targetPendapatanTahun->get($bulan) ?: $targetBulananOtomatisMap->get($bulan, 0)));
        $realisasi = $manual ? (float) $manual->realisasi : $setoranBulanan->get($bulan, 0);
        return [
            'tahun' => $tahunAktif,
            'bulan' => $namaBulan[$bulan],
            'potensi' => round((float) $potensiBulananPublik),
            'target' => round($target),
            'realisasi' => round($realisasi),
            'capaian' => $target > 0 ? min(100, ($realisasi / $target) * 100) : 0,
        ];
    })->values();
    $targetTahunan = (int) (round($achievementBulanan->sum(fn ($item) => (int) $item['target']) / 1000) * 1000);
    $realisasiTahunan = (int) round($achievementBulanan->sum(fn ($item) => (int) $item['total']));
    $persentaseCapaian = $targetTahunan > 0
        ? min(100, ($realisasiTahunan / $targetTahunan) * 100)
        : 0;
    $titikParkirTerbaru = TitikParkir::query()
        ->with(['kecamatan', 'kelurahan', 'jenisParkir'])
        ->latest()
        ->take(4)
        ->get();

    $kecamatanList = Kecamatan::query()
        ->orderBy('nama')
        ->get();
    $sumberPemasukanPeta = SumberPemasukan::query()
        ->where('status', true)
        ->orderBy('nama')
        ->get(['kode', 'nama']);

    $galleries = Gallery::query()
        ->where('is_active', true)
        ->orderBy('urutan')
        ->latest()
        ->take(3)
        ->get();

    $sambutan = Sambutan::query()
        ->where('is_active', true)
        ->latest()
        ->first();

    $siteSettings = SiteSetting::query()->first();

    $parkirPeta = TitikParkir::query()
        ->with(['kecamatan', 'kelurahan', 'sumberPemasukan'])
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->select(['id', 'nama', 'alamat', 'latitude', 'longitude', 'status', 'kecamatan_id', 'kelurahan_id', 'sumber_pemasukan_id'])
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'alamat' => $item->alamat,
                'lat' => (float) $item->latitude,
                'lng' => (float) $item->longitude,
                'kecamatan_id' => $item->kecamatan_id,
                'status' => strtoupper($item->status ?? 'AKTIF'),
                'sumber_pemasukan_id' => $item->sumber_pemasukan_id,
                'sumber_kode' => $item->sumberPemasukan?->kode ?? 'R-PJTU',
                'sumber_nama' => $item->sumberPemasukan?->nama ?? 'Sumber Pendapatan Tepi Jalan Umum',
                'kecamatan' => $item->kecamatan?->nama ?? '-',
                'kelurahan' => $item->kelurahan?->nama ?? '-',
                'detail_url' => route('guest.titik-parkir.show', $item),
            ];
        })
        ->toArray();

    return view('welcome', compact(
        'totalTitikParkir',
        'titikParkirAktif',
        'totalJukir',
        'totalSetoran',
        'totalPenerimaan',
        'totalSumberPemasukan',
        'activeSources',
        'tanggalPembaruanPublik',
        'setoranHariIni',
        'potensiHarian',
        'targetTahunan',
        'realisasiTahunan',
        'persentaseCapaian',
        'tahunAktif',
        'achievementBulanan',
        'trenPendapatanPublik',
        'capaianPerSumber',
        'totalKecamatan',
        'totalJenisParkir',
        'totalJasaUsaha',
        'titikParkirTerbaru',
        'kecamatanList',
        'sumberPemasukanPeta',
        'parkirPeta',
        'galleries',
        'sambutan',
        'siteSettings'
    ));
})->name('home');

Route::get('/gallery', function () {
    $kategori = request('kategori');
    $kategoriList = Gallery::CATEGORIES;
    $galleryRows = Gallery::query()
        ->where('is_active', true)
        ->when($kategori, fn ($query) => $query->where('kategori', $kategori))
        ->orderBy('urutan')
        ->latest()
        ->get();
    $galleryGroups = $galleryRows
        ->groupBy(fn ($gallery) => $gallery->gallery_group ?: 'legacy-' . $gallery->id)
        ->map(function ($items) {
            $gallery = $items->first();
            $gallery->gallery_images = $items->pluck('gambar')->values()->all();
            return $gallery;
        })
        ->values();
    $perPage = 12;
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $galleries = new LengthAwarePaginator(
        $galleryGroups->forPage($currentPage, $perPage)->values(),
        $galleryGroups->count(),
        $perPage,
        $currentPage,
        ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => request()->query()]
    );

    return view('gallery', compact('galleries', 'kategori', 'kategoriList'));
})->name('gallery');

Route::get('/berita', function () {
    $newsItems = News::published()
        ->orderByDesc('published_at')
        ->orderByDesc('created_at')
        ->paginate(9);

    return view('news.index', compact('newsItems'));
})->name('news.index');

Route::get('/berita/{news}', function (News $news) {
    abort_unless(News::published()->whereKey($news->getKey())->exists(), 404);
    $relatedNews = News::published()
        ->where('id', '!=', $news->getKey())
        ->orderByDesc('published_at')
        ->orderByDesc('created_at')
        ->limit(5)
        ->get();

    return view('news.show', compact('news', 'relatedNews'));
})->name('news.show');

Route::view('/skm', 'skm')->name('skm');

Route::get('/guest/titik/{titikParkir}', function (TitikParkir $titikParkir) {
    $titikParkir->load([
        'jenisParkir.tarifs' => fn ($query) => $query->where('status', true)->orderBy('jenis_kendaraan'),
        'kecamatan',
        'kelurahan',
        'penempatanJukirs' => fn ($query) => $query->where('status', 'aktif')->latest('tanggal_mulai'),
        'penempatanJukirs.jukir',
    ]);

    return view('public.titik-parkir.show', compact('titikParkir'));
})->name('guest.titik-parkir.show');

Route::get('/pengaduan', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');


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
)->name('login.process');


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

        Route::middleware('role:admin,operator,pimpinan')->group(function () {

            Route::get('tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
            Route::get('tagihan/create', [TagihanController::class, 'create'])->name('tagihan.create');
            Route::post('tagihan', [TagihanController::class, 'store'])->name('tagihan.store');
            Route::post('tagihan/{tagihan}/bayar', [TagihanController::class, 'bayar'])->name('tagihan.bayar');
            Route::resource('unit-usaha', UnitUsahaController::class)->parameters(['unit-usaha' => 'unitUsaha'])->except(['show']);
            Route::get('unit-usaha/{unitUsaha}/history', [UnitUsahaHistoryController::class, 'index'])->name('unit-usaha.history');
            Route::resource('pemanfaatan-aset', PemanfaatanAsetController::class)->parameters(['pemanfaatan-aset' => 'pemanfaatanAset'])->except(['show']);
            Route::get('okupansi-parkir', [OkupansiParkirController::class, 'index'])->name('okupansi-parkir.index');
            Route::get('okupansi-parkir/create', [OkupansiParkirController::class, 'create'])->name('okupansi-parkir.create');
            Route::post('okupansi-parkir', [OkupansiParkirController::class, 'store'])->name('okupansi-parkir.store');


            /*
            |--------------------------------------------------------------------------
            | PENEMPATAN JUKIR
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'penempatan-jukir',
                PenempatanJukirController::class
            );


            /*
            |--------------------------------------------------------------------------
            | SETORAN
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'setoran',
                SetoranController::class
            );


            /*
            |--------------------------------------------------------------------------
            | VERIFIKASI SETORAN
            |--------------------------------------------------------------------------
            |
            | Admin dan operator dapat melakukan proses verifikasi.
            |
            */

            Route::put(
                'setoran/{setoran}/verifikasi',
                [SetoranController::class, 'verifikasi']
            )->name('setoran.verifikasi');

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
                function (\Illuminate\Http\Request $request, \App\Models\SumberPemasukan $sumberPemasukan) {
                    $request->merge(['sumber_pemasukan_id' => $sumberPemasukan->id]);
                    return app(LaporanController::class)->analisisPendapatan($request);
                }
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