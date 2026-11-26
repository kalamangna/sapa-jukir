<?php

namespace App\Http\Controllers;

use App\Models\CapaianBulanan;
use App\Models\Gallery;
use App\Models\Jukir;
use App\Models\Kecamatan;
use App\Models\News;
use App\Models\ObjekPendapatan;
use App\Models\Sambutan;
use App\Models\Setoran;
use App\Models\SiteSetting;
use App\Models\SumberPemasukan;
use App\Models\TargetPendapatan;
use App\Models\TitikParkir;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PublicController extends Controller
{
    public function home()
    {
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
    }

    public function gallery(Request $request)
    {
        $kategori = $request->input('kategori');
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
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('gallery', compact('galleries', 'kategori', 'kategoriList'));
    }

    public function newsIndex()
    {
        $newsItems = News::published()
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('news.index', compact('newsItems'));
    }

    public function newsShow(News $news)
    {
        abort_unless(News::published()->whereKey($news->getKey())->exists(), 404);
        $relatedNews = News::published()
            ->where('id', '!=', $news->getKey())
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }

    public function titikParkirShow(TitikParkir $titikParkir)
    {
        $titikParkir->load([
            'jenisParkir.tarifs' => fn ($query) => $query->where('status', true)->orderBy('jenis_kendaraan'),
            'kecamatan',
            'kelurahan',
            'penempatanJukirs' => fn ($query) => $query->where('status', 'aktif')->latest('tanggal_mulai'),
            'penempatanJukirs.jukir',
        ]);

        return view('public.titik-parkir.show', compact('titikParkir'));
    }
}
