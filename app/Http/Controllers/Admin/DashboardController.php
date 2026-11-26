<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jukir;
use App\Models\PenempatanJukir;
use App\Models\Tarif;
use App\Models\TitikParkir;
use App\Models\Setoran;
use App\Models\SumberPemasukan;
use App\Models\TargetPendapatan;
use App\Models\ObjekPendapatan;
use App\Models\AreaAset;
use App\Models\CapaianBulanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard SAPA JUKIR.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK UTAMA
        |--------------------------------------------------------------------------
        */

        $totalJukir = Jukir::count();

        $jukirAktif = Jukir::where('status', 'aktif')
            ->count();

        $totalTitikParkir = TitikParkir::count();

        $titikParkirAktif = TitikParkir::where('status', 'aktif')
            ->count();

        $totalPenempatan = PenempatanJukir::count();

        $penempatanAktif = PenempatanJukir::where('status', 'aktif')
            ->count();

        $totalTarif = Tarif::count();

        $tarifAktif = Tarif::where('status', true)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | POTENSI PARKIR
        |--------------------------------------------------------------------------
        */

        $potensiHarian = TitikParkir::sum('potensi_harian')
            + ObjekPendapatan::where('status', 'aktif')->sum('potensi_harian');

        $potensiBulanan = TitikParkir::sum('potensi_bulanan')
            + ObjekPendapatan::where('status', 'aktif')->sum('potensi_bulanan');

        $tahunDashboard = now()->year;
        $capaianManualDashboard = CapaianBulanan::query()
            ->where('tahun', $tahunDashboard)
            ->get()
            ->keyBy('bulan');
        $realisasiBulananDashboard = Setoran::query()
            ->where('status', 'terverifikasi')
            ->whereYear('tanggal', $tahunDashboard)
            ->get(['tanggal', 'jumlah_setoran'])
            ->groupBy(fn ($setoran) => (int) $setoran->tanggal->format('n'))
            ->map(fn ($setorans) => (float) $setorans->sum('jumlah_setoran'));
        $targetBulananDashboard = TargetPendapatan::query()
            ->where('tahun', $tahunDashboard)
            ->get(['bulan', 'titik_parkir_id', 'objek_pendapatan_id', 'target'])
            ->groupBy('bulan')
            ->map(function ($targets) {
                $hasScopedTarget = $targets->contains(fn ($target) => $target->titik_parkir_id !== null || $target->objek_pendapatan_id !== null);

                return (float) $targets
                    ->filter(fn ($target) => $hasScopedTarget
                        ? $target->titik_parkir_id !== null || $target->objek_pendapatan_id !== null
                        : $target->titik_parkir_id === null && $target->objek_pendapatan_id === null)
                    ->sum('target');
            });
        $targetTahunanDashboard = (int) (round(collect(range(1, 12))->sum(function ($bulan) use ($targetBulananDashboard, $capaianManualDashboard) {
            return $capaianManualDashboard->has($bulan)
                ? (float) $capaianManualDashboard->get($bulan)->target
            : (float) $targetBulananDashboard->get($bulan, 0);
        }) / 1000) * 1000);
        $realisasiTahunanDashboard = round(collect(range(1, 12))->sum(function ($bulan) use ($realisasiBulananDashboard, $capaianManualDashboard) {
            return $capaianManualDashboard->has($bulan)
                ? (float) $capaianManualDashboard->get($bulan)->realisasi
                : (float) $realisasiBulananDashboard->get($bulan, 0);
        }));
        $potensiTahunanDashboard = (float) $potensiBulanan * 12;
        $persentaseCapaianTahunanDashboard = $targetTahunanDashboard > 0
            ? min(100, ($realisasiTahunanDashboard / $targetTahunanDashboard) * 100)
            : 0;
        $potensiBelumTergaliTahunanDashboard = max(0, $potensiTahunanDashboard - $realisasiTahunanDashboard);
        $totalAreaAsetDashboard = AreaAset::where('status', '!=', 'nonaktif')->count();
        $areaAsetDimanfaatkanDashboard = AreaAset::where('status', 'dimanfaatkan')->count();
        $persentasePemanfaatanAsetDashboard = $totalAreaAsetDashboard > 0
            ? ($areaAsetDimanfaatkanDashboard / $totalAreaAsetDashboard) * 100
            : 0;
        $targetTrenDashboard = TargetPendapatan::query()
            ->where('tahun', $tahunDashboard)
            ->get(['bulan', 'titik_parkir_id', 'objek_pendapatan_id', 'target'])
            ->groupBy('bulan');
        $realisasiTrenDashboard = Setoran::query()
            ->where('status', 'terverifikasi')
            ->whereYear('tanggal', $tahunDashboard)
            ->get(['tanggal', 'jumlah_setoran'])
            ->groupBy(fn ($setoran) => (int) $setoran->tanggal->format('n'))
            ->map(fn ($setorans) => (float) $setorans->sum('jumlah_setoran'));
        $namaBulanDashboard = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $trenPendapatanDashboard = collect(range(1, 12))->map(function ($bulan) use ($targetTrenDashboard, $realisasiTrenDashboard, $capaianManualDashboard, $namaBulanDashboard, $potensiBulanan) {
            $targets = $targetTrenDashboard->get($bulan, collect());
            $hasScopedTarget = $targets->contains(fn ($target) => $target->titik_parkir_id !== null || $target->objek_pendapatan_id !== null);
            $target = (float) $targets
                ->filter(fn ($item) => $hasScopedTarget
                    ? $item->titik_parkir_id !== null || $item->objek_pendapatan_id !== null
                    : $item->titik_parkir_id === null && $item->objek_pendapatan_id === null)
                ->sum('target');
            $manual = $capaianManualDashboard->get($bulan);
            if ($manual) {
                $target = (float) $manual->target;
            }
            $realisasi = $manual ? (float) $manual->realisasi : (float) $realisasiTrenDashboard->get($bulan, 0);

            return [
                'bulan' => $namaBulanDashboard[$bulan],
                'potensi' => (float) $potensiBulanan,
                'target' => $target,
                'realisasi' => $realisasi,
                'capaian' => $target > 0 ? min(100, ($realisasi / $target) * 100) : 0,
            ];
        })->values();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK SETORAN
        |--------------------------------------------------------------------------
        */

        $totalSetoran = Setoran::count();

        $totalPendapatanBruto = Setoran::where('status', 'terverifikasi')->sum(
            'pendapatan_bruto'
        );

        $totalJumlahSetoran = Setoran::where('status', 'terverifikasi')->sum(
            'jumlah_setoran'
        );

        $totalSelisih = Setoran::where('status', 'terverifikasi')->sum(
            'selisih'
        );

        // Get date from request, default to today
        $tanggalFilter = $request->query('tanggal') ? \Carbon\Carbon::parse($request->query('tanggal'))->toDateString() : today()->toDateString();

        $setoranHariIniPerPetugas = Setoran::query()
            ->where('status', 'terverifikasi')
            ->whereDate('tanggal', $tanggalFilter)
            ->whereNotNull('jukir_id')
            ->selectRaw('jukir_id, SUM(jumlah_setoran) AS total')
            ->groupBy('jukir_id')
            ->pluck('total', 'jukir_id');

        $petugasCapaianHarian = Jukir::query()
            ->where('status', 'aktif')
            ->with(['penempatanJukirs' => function ($query) {
                $query->where('status', 'aktif')->with('titikParkir');
            }])
            ->orderBy('nama')
            ->get()
            ->map(function ($petugas) use ($setoranHariIniPerPetugas) {
                $target = $petugas->penempatanJukirs
                    ->sum(fn ($penempatan) => (float) ($penempatan->titikParkir?->potensi_harian ?? 0));
                $realisasi = (float) $setoranHariIniPerPetugas->get($petugas->id, 0);
                $status = $target <= 0 ? 'tanpa_target' : ($realisasi >= $target ? 'tercapai' : 'belum_tercapai');

                return [
                    'nama' => $petugas->nama,
                    'titik' => $petugas->penempatanJukirs
                        ->map(fn ($penempatan) => $penempatan->titikParkir?->nama)
                        ->filter()
                        ->values(),
                    'target' => $target,
                    'realisasi' => $realisasi,
                    'status' => $status,
                ];
            });

        $jumlahPetugasTercapai = $petugasCapaianHarian->where('status', 'tercapai')->count();
        $jumlahPetugasBelumTercapai = $petugasCapaianHarian->where('status', 'belum_tercapai')->count();
        $jumlahPetugasTanpaTarget = $petugasCapaianHarian->where('status', 'tanpa_target')->count();

        $pendapatanPerSumber = SumberPemasukan::query()
            ->withSum(['titikParkirs as potensi_titik_bulanan' => fn ($query) => $query->where('status', 'aktif')], 'potensi_bulanan')
            ->withSum(['objekPendapatans as potensi_objek_bulanan' => fn ($query) => $query->where('status', 'aktif')], 'potensi_bulanan')
            ->withSum(['setorans as total_pendapatan_bruto' => fn ($query) => $query->where('status', 'terverifikasi')], 'pendapatan_bruto')
            ->withSum(['setorans as total_jumlah_setoran' => fn ($query) => $query->where('status', 'terverifikasi')], 'jumlah_setoran')
            ->withSum(['setorans as total_selisih' => fn ($query) => $query->where('status', 'terverifikasi')], 'selisih')
            ->where('status', true)
            ->orderBy('nama')
            ->get();

        $bulanDashboard = now()->month;
        $targetBulanDashboard = TargetPendapatan::query()
            ->where('tahun', $tahunDashboard)
            ->where('bulan', $bulanDashboard)
            ->get(['sumber_pemasukan_id', 'titik_parkir_id', 'objek_pendapatan_id', 'target']);

        $targetPerSumber = $targetBulanDashboard
            ->groupBy('sumber_pemasukan_id')
            ->map(function ($targets) {
                $memilikiTargetObjek = $targets->contains(fn ($target) => $target->titik_parkir_id !== null || $target->objek_pendapatan_id !== null);

                return (float) $targets
                    ->filter(fn ($target) => $memilikiTargetObjek
                        ? $target->titik_parkir_id !== null || $target->objek_pendapatan_id !== null
                        : $target->titik_parkir_id === null && $target->objek_pendapatan_id === null)
                    ->sum('target');
            });

        $realisasiPerSumber = Setoran::query()
            ->where('status', 'terverifikasi')
            ->whereYear('tanggal', $tahunDashboard)
            ->whereMonth('tanggal', $bulanDashboard)
            ->selectRaw('sumber_pemasukan_id, SUM(jumlah_setoran) AS total')
            ->groupBy('sumber_pemasukan_id')
            ->pluck('total', 'sumber_pemasukan_id');

        $pendapatanPerSumber = $pendapatanPerSumber->map(function ($sumber) use ($targetPerSumber, $realisasiPerSumber) {
            $target = (float) $targetPerSumber->get($sumber->id, 0);
            $realisasi = (float) $realisasiPerSumber->get($sumber->id, 0);
            $potensi = (float) ($sumber->potensi_titik_bulanan ?? 0) + (float) ($sumber->potensi_objek_bulanan ?? 0);

            $sumber->potensi_bulan_ini = $potensi;
            $sumber->target_bulan_ini = $target;
            $sumber->realisasi_bulan_ini = $realisasi;
            $sumber->potensi_belum_tergali_bulan_ini = max(0, $potensi - $realisasi);
            $sumber->persentase_capaian_bulan_ini = $target > 0 ? min(100, ($realisasi / $target) * 100) : 0;

            return $sumber;
        });

        $rankingPendapatan = $pendapatanPerSumber
            ->filter(fn ($sumber) => $sumber->target_bulan_ini > 0)
            ->sortByDesc('persentase_capaian_bulan_ini')
            ->values();

        $peringatanPendapatan = $rankingPendapatan
            ->filter(fn ($sumber) => $sumber->persentase_capaian_bulan_ini < 80)
            ->values();

        $targetPerLokasi = $targetBulanDashboard
            ->filter(fn ($target) => $target->titik_parkir_id !== null)
            ->groupBy('titik_parkir_id')
            ->map(fn ($targets) => (float) $targets->sum('target'));

        $realisasiPerLokasi = Setoran::query()
            ->where('status', 'terverifikasi')
            ->whereYear('tanggal', $tahunDashboard)
            ->whereMonth('tanggal', $bulanDashboard)
            ->whereNotNull('titik_parkir_id')
            ->selectRaw('titik_parkir_id, SUM(jumlah_setoran) AS total')
            ->groupBy('titik_parkir_id')
            ->pluck('total', 'titik_parkir_id');

        $namaLokasi = TitikParkir::whereIn('id', $targetPerLokasi->keys())->pluck('nama', 'id');
        $rankingLokasi = $targetPerLokasi
            ->map(function ($target, $titikParkirId) use ($realisasiPerLokasi, $namaLokasi) {
                $realisasi = (float) $realisasiPerLokasi->get($titikParkirId, 0);

                return [
                    'id' => $titikParkirId,
                    'nama' => $namaLokasi->get($titikParkirId, 'Lokasi tidak ditemukan'),
                    'target' => $target,
                    'realisasi' => $realisasi,
                    'persentase' => $target > 0 ? min(100, ($realisasi / $target) * 100) : 0,
                ];
            })
            ->sortByDesc('persentase')
            ->values();

        $peringatanLokasi = $rankingLokasi
            ->filter(fn ($lokasi) => $lokasi['persentase'] < 80)
            ->values();

        $targetPerObjek = $targetBulanDashboard
            ->filter(fn ($target) => $target->objek_pendapatan_id !== null)
            ->groupBy('objek_pendapatan_id')
            ->map(fn ($targets) => (float) $targets->sum('target'));

        $realisasiPerObjek = Setoran::query()
            ->where('status', 'terverifikasi')
            ->whereYear('tanggal', $tahunDashboard)
            ->whereMonth('tanggal', $bulanDashboard)
            ->whereNotNull('objek_pendapatan_id')
            ->selectRaw('objek_pendapatan_id, SUM(jumlah_setoran) AS total')
            ->groupBy('objek_pendapatan_id')
            ->pluck('total', 'objek_pendapatan_id');

        $namaObjek = ObjekPendapatan::whereIn('id', $targetPerObjek->keys())->pluck('nama', 'id');
        $rankingObjek = $targetPerObjek
            ->map(function ($target, $objekId) use ($realisasiPerObjek, $namaObjek) {
                $realisasi = (float) $realisasiPerObjek->get($objekId, 0);

                return [
                    'id' => $objekId,
                    'nama' => $namaObjek->get($objekId, 'Objek tidak ditemukan'),
                    'target' => $target,
                    'realisasi' => $realisasi,
                    'persentase' => $target > 0 ? min(100, ($realisasi / $target) * 100) : 0,
                ];
            })
            ->sortByDesc('persentase')
            ->values();

        $peringatanObjek = $rankingObjek
            ->filter(fn ($objek) => $objek['persentase'] < 80)
            ->values();

        $targetPerPetugas = Jukir::query()
            ->where('status', 'aktif')
            ->with(['penempatanJukirs' => function ($query) use ($targetPerLokasi) {
                $query->where('status', 'aktif')
                    ->whereIn('titik_parkir_id', $targetPerLokasi->keys());
            }])
            ->get()
            ->mapWithKeys(function ($petugas) use ($targetPerLokasi) {
                return [$petugas->id => $petugas->penempatanJukirs->sum(
                    fn ($penempatan) => $targetPerLokasi->get($penempatan->titik_parkir_id, 0)
                )];
            })
            ->filter(fn ($target) => $target > 0);

        $realisasiPerPetugas = Setoran::query()
            ->where('status', 'terverifikasi')
            ->whereYear('tanggal', $tahunDashboard)
            ->whereMonth('tanggal', $bulanDashboard)
            ->whereIn('jukir_id', $targetPerPetugas->keys())
            ->selectRaw('jukir_id, SUM(jumlah_setoran) AS total')
            ->groupBy('jukir_id')
            ->pluck('total', 'jukir_id');

        $namaPetugas = Jukir::whereIn('id', $targetPerPetugas->keys())->pluck('nama', 'id');
        $rankingPetugas = $targetPerPetugas
            ->map(function ($target, $jukirId) use ($realisasiPerPetugas, $namaPetugas) {
                $realisasi = (float) $realisasiPerPetugas->get($jukirId, 0);

                return [
                    'nama' => $namaPetugas->get($jukirId, 'Petugas tidak ditemukan'),
                    'target' => $target,
                    'realisasi' => $realisasi,
                    'persentase' => $target > 0 ? min(100, ($realisasi / $target) * 100) : 0,
                ];
            })
            ->sortByDesc('persentase')
            ->values();

        $targetBulanIni = $targetPerSumber->sum();
        $realisasiBulanIni = $realisasiPerSumber->sum();
        $persentaseCapaianBulanIni = $targetBulanIni > 0
            ? min(100, ($realisasiBulanIni / $targetBulanIni) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | STATUS SETORAN
        |--------------------------------------------------------------------------
        */

        $setoranBelumVerifikasi = Setoran::where(
            'status',
            'belum_verifikasi'
        )->count();

        $setoranTerverifikasi = Setoran::where(
            'status',
            'terverifikasi'
        )->count();

        $setoranDitolak = Setoran::where(
            'status',
            'ditolak'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | SETORAN TERBARU
        |--------------------------------------------------------------------------
        */

        $setoranTerbaru = Setoran::query()
            ->with([
                'jukir',
                'titikParkir',
                'titikParkir.jenisParkir',
                'sumberPemasukan',
                'diverifikasiOleh',
            ])
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DATA PENEMPATAN TERBARU
        |--------------------------------------------------------------------------
        */

        $penempatanTerbaru = PenempatanJukir::query()
            ->with([
                'jukir',
                'titikParkir',
            ])
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TITIK PARKIR TERBARU
        |--------------------------------------------------------------------------
        */

        $titikParkirTerbaru = TitikParkir::query()
            ->with([
                'kecamatan',
                'kelurahan',
                'jenisParkir',
            ])
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DATA DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(

                /*
                |--------------------------------------------------------------
                | JUKIR
                |--------------------------------------------------------------
                */

                'totalJukir',
                'jukirAktif',

                /*
                |--------------------------------------------------------------
                | TITIK PARKIR
                |--------------------------------------------------------------
                */

                'totalTitikParkir',
                'titikParkirAktif',

                /*
                |--------------------------------------------------------------
                | PENEMPATAN
                |--------------------------------------------------------------
                */

                'totalPenempatan',
                'penempatanAktif',

                /*
                |--------------------------------------------------------------
                | TARIF
                |--------------------------------------------------------------
                */

                'totalTarif',
                'tarifAktif',

                /*
                |--------------------------------------------------------------
                | POTENSI PARKIR
                |--------------------------------------------------------------
                */

                'potensiHarian',
                'potensiBulanan',
                'potensiTahunanDashboard',
                'targetTahunanDashboard',
                'realisasiTahunanDashboard',
                'persentaseCapaianTahunanDashboard',
                'potensiBelumTergaliTahunanDashboard',
                'totalAreaAsetDashboard',
                'areaAsetDimanfaatkanDashboard',
                'persentasePemanfaatanAsetDashboard',
                'trenPendapatanDashboard',

                /*
                |--------------------------------------------------------------
                | SETORAN
                |--------------------------------------------------------------
                */

                'totalSetoran',
                'totalPendapatanBruto',
                'totalJumlahSetoran',
                'totalSelisih',
                'pendapatanPerSumber',
                'tahunDashboard',
                'bulanDashboard',
                'targetBulanIni',
                'realisasiBulanIni',
                'persentaseCapaianBulanIni',
                'rankingPendapatan',
                'peringatanPendapatan',
                'rankingLokasi',
                'peringatanLokasi',
                'rankingObjek',
                'peringatanObjek',
                'rankingPetugas',
                'petugasCapaianHarian',
                'jumlahPetugasTercapai',
                'jumlahPetugasBelumTercapai',
                'jumlahPetugasTanpaTarget',
                'tanggalFilter',

                /*
                |--------------------------------------------------------------
                | STATUS SETORAN
                |--------------------------------------------------------------
                */

                'setoranBelumVerifikasi',
                'setoranTerverifikasi',
                'setoranDitolak',

                /*
                |--------------------------------------------------------------
                | DATA TERBARU
                |--------------------------------------------------------------
                */

                'setoranTerbaru',
                'penempatanTerbaru',
                'titikParkirTerbaru'
            )
        );
    }
}