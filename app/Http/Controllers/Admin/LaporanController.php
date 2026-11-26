<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jukir;
use App\Models\JenisJukir;
use App\Models\JenisParkir;
use App\Models\TitikParkir;
use App\Models\PenempatanJukir;
use App\Models\Tarif;
use Illuminate\Http\Request;
use App\Models\Setoran;
use App\Models\SumberPemasukan;
use App\Models\TargetPendapatan;
use App\Models\Tagihan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanController extends Controller
{
    public function tunggakan(Request $request)
    {
        $sourceId = $request->input('sumber_pemasukan_id');
        $hanyaTerlambat = $request->boolean('terlambat');
        $baseQuery = Tagihan::with(['sumberPemasukan', 'objekPendapatan', 'unitUsaha', 'pembayarans'])
            ->whereIn('status', ['terbit', 'sebagian'])
            ->when($sourceId, fn ($query) => $query->where('sumber_pemasukan_id', $sourceId));

        $allTagihans = (clone $baseQuery)->get()->filter(fn ($tagihan) => ! $hanyaTerlambat || $tagihan->terlambat);
        $tagihans = $allTagihans->forPage($request->integer('page', 1), 15);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $tagihans,
            $allTagihans->count(),
            15,
            $request->integer('page', 1),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.laporan.tunggakan', [
            'tagihans' => $paginator,
            'sourceId' => $sourceId,
            'hanyaTerlambat' => $hanyaTerlambat,
            'totalTagihan' => $allTagihans->sum(fn ($tagihan) => (float) $tagihan->nilai_tagihan),
            'totalDibayar' => $allTagihans->sum(fn ($tagihan) => $tagihan->total_dibayar),
            'totalTunggakan' => $allTagihans->sum(fn ($tagihan) => $tagihan->sisa_tagihan),
            'sumberPemasukans' => SumberPemasukan::where('status', true)->orderBy('nama')->get(),
        ]);
    }

    public function exportAnalisisPendapatan(Request $request)
    {
        $tahun = (int) $request->input('tahun', now()->year);
        $bulan = (int) $request->input('bulan', now()->month);
        [$bulanAwal, $bulanAkhir, $periodeLabel] = $this->resolvePeriod($request, $bulan);
        $targets = TargetPendapatan::query()
            ->with(['sumberPemasukan', 'titikParkir', 'objekPendapatan'])
            ->where('tahun', $tahun)
            ->whereBetween('bulan', [$bulanAwal, $bulanAkhir])
            ->get();

        return response()->streamDownload(function () use ($targets, $tahun, $periodeLabel, $bulanAwal, $bulanAkhir) {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Tahun', 'Periode', 'Sumber', 'Scope', 'Objek', 'Target', 'Realisasi', 'Selisih', 'Capaian (%)']);

            foreach ($targets as $target) {
                $query = Setoran::query()
                    ->where('status', 'terverifikasi')
                    ->whereYear('tanggal', $tahun)
                    ->whereBetween('tanggal', [Carbon::create($tahun, $bulanAwal, 1)->startOfMonth(), Carbon::create($tahun, $bulanAkhir, 1)->endOfMonth()])
                    ->where('sumber_pemasukan_id', $target->sumber_pemasukan_id);

                if ($target->objek_pendapatan_id) {
                    $scope = 'Objek pendapatan';
                    $namaObjek = $target->objekPendapatan?->nama ?? '-';
                    $query->where('objek_pendapatan_id', $target->objek_pendapatan_id);
                } elseif ($target->titik_parkir_id) {
                    $scope = 'Titik parkir';
                    $namaObjek = $target->titikParkir?->nama ?? '-';
                    $query->where('titik_parkir_id', $target->titik_parkir_id);
                } else {
                    $scope = 'Agregat sumber';
                    $namaObjek = '-';
                    $query->whereNull('objek_pendapatan_id')->whereNull('titik_parkir_id');
                }

                $targetValue = (float) $target->target;
                $realisasi = (float) $query->sum('jumlah_setoran');
                fputcsv($output, [
                    $tahun,
                    $periodeLabel,
                    $this->sanitizeSpreadsheetValue($target->sumberPemasukan?->nama ?? '-'),
                    $scope,
                    $this->sanitizeSpreadsheetValue($namaObjek),
                    $targetValue,
                    $realisasi,
                    $targetValue - $realisasi,
                    $targetValue > 0 ? min(100, ($realisasi / $targetValue) * 100) : 0,
                ]);
            }

            fclose($output);
        }, "analisis-pendapatan-{$tahun}-{$periodeLabel}.csv", [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function analisisPendapatan(Request $request)
    {
        $tahun = (int) $request->input('tahun', now()->year);
        $bulan = (int) $request->input('bulan', now()->month);
        $sourceId = $request->input('sumber_pemasukan_id');
        [$bulanAwal, $bulanAkhir, $periodeLabel] = $this->resolvePeriod($request, $bulan);

        $targets = TargetPendapatan::query()
            ->with(['sumberPemasukan', 'titikParkir', 'objekPendapatan'])
            ->where('tahun', $tahun)
            ->whereBetween('bulan', [$bulanAwal, $bulanAkhir])
            ->when($sourceId, fn ($query) => $query->where('sumber_pemasukan_id', $sourceId))
            ->get();

        $targetPerSumber = $targets->groupBy('sumber_pemasukan_id')->map(function ($items) {
            $hasScopedTargets = $items->contains(fn ($item) => $item->titik_parkir_id !== null || $item->objek_pendapatan_id !== null);

            return (float) $items
                ->filter(fn ($item) => $hasScopedTargets
                    ? $item->titik_parkir_id !== null || $item->objek_pendapatan_id !== null
                    : $item->titik_parkir_id === null && $item->objek_pendapatan_id === null)
                ->sum('target');
        });

        $realisasiPerSumber = Setoran::query()
            ->where('status', 'terverifikasi')
            ->whereYear('tanggal', $tahun)
            ->whereBetween('tanggal', [Carbon::create($tahun, $bulanAwal, 1)->startOfMonth(), Carbon::create($tahun, $bulanAkhir, 1)->endOfMonth()])
            ->when($sourceId, fn ($query) => $query->where('sumber_pemasukan_id', $sourceId))
            ->selectRaw('sumber_pemasukan_id, SUM(jumlah_setoran) AS total')
            ->groupBy('sumber_pemasukan_id')
            ->pluck('total', 'sumber_pemasukan_id');

        $sumberPemasukans = SumberPemasukan::where('status', true)->when($sourceId, fn ($query) => $query->whereKey($sourceId))->orderBy('nama')->get();
        $analisisSumber = $sumberPemasukans->map(function ($sumber) use ($targetPerSumber, $realisasiPerSumber) {
            $target = (float) $targetPerSumber->get($sumber->id, 0);
            $realisasi = (float) $realisasiPerSumber->get($sumber->id, 0);

            return [
                'nama' => $sumber->nama,
                'target' => $target,
                'realisasi' => $realisasi,
                'selisih' => $target - $realisasi,
                'persentase' => $target > 0 ? min(100, ($realisasi / $target) * 100) : 0,
            ];
        })->sortByDesc('persentase')->values();

        $targetPerLokasi = $targets
            ->filter(fn ($target) => $target->titik_parkir_id !== null)
            ->groupBy('titik_parkir_id')
            ->map(fn ($items) => (float) $items->sum('target'));

        $realisasiPerLokasi = Setoran::query()
            ->where('status', 'terverifikasi')
            ->whereYear('tanggal', $tahun)
            ->whereBetween('tanggal', [Carbon::create($tahun, $bulanAwal, 1)->startOfMonth(), Carbon::create($tahun, $bulanAkhir, 1)->endOfMonth()])
            ->whereNotNull('titik_parkir_id')
            ->selectRaw('titik_parkir_id, SUM(jumlah_setoran) AS total')
            ->groupBy('titik_parkir_id')
            ->pluck('total', 'titik_parkir_id');

        $analisisLokasi = $targets
            ->filter(fn ($target) => $target->titik_parkir_id !== null)
            ->groupBy('titik_parkir_id')
            ->map(function ($items, $titikParkirId) use ($targetPerLokasi, $realisasiPerLokasi) {
                $target = (float) $targetPerLokasi->get($titikParkirId, 0);
                $realisasi = (float) $realisasiPerLokasi->get($titikParkirId, 0);

                return [
                    'nama' => $items->first()->titikParkir?->nama ?? 'Lokasi tidak ditemukan',
                    'target' => $target,
                    'realisasi' => $realisasi,
                    'selisih' => $target - $realisasi,
                    'persentase' => $target > 0 ? min(100, ($realisasi / $target) * 100) : 0,
                ];
            })
            ->sortByDesc('persentase')
            ->values();

        $targetPerObjek = $targets
            ->filter(fn ($target) => $target->objek_pendapatan_id !== null)
            ->groupBy('objek_pendapatan_id')
            ->map(fn ($items) => (float) $items->sum('target'));

        $realisasiPerObjek = Setoran::query()
            ->where('status', 'terverifikasi')
            ->whereYear('tanggal', $tahun)
            ->whereBetween('tanggal', [Carbon::create($tahun, $bulanAwal, 1)->startOfMonth(), Carbon::create($tahun, $bulanAkhir, 1)->endOfMonth()])
            ->whereNotNull('objek_pendapatan_id')
            ->selectRaw('objek_pendapatan_id, SUM(jumlah_setoran) AS total')
            ->groupBy('objek_pendapatan_id')
            ->pluck('total', 'objek_pendapatan_id');

        $analisisObjek = $targets
            ->filter(fn ($target) => $target->objek_pendapatan_id !== null)
            ->groupBy('objek_pendapatan_id')
            ->map(function ($items, $objekId) use ($targetPerObjek, $realisasiPerObjek) {
                $target = (float) $targetPerObjek->get($objekId, 0);
                $realisasi = (float) $realisasiPerObjek->get($objekId, 0);

                return [
                    'nama' => $items->first()->objekPendapatan?->nama ?? 'Objek tidak ditemukan',
                    'target' => $target,
                    'realisasi' => $realisasi,
                    'selisih' => $target - $realisasi,
                    'persentase' => $target > 0 ? min(100, ($realisasi / $target) * 100) : 0,
                ];
            })
            ->sortByDesc('persentase')
            ->values();

        $totalTarget = $targetPerSumber->sum();
        $totalRealisasi = $realisasiPerSumber->sum();
        $totalSelisih = $totalTarget - $totalRealisasi;
        $persentase = $totalTarget > 0 ? min(100, ($totalRealisasi / $totalTarget) * 100) : 0;

        $reportData = compact(
            'tahun', 'bulan', 'periodeLabel', 'sourceId', 'analisisSumber', 'analisisLokasi', 'analisisObjek',
            'totalTarget', 'totalRealisasi', 'totalSelisih', 'persentase'
        );

        if ($request->boolean('pdf')) {
            return Pdf::loadView('admin.laporan.cetak-analisis-pendapatan', $reportData)
                ->setPaper('a4', 'landscape')
                ->download("analisis-pendapatan-{$tahun}-{$periodeLabel}.pdf");
        }

        if ($request->boolean('excel')) {
            $excelReportData = array_merge($reportData, [
                'analisisSumber' => $analisisSumber->map(fn ($item) => array_merge($item, [
                    'nama' => $this->sanitizeSpreadsheetValue($item['nama']),
                ])),
                'analisisLokasi' => $analisisLokasi->map(fn ($item) => array_merge($item, [
                    'nama' => $this->sanitizeSpreadsheetValue($item['nama']),
                ])),
                'analisisObjek' => $analisisObjek->map(fn ($item) => array_merge($item, [
                    'nama' => $this->sanitizeSpreadsheetValue($item['nama']),
                ])),
            ]);
            $html = view('admin.laporan.excel-analisis-pendapatan', $excelReportData)->render();

            return response()->streamDownload(function () use ($html) {
                echo $html;
            }, "analisis-pendapatan-{$tahun}-{$periodeLabel}.xls", [
                'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            ]);
        }

        if ($request->boolean('xlsx')) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray(['Kelompok', 'Nama', 'Target', 'Realisasi', 'Selisih', 'Capaian (%)'], null, 'A1');
            $row = 2;
            foreach ([['Sumber Pendapatan', $analisisSumber], ['Lokasi', $analisisLokasi], ['Objek Pendapatan', $analisisObjek]] as [$group, $items]) {
                foreach ($items as $item) {
                    $sheet->fromArray([
                        $group,
                        $this->sanitizeSpreadsheetValue($item['nama']),
                        $item['target'],
                        $item['realisasi'],
                        $item['selisih'],
                        $item['persentase'],
                    ], null, "A{$row}");
                    $row++;
                }
            }
            $sheet->getStyle('A1:F1')->getFont()->setBold(true);
            $writer = new Xlsx($spreadsheet);

            return response()->streamDownload(function () use ($writer) {
                $writer->save('php://output');
            }, "analisis-pendapatan-{$tahun}-{$periodeLabel}.xlsx", [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }

        if ($request->boolean('cetak')) {
            return view('admin.laporan.cetak-analisis-pendapatan', $reportData);
        }

        return view('admin.laporan.analisis-pendapatan', $reportData);
    }

    private function sanitizeSpreadsheetValue(mixed $value): mixed
    {
        if (! is_string($value)) {
            return $value;
        }

        // Awali karakter pemicu formula dengan tanda kutip tunggal agar tidak dieksekusi di aplikasi spreadsheet.
        if (preg_match('/^\s*[=+\-@\t\r]/', $value) === 1) {
            return "'" . $value;
        }

        return $value;
    }

    private function resolvePeriod(Request $request, int $bulan): array
    {
        $periode = $request->input('periode', 'bulanan');
        if ($periode === 'triwulan') {
            $awal = intdiv($bulan - 1, 3) * 3 + 1;
            return [$awal, $awal + 2, 'T' . (intdiv($awal - 1, 3) + 1)];
        }
        if ($periode === 'semester') {
            $awal = $bulan <= 6 ? 1 : 7;
            return [$awal, $awal + 5, 'S' . ($awal === 1 ? 1 : 2)];
        }
        if ($periode === 'tahunan') {
            return [1, 12, 'Tahunan'];
        }

        return [$bulan, $bulan, str_pad((string) $bulan, 2, '0', STR_PAD_LEFT)];
    }

    /**
     * Menampilkan halaman laporan utama.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER LAPORAN JUKIR
        |--------------------------------------------------------------------------
        */

        $search = $request->input('search');

        $jenisJukirId = $request->input('jenis_jukir_id');

        $status = $request->input('status');


        /*
        |--------------------------------------------------------------------------
        | DATA JUKIR
        |--------------------------------------------------------------------------
        */

        $jukirs = Jukir::query()
            ->with('jenisJukir')

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('kode_jukir', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%");

                });

            })

            ->when($jenisJukirId, function ($query, $jenisJukirId) {

                $query->where(
                    'jenis_jukir_id',
                    $jenisJukirId
                );

            })

            ->when($status, function ($query, $status) {

                $query->where('status', $status);

            })

            ->orderBy('nama')

            ->paginate(15)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | MASTER JENIS JUKIR
        |--------------------------------------------------------------------------
        */

        $jenisJukirs = JenisJukir::query()
            ->where('status', 1)
            ->orderBy('nama')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | STATUS JUKIR
        |--------------------------------------------------------------------------
        */

        $statuses = Jukir::query()
            ->select('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalJukir = Jukir::count();

        $totalTitikParkir = TitikParkir::count();

        $totalPenempatanAktif = PenempatanJukir::where(
            'status',
            'aktif'
        )->count();

        $totalTarifAktif = Tarif::where(
            'status',
            'true'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | DATA PENEMPATAN TERBARU
        |--------------------------------------------------------------------------
        */

        $penempatans = PenempatanJukir::query()
            ->with([
                'jukir',
                'titikParkir',
            ])
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.index',
            compact(
                'jukirs',
                'jenisJukirs',
                'statuses',
                'search',
                'jenisJukirId',
                'status',
                'totalJukir',
                'totalTitikParkir',
                'totalPenempatanAktif',
                'totalTarifAktif',
                'penempatans'
            )
        );
    }


    /**
     * Cetak laporan data Jukir.
     */
    public function cetak(Request $request)
    {
        $search = $request->input('search');

        $jenisJukirId = $request->input('jenis_jukir_id');

        $status = $request->input('status');


        $jukirs = Jukir::query()
            ->with('jenisJukir')

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('kode_jukir', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%");

                });

            })

            ->when($jenisJukirId, function ($query, $jenisJukirId) {

                $query->where(
                    'jenis_jukir_id',
                    $jenisJukirId
                );

            })

            ->when($status, function ($query, $status) {

                $query->where('status', $status);

            })

            ->orderBy('nama')

            ->get();


        return view(
            'admin.laporan.jukir.cetak',
            compact(
                'jukirs',
                'search',
                'jenisJukirId',
                'status'
            )
        );
    }


    /**
     * Menampilkan laporan Titik Parkir.
     */
    public function titikParkir(Request $request)
    {
        $search = $request->input('search');

        $jenisParkirId = $request->input('jenis_parkir_id');

        $status = $request->input('status');


        /*
        |--------------------------------------------------------------------------
        | DATA TITIK PARKIR
        |--------------------------------------------------------------------------
        */

        $titikParkirs = TitikParkir::query()
            ->with([
                'jenisParkir',
                'targetPendapatans' => fn ($query) => $query->where('tahun', now()->year),
            ])

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('kode_titik', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%");

                });

            })

            ->when($jenisParkirId, function ($query, $jenisParkirId) {

                $query->where(
                    'jenis_parkir_id',
                    $jenisParkirId
                );

            })

            ->when($status, function ($query, $status) {

                $query->where('status', $status);

            })

            ->orderBy('nama')

            ->paginate(15)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | MASTER JENIS PARKIR
        |--------------------------------------------------------------------------
        */

        $jenisParkirs = JenisParkir::query()
            ->where('status', 1)
            ->orderBy('nama')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | STATUS TITIK PARKIR
        |--------------------------------------------------------------------------
        */

        $statuses = TitikParkir::query()
            ->select('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalTitikParkir = TitikParkir::count();

        $totalTitikParkirAktif = TitikParkir::where(
            'status',
            'aktif'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.titik-parkir.index',
            compact(
                'titikParkirs',
                'jenisParkirs',
                'statuses',
                'search',
                'jenisParkirId',
                'status',
                'totalTitikParkir',
                'totalTitikParkirAktif'
            )
        );
    }


    /**
     * Cetak laporan Titik Parkir.
     */
    public function cetakTitikParkir(Request $request)
    {
        $search = $request->input('search');

        $jenisParkirId = $request->input('jenis_parkir_id');

        $status = $request->input('status');


        /*
        |--------------------------------------------------------------------------
        | DATA TITIK PARKIR
        |--------------------------------------------------------------------------
        */

        $titikParkirs = TitikParkir::query()
            ->with([
                'jenisParkir',
                'targetPendapatans' => fn ($query) => $query->where('tahun', now()->year),
            ])

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('kode_titik', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%");

                });

            })

            ->when($jenisParkirId, function ($query, $jenisParkirId) {

                $query->where(
                    'jenis_parkir_id',
                    $jenisParkirId
                );

            })

            ->when($status, function ($query, $status) {

                $query->where('status', $status);

            })

            ->orderBy('nama')

            ->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW CETAK
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.titik-parkir.cetak',
            compact(
                'titikParkirs',
                'search',
                'jenisParkirId',
                'status'
            )
        );
    }


    /**
     * Menampilkan laporan Penempatan Jukir.
     */
    public function penempatanJukir(Request $request)
    {
        $search = $request->input('search');

        $status = $request->input('status');

        $titikParkirId = $request->input('titik_parkir_id');


        /*
        |--------------------------------------------------------------------------
        | DATA PENEMPATAN JUKIR
        |--------------------------------------------------------------------------
        */

        $penempatans = PenempatanJukir::query()
            ->with([
                'jukir',
                'titikParkir',
            ])

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->whereHas('jukir', function ($jukir) use ($search) {

                        $jukir
                            ->where(
                                'kode_jukir',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'nama',
                                'like',
                                "%{$search}%"
                            );

                    })

                    ->orWhereHas('titikParkir', function ($titik) use ($search) {

                        $titik
                            ->where(
                                'kode_titik',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'nama',
                                'like',
                                "%{$search}%"
                            );

                    })

                    ->orWhere(
                        'status',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'surat_penugasan',
                        'like',
                        "%{$search}%"
                    );

                });

            })

            ->when($status, function ($query, $status) {

                $query->where(
                    'status',
                    $status
                );

            })

            ->when($titikParkirId, function ($query, $titikParkirId) {

                $query->where(
                    'titik_parkir_id',
                    $titikParkirId
                );

            })

            ->orderByDesc('tanggal_mulai')

            ->paginate(15)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | MASTER TITIK PARKIR
        |--------------------------------------------------------------------------
        */

        $titikParkirs = TitikParkir::query()
            ->orderBy('nama')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | STATUS PENEMPATAN
        |--------------------------------------------------------------------------
        */

        $statuses = PenempatanJukir::query()
            ->select('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalPenempatan = PenempatanJukir::count();

        $totalPenempatanAktif = PenempatanJukir::where(
            'status',
            'aktif'
        )->count();

        $totalPenempatanSelesai = PenempatanJukir::where(
            'status',
            'selesai'
        )->count();

        $totalPenempatanDibatalkan = PenempatanJukir::where(
            'status',
            'dibatalkan'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.penempatan-jukir.index',
            compact(
                'penempatans',
                'titikParkirs',
                'statuses',
                'search',
                'status',
                'titikParkirId',
                'totalPenempatan',
                'totalPenempatanAktif',
                'totalPenempatanSelesai',
                'totalPenempatanDibatalkan'
            )
        );
    }


    /**
     * Cetak laporan Penempatan Jukir.
     */
    public function cetakPenempatanJukir(Request $request)
    {
        $search = $request->input('search');

        $status = $request->input('status');

        $titikParkirId = $request->input('titik_parkir_id');


        /*
        |--------------------------------------------------------------------------
        | DATA PENEMPATAN JUKIR
        |--------------------------------------------------------------------------
        */

        $penempatans = PenempatanJukir::query()
            ->with([
                'jukir',
                'titikParkir',
            ])

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->whereHas('jukir', function ($jukir) use ($search) {

                        $jukir
                            ->where(
                                'kode_jukir',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'nama',
                                'like',
                                "%{$search}%"
                            );

                    })

                    ->orWhereHas('titikParkir', function ($titik) use ($search) {

                        $titik
                            ->where(
                                'kode_titik',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'nama',
                                'like',
                                "%{$search}%"
                            );

                    })

                    ->orWhere(
                        'status',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'surat_penugasan',
                        'like',
                        "%{$search}%"
                    );

                });

            })

            ->when($status, function ($query, $status) {

                $query->where(
                    'status',
                    $status
                );

            })

            ->when($titikParkirId, function ($query, $titikParkirId) {

                $query->where(
                    'titik_parkir_id',
                    $titikParkirId
                );

            })

            ->orderByDesc('tanggal_mulai')

            ->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW CETAK
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.penempatan-jukir.cetak',
            compact(
                'penempatans',
                'search',
                'status',
                'titikParkirId'
            )
        );
    }


    /**
     * Menampilkan laporan Tarif.
     */
    public function tarif(Request $request)
    {
        $search = $request->input('search');

        $jenisParkirId = $request->input('jenis_parkir_id');

        $status = $request->input('status');


        /*
        |--------------------------------------------------------------------------
        | DATA TARIF
        |--------------------------------------------------------------------------
        */

        $tarifs = Tarif::query()
            ->with('jenisParkir')

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'jenis_kendaraan',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'keterangan',
                        'like',
                        "%{$search}%"
                    );

                });

            })

            ->when($jenisParkirId, function ($query, $jenisParkirId) {

                $query->where(
                    'jenis_parkir_id',
                    $jenisParkirId
                );

            })

            ->when($status !== null && $status !== '', function ($query) use ($status) {
    $query->where('status', $status === '1');
})

            ->latest()

            ->paginate(15)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | MASTER JENIS PARKIR
        |--------------------------------------------------------------------------
        */

        $jenisParkirs = JenisParkir::query()
            ->orderBy('nama')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalTarif = Tarif::count();

        $tarifAktif = Tarif::where(
            'status',
            true
        )->count();

        $tarifTidakAktif = Tarif::where(
            'status',
            false
        )->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.tarif.index',
            compact(
                'tarifs',
                'jenisParkirs',
                'search',
                'jenisParkirId',
                'status',
                'totalTarif',
                'tarifAktif',
                'tarifTidakAktif'
            )
        );
    }


    /**
 * Cetak laporan Tarif.
 */
public function cetakTarif(Request $request)
{
    $search = $request->input('search');

    $jenisParkirId = $request->input('jenis_parkir_id');

    $status = $request->input('status');


    /*
    |--------------------------------------------------------------------------
    | DATA TARIF
    |--------------------------------------------------------------------------
    */

    $tarifs = Tarif::query()
        ->with('jenisParkir')

        ->when($search, function ($query, $search) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'jenis_kendaraan',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'keterangan',
                    'like',
                    "%{$search}%"
                );

            });

        })

        ->when($jenisParkirId, function ($query, $jenisParkirId) {

            $query->where(
                'jenis_parkir_id',
                $jenisParkirId
            );

        })

        ->when($status !== null && $status !== '', function ($query) use ($status) {

            $query->where(
                'status',
                $status === '1'
            );

        })

        ->orderBy('jenis_parkir_id')
        ->orderBy('jenis_kendaraan')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | VIEW CETAK
    |--------------------------------------------------------------------------
    */

    return view(
        'admin.laporan.tarif.cetak',
        compact(
            'tarifs',
            'search',
            'jenisParkirId',
            'status'
        )
    );
}
   /**
 * Menampilkan laporan Setoran.
 */
public function setoran(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

    $search = $request->input('search');

    $jukirId = $request->input('jukir_id');

    $titikParkirId = $request->input('titik_parkir_id');

    $status = $request->input('status');

    $tanggalMulai = $request->input('tanggal_mulai');

    $tanggalSelesai = $request->input('tanggal_selesai');


    /*
    |--------------------------------------------------------------------------
    | QUERY DASAR
    |--------------------------------------------------------------------------
    */

    $baseQuery = Setoran::query()
        ->with([
            'jukir',
            'titikParkir',
            'diverifikasiOleh',
        ]);


    /*
    |--------------------------------------------------------------------------
    | PENCARIAN
    |--------------------------------------------------------------------------
    */

    $baseQuery->when($search, function ($query, $search) {

        $query->where(function ($q) use ($search) {

            $q->whereHas('jukir', function ($jukir) use ($search) {

                $jukir
                    ->where('kode_jukir', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");

            })

            ->orWhereHas('titikParkir', function ($titik) use ($search) {

                $titik
                    ->where('kode_titik', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");

            })

            ->orWhere(
                'keterangan',
                'like',
                "%{$search}%"
            );

        });

    });


    /*
    |--------------------------------------------------------------------------
    | FILTER JUKIR
    |--------------------------------------------------------------------------
    */

    $baseQuery->when($jukirId, function ($query, $jukirId) {

        $query->where(
            'jukir_id',
            $jukirId
        );

    });


    /*
    |--------------------------------------------------------------------------
    | FILTER TITIK PARKIR
    |--------------------------------------------------------------------------
    */

    $baseQuery->when($titikParkirId, function ($query, $titikParkirId) {

        $query->where(
            'titik_parkir_id',
            $titikParkirId
        );

    });


    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL MULAI
    |--------------------------------------------------------------------------
    */

    $baseQuery->when($tanggalMulai, function ($query, $tanggalMulai) {

        $query->whereDate(
            'tanggal',
            '>=',
            $tanggalMulai
        );

    });


    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL SELESAI
    |--------------------------------------------------------------------------
    */

    $baseQuery->when($tanggalSelesai, function ($query, $tanggalSelesai) {

        $query->whereDate(
            'tanggal',
            '<=',
            $tanggalSelesai
        );

    });


    /*
    |--------------------------------------------------------------------------
    | QUERY UNTUK TABEL
    |--------------------------------------------------------------------------
    |
    | Query tabel menggunakan SEMUA filter termasuk status.
    |
    */

    $tableQuery = clone $baseQuery;

    $tableQuery->when(
        $status !== null && $status !== '',
        function ($query) use ($status) {

            $query->where(
                'status',
                $status
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DATA LAPORAN
    |--------------------------------------------------------------------------
    */

    $setorans = $tableQuery
        ->orderByDesc('tanggal')
        ->orderByDesc('id')
        ->paginate(15)
        ->withQueryString();


    /*
    |--------------------------------------------------------------------------
    | RINGKASAN UTAMA
    |--------------------------------------------------------------------------
    |
    | Ringkasan mengikuti semua filter termasuk status.
    |
    */

    $totalSetoran = (clone $tableQuery)->count();

    $totalPendapatanBruto = (clone $tableQuery)
        ->sum('pendapatan_bruto');

    $totalJumlahSetoran = (clone $tableQuery)
        ->sum('jumlah_setoran');

    $totalSelisih = (clone $tableQuery)
        ->sum('selisih');


    /*
    |--------------------------------------------------------------------------
    | RINGKASAN STATUS
    |--------------------------------------------------------------------------
    |
    | Status TIDAK memakai filter status.
    |
    | Contoh:
    |
    | Jukir = JKR001
    | Tanggal = Agustus 2026
    |
    | Maka kartu status menunjukkan distribusi
    | semua status pada periode tersebut.
    |
    */

    $totalBelumVerifikasi = (clone $baseQuery)
        ->where('status', 'belum_verifikasi')
        ->count();

    $totalTerverifikasi = (clone $baseQuery)
        ->where('status', 'terverifikasi')
        ->count();

    $totalDitolak = (clone $baseQuery)
        ->where('status', 'ditolak')
        ->count();


    /*
    |--------------------------------------------------------------------------
    | MASTER JUKIR
    |--------------------------------------------------------------------------
    */

    $jukirs = Jukir::query()
        ->orderBy('nama')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | MASTER TITIK PARKIR
    |--------------------------------------------------------------------------
    */

    $titikParkirs = TitikParkir::query()
        ->orderBy('nama')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    $statuses = Setoran::query()
        ->select('status')
        ->whereNotNull('status')
        ->distinct()
        ->orderBy('status')
        ->pluck('status');


    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    return view(
        'admin.laporan.setoran.index',
        compact(

            'setorans',

            'jukirs',

            'titikParkirs',

            'statuses',

            'search',

            'jukirId',

            'titikParkirId',

            'status',

            'tanggalMulai',

            'tanggalSelesai',

            'totalSetoran',

            'totalPendapatanBruto',

            'totalJumlahSetoran',

            'totalSelisih',

            'totalBelumVerifikasi',

            'totalTerverifikasi',

            'totalDitolak'

        )
    );
}


    /**
     * Cetak laporan Setoran.
     */
    public function cetakSetoran(Request $request)
    {
        $search = $request->input('search');

        $jukirId = $request->input('jukir_id');

        $titikParkirId = $request->input('titik_parkir_id');

        $status = $request->input('status');

        $tanggalMulai = $request->input('tanggal_mulai');

        $tanggalSelesai = $request->input('tanggal_selesai');


        /*
        |--------------------------------------------------------------------------
        | DATA SETORAN
        |--------------------------------------------------------------------------
        */

        $setorans = Setoran::query()
            ->with([
                'jukir',
                'titikParkir',
                'diverifikasiOleh',
            ])

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->whereHas('jukir', function ($jukir) use ($search) {

                        $jukir
                            ->where(
                                'kode_jukir',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'nama',
                                'like',
                                "%{$search}%"
                            );

                    })

                    ->orWhereHas('titikParkir', function ($titik) use ($search) {

                        $titik
                            ->where(
                                'kode_titik',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'nama',
                                'like',
                                "%{$search}%"
                            );

                    })

                    ->orWhere(
                        'keterangan',
                        'like',
                        "%{$search}%"
                    );

                });

            })

            ->when($jukirId, function ($query, $jukirId) {

                $query->where(
                    'jukir_id',
                    $jukirId
                );

            })

            ->when($titikParkirId, function ($query, $titikParkirId) {

                $query->where(
                    'titik_parkir_id',
                    $titikParkirId
                );

            })

            ->when(
                $status !== null && $status !== '',
                function ($query) use ($status) {

                    $query->where(
                        'status',
                        $status
                    );

                }
            )

            ->when($tanggalMulai, function ($query, $tanggalMulai) {

                $query->whereDate(
                    'tanggal',
                    '>=',
                    $tanggalMulai
                );

            })

            ->when($tanggalSelesai, function ($query, $tanggalSelesai) {

                $query->whereDate(
                    'tanggal',
                    '<=',
                    $tanggalSelesai
                );

            })

            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW CETAK
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.setoran.cetak',
            compact(
                'setorans',
                'search',
                'jukirId',
                'titikParkirId',
                'status',
                'tanggalMulai',
                'tanggalSelesai'
            )
        );
    }

    public function jenis(Request $request, SumberPemasukan $sumberPemasukan)
    {
        $request->merge(['sumber_pemasukan_id' => $sumberPemasukan->id]);

        return $this->analisisPendapatan($request);
    }
}