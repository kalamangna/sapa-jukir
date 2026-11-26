<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSetoranRequest;
use App\Http\Requests\UpdateSetoranRequest;
use App\Models\Jukir;
use App\Models\KarcisAllocation;
use App\Models\Setoran;
use App\Models\SumberPemasukan;
use App\Models\TitikParkir;
use App\Models\ObjekPendapatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\KarcisSeriesParser;

class SetoranController extends Controller
{
    /**
     * Menampilkan daftar setoran.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $search = $request->input('search');
        $jukirId = $request->input('jukir_id');
        $titikParkirId = $request->input('titik_parkir_id');
        $sumberPemasukanId = $request->input('sumber_pemasukan_id');
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
                'titikParkir.jenisParkir',
                'sumberPemasukan',
                'karcisUsages.allocation.sumberPemasukan',
                'diverifikasiOleh',
            ])

            /*
            |--------------------------------------------------------------------------
            | PENCARIAN
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | FILTER JUKIR
            |--------------------------------------------------------------------------
            */

            ->when($jukirId, function ($query, $jukirId) {

                $query->where(
                    'jukir_id',
                    $jukirId
                );

            })


            /*
            |--------------------------------------------------------------------------
            | FILTER TITIK PARKIR
            |--------------------------------------------------------------------------
            */

            ->when($titikParkirId, function ($query, $titikParkirId) {

                $query->where(
                    'titik_parkir_id',
                    $titikParkirId
                );

            })

            ->when($sumberPemasukanId, function ($query, $sumberPemasukanId) {
                $query->where('sumber_pemasukan_id', $sumberPemasukanId);
            })


            /*
            |--------------------------------------------------------------------------
            | FILTER STATUS
            |--------------------------------------------------------------------------
            */

            ->when(
                $status !== null && $status !== '',
                function ($query) use ($status) {

                    $query->where(
                        'status',
                        $status
                    );

                }
            )


            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL MULAI
            |--------------------------------------------------------------------------
            */

            ->when($tanggalMulai, function ($query, $tanggalMulai) {

                $query->whereDate(
                    'tanggal',
                    '>=',
                    $tanggalMulai
                );

            })


            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL SELESAI
            |--------------------------------------------------------------------------
            */

            ->when($tanggalSelesai, function ($query, $tanggalSelesai) {

                $query->whereDate(
                    'tanggal',
                    '<=',
                    $tanggalSelesai
                );

            })


            /*
            |--------------------------------------------------------------------------
            | URUTKAN
            |--------------------------------------------------------------------------
            */

            ->orderByDesc('tanggal')
            ->orderByDesc('id')


            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

            ->paginate(15)
            ->withQueryString();


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
            ->with('jenisParkir')
            ->orderBy('nama')
            ->get();

        $sumberPemasukans = SumberPemasukan::where('status', true)->orderBy('nama')->get();

        $objekPendapatans = ObjekPendapatan::query()
            ->with('sumberPemasukan')
            ->where('status', 'aktif')
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
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalSetoran = Setoran::count();

        $totalPendapatanBruto = Setoran::sum(
            'pendapatan_bruto'
        );

        $totalJumlahSetoran = Setoran::sum(
            'jumlah_setoran'
        );

        $totalSelisih = Setoran::sum(
            'selisih'
        );


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN STATUS
        |--------------------------------------------------------------------------
        */

        $totalBelumVerifikasi = Setoran::where(
            'status',
            'belum_verifikasi'
        )->count();

        $totalTerverifikasi = Setoran::where(
            'status',
            'terverifikasi'
        )->count();

        $totalDitolak = Setoran::where(
            'status',
            'ditolak'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.setoran.index',
            compact(
                'setorans',
                'jukirs',
                'titikParkirs',
                'sumberPemasukans',
                'statuses',

                'search',
                'jukirId',
                'titikParkirId',
                'sumberPemasukanId',
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
     * Menampilkan form tambah setoran.
     */
    public function create()
    {
        /*
        |--------------------------------------------------------------------------
        | DATA JUKIR AKTIF
        |--------------------------------------------------------------------------
        */

        $jukirs = Jukir::query()
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DATA TITIK PARKIR AKTIF
        |--------------------------------------------------------------------------
        */

        $titikParkirs = TitikParkir::query()
            ->with('jenisParkir')
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        $sumberPemasukans = SumberPemasukan::where('status', true)->orderBy('nama')->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        $karcisAllocations = KarcisAllocation::query()
            ->with(['sumberPemasukan', 'jukir'])
            ->withCount('usages')
            ->orderBy('tanggal_penyerahan')
            ->get()
            ->filter(fn (KarcisAllocation $allocation) => $allocation->jumlah_tersedia > 0);

        return view(
            'admin.setoran.create',
            compact(
                'jukirs',
                'titikParkirs',
                'sumberPemasukans',
                'karcisAllocations'
            )
        );
    }


    /**
     * Menyimpan setoran baru.
     */
    public function store(StoreSetoranRequest $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $ticket = $this->validateTicketLines($validated);
            $pendapatanBruto = $ticket['bruto'];
            $jumlahSetoran = (float) $validated['jumlah_setoran'];

            $setoran = Setoran::create([
                'sumber_pemasukan_id' => $validated['sumber_pemasukan_id'],
                'objek_pendapatan_id' => $validated['objek_pendapatan_id'] ?? null,
                'jukir_id' => $validated['jukir_id'] ?? null,
                'titik_parkir_id' => $validated['titik_parkir_id'] ?? null,
                'tanggal' => $validated['tanggal'],
                'jumlah_motor' => $validated['jumlah_motor'] ?? null,
                'jumlah_mobil' => $validated['jumlah_mobil'] ?? null,
                'jumlah_mobil_kecil' => $validated['jumlah_mobil_kecil'] ?? $validated['jumlah_mobil'] ?? null,
                'jumlah_mobil_besar' => $validated['jumlah_mobil_besar'] ?? null,
                'karcis_nomor' => json_encode($ticket['display'], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                'jumlah_karcis' => $ticket['jumlah'],
                'pendapatan_bruto' => $pendapatanBruto,
                'jumlah_setoran' => $jumlahSetoran,
                'selisih' => $pendapatanBruto - $jumlahSetoran,
                'status' => 'belum_verifikasi',
                'keterangan' => $validated['keterangan'] ?? null,
                'diverifikasi_at' => null,
                'diverifikasi_oleh' => null,
            ]);

            $this->saveTicketNumbers($setoran->id, $ticket['lines']);
        });


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.setoran.index')
            ->with(
                'success',
                'Data setoran berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail setoran.
     */
    public function show(string $id)
    {
        $setoran = Setoran::query()
            ->with([
                'jukir',
                'titikParkir',
                'diverifikasiOleh',
                'karcisUsages.allocation.sumberPemasukan',
            ])
            ->findOrFail($id);


        return view(
            'admin.setoran.show',
            compact('setoran')
        );
    }


    /**
     * Menampilkan form edit setoran.
     */
    public function edit(string $id)
    {
        $setoran = Setoran::with('karcisUsages.allocation')->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | CEGAH EDIT SETORAN YANG SUDAH DIPROSES
        |--------------------------------------------------------------------------
        */

        if ($setoran->status !== 'belum_verifikasi') {

            return redirect()
                ->route(
                    'admin.setoran.show',
                    $setoran->id
                )
                ->with(
                    'error',
                    'Setoran yang sudah diproses tidak dapat diedit.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DATA JUKIR
        |--------------------------------------------------------------------------
        */

        $jukirs = Jukir::query()
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DATA TITIK PARKIR
        |--------------------------------------------------------------------------
        */

        $titikParkirs = TitikParkir::query()
            ->with('jenisParkir')
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        $sumberPemasukans = SumberPemasukan::where('status', true)->orderBy('nama')->get();
        $karcisAllocations = KarcisAllocation::query()
            ->with(['sumberPemasukan', 'jukir'])
            ->withCount('usages')
            ->orderBy('tanggal_penyerahan')
            ->get()
            ->filter(fn (KarcisAllocation $allocation) => $allocation->jumlah_tersedia > 0
                || $allocation->usages()->where('setoran_id', $setoran->id)->exists());
        $ticketLines = $setoran->karcisUsages
            ->groupBy('karcis_allocation_id')
            ->map(fn ($usages, $allocationId) => [
                'allocation_id' => $allocationId,
                'nomor' => $usages->pluck('nomor_seri')->implode(', '),
            ])
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.setoran.edit',
            compact(
                'setoran',
                'jukirs',
                'titikParkirs',
                'sumberPemasukans',
                'karcisAllocations',
                'ticketLines'
            )
        );
    }


    /**
     * Memperbarui data setoran.
     */
    public function update(
        UpdateSetoranRequest $request,
        string $id
    ) {

        $setoran = Setoran::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | CEGAH UPDATE SETORAN YANG SUDAH DIPROSES
        |--------------------------------------------------------------------------
        */

        if ($setoran->status !== 'belum_verifikasi') {

            return redirect()
                ->route(
                    'admin.setoran.show',
                    $setoran->id
                )
                ->with(
                    'error',
                    'Setoran yang sudah diproses tidak dapat diubah.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validated();


        /*
        |--------------------------------------------------------------------------
        | HITUNG ULANG SELISIH
        |--------------------------------------------------------------------------
        */

        $jumlahSetoran =
            (float) $validated['jumlah_setoran'];
        DB::transaction(function () use ($validated, $setoran, $jumlahSetoran) {
            $updates = [
                'sumber_pemasukan_id' => $validated['sumber_pemasukan_id'],
                'jukir_id' => $validated['jukir_id'] ?? null,
                'titik_parkir_id' => $validated['titik_parkir_id'] ?? null,
                'tanggal' => $validated['tanggal'],
                'jumlah_motor' => $validated['jumlah_motor'] ?? null,
                'jumlah_mobil' => $validated['jumlah_mobil'] ?? null,
                'jumlah_mobil_kecil' => $validated['jumlah_mobil_kecil'] ?? $validated['jumlah_mobil'] ?? null,
                'jumlah_mobil_besar' => $validated['jumlah_mobil_besar'] ?? null,
                'jumlah_setoran' => $jumlahSetoran,
                'keterangan' => $validated['keterangan'] ?? null,
            ];

            if (!empty($validated['karcis_lines'])) {
                $ticket = $this->validateTicketLines($validated, $setoran->id);
                $pendapatanBruto = $ticket['bruto'];
                $updates += [
                    'karcis_nomor' => json_encode($ticket['display'], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                    'jumlah_karcis' => $ticket['jumlah'],
                    'pendapatan_bruto' => $pendapatanBruto,
                    'selisih' => $pendapatanBruto - $jumlahSetoran,
                ];

                DB::table('karcis_usages')->where('setoran_id', $setoran->id)->delete();
                $setoran->update($updates);
                $this->saveTicketNumbers($setoran->id, $ticket['lines']);

                return;
            }

            if ($setoran->karcisUsages()->exists()) {
                throw ValidationException::withMessages([
                    'karcis_lines' => 'Setoran ini sudah mencatat karcis. Pilih rentang karcis yang valid.',
                ]);
            }

            $pendapatanBruto = (float) $validated['pendapatan_bruto'];
            $updates['pendapatan_bruto'] = $pendapatanBruto;
            $updates['selisih'] = $pendapatanBruto - $jumlahSetoran;
            $setoran->update($updates);
        });


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.setoran.index')
            ->with(
                'success',
                'Data setoran berhasil diperbarui.'
            );
    }


    /**
     * Memverifikasi atau menolak setoran.
     */
    public function verifikasi(
        Request $request,
        string $id
    ) {

        $setoran = Setoran::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | CEK STATUS
        |--------------------------------------------------------------------------
        */

        if ($setoran->status !== 'belum_verifikasi') {

            return redirect()
                ->route(
                    'admin.setoran.show',
                    $setoran->id
                )
                ->with(
                    'error',
                    'Setoran ini sudah diproses dan tidak dapat diverifikasi kembali.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'status' => [
                'required',
                'in:terverifikasi,ditolak',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | UPDATE VERIFIKASI
        |--------------------------------------------------------------------------
        */

        $setoran->update([

            'status' =>
                $validated['status'],

            'keterangan' =>
                $validated['keterangan']
                ?? $setoran->keterangan,

            'diverifikasi_at' =>
                now(),

            'diverifikasi_oleh' =>
                Auth::id(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.setoran.show',
                $setoran->id
            )
            ->with(
                'success',
                $validated['status'] === 'terverifikasi'
                    ? 'Setoran berhasil diverifikasi.'
                    : 'Setoran berhasil ditolak.'
            );
    }


    /**
     * Menghapus data setoran.
     */
    public function destroy(string $id)
    {
        $setoran = Setoran::findOrFail($id);

        if (DB::table('karcis_usages')->where('setoran_id', $setoran->id)->exists()) {
            return redirect()
                ->route('admin.setoran.show', $setoran->id)
                ->with('error', 'Setoran dengan seri karcis tercatat tidak dapat dihapus agar nomor karcis tidak dapat digunakan kembali.');
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS
        |--------------------------------------------------------------------------
        */

        $setoran->delete();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.setoran.index')
            ->with(
                'success',
                'Data setoran berhasil dihapus.'
            );
    }

    /**
     * Lock the issued ticket range and reject out-of-range or previously used numbers.
     *
     * @return array{allocation: KarcisAllocation, numbers: array<int, int>, jumlah: int}
     */
    private function validateTicketLines(array $data, ?int $exceptSetoranId = null): array
    {
        $lines = $data['karcis_lines'] ?? [];
        if (!$lines) {
            throw ValidationException::withMessages([
                'karcis_lines' => 'Pilih setidaknya satu seri karcis dan masukkan nomor yang terpakai.',
            ]);
        }

        usort($lines, fn ($a, $b) => (int) $a['allocation_id'] <=> (int) $b['allocation_id']);
        $processed = [];
        $seenNumbers = [];
        $display = [];
        $ticketCount = 0;
        $gross = 0;

        foreach ($lines as $index => $line) {
            $allocationId = (int) $line['allocation_id'];
            $allocation = $processed[$allocationId]['allocation'] ?? KarcisAllocation::query()
                ->whereKey($allocationId)
                ->lockForUpdate()
                ->firstOrFail();

            if ((int) $allocation->sumber_pemasukan_id !== (int) $data['sumber_pemasukan_id']) {
                throw ValidationException::withMessages([
                    "karcis_lines.{$index}.allocation_id" => 'Seri karcis harus berasal dari sumber pemasukan yang dipilih.',
                ]);
            }

            if ($allocation->jukir_id && (int) $allocation->jukir_id !== (int) ($data['jukir_id'] ?? 0)) {
                throw ValidationException::withMessages([
                    "karcis_lines.{$index}.allocation_id" => 'Seri karcis ini diserahkan kepada jukir yang berbeda.',
                ]);
            }

            $parsed = app(KarcisSeriesParser::class)->parse(
                (string) $line['nomor'],
                $allocation->nomor_awal,
                $allocation->nomor_akhir,
                "karcis_lines.{$index}.nomor"
            );

            foreach ($parsed['numbers'] as $number) {
                $unique = $allocationId . ':' . $number;
                if (isset($seenNumbers[$unique])) {
                    throw ValidationException::withMessages([
                        "karcis_lines.{$index}.nomor" => 'Nomor karcis yang sama tercantum pada lebih dari satu baris.',
                    ]);
                }
                $seenNumbers[$unique] = true;
            }

            foreach ($parsed['ranges'] as [$start, $end]) {
                $used = DB::table('karcis_usages')
                    ->where('karcis_allocation_id', $allocationId)
                    ->whereBetween('nomor_seri', [$start, $end])
                    ->when($exceptSetoranId, fn ($query) => $query->where('setoran_id', '!=', $exceptSetoranId))
                    ->exists();

                if ($used) {
                    throw ValidationException::withMessages([
                        "karcis_lines.{$index}.nomor" => 'Satu atau lebih nomor karcis pada rentang ini sudah tercatat pada setoran lain.',
                    ]);
                }
            }

            $processed[$allocationId] = [
                'allocation' => $allocation,
                'numbers' => array_merge($processed[$allocationId]['numbers'] ?? [], $parsed['numbers']),
            ];
            $count = count($parsed['numbers']);
            if ($ticketCount + $count > 2000) {
                throw ValidationException::withMessages([
                    "karcis_lines.{$index}.nomor" => 'Maksimal 2.000 nomor karcis dapat dicatat dalam satu setoran.',
                ]);
            }
            $ticketCount += $count;
            $gross += $count * $allocation->nilai_per_karcis;
            $display[] = [
                'jenis' => $allocation->jenis_karcis,
                'prefix' => $allocation->seri_prefix,
                'nomor' => trim($line['nomor']),
                'jumlah' => $count,
                'nilai' => $allocation->nilai_per_karcis,
            ];
        }

        return [
            'lines' => array_values($processed),
            'display' => $display,
            'jumlah' => $ticketCount,
            'bruto' => $gross,
        ];
    }

    /**
     * Persist every used serial separately so duplicate ticket use is prevented by a database constraint.
     *
     * @param array<int, int> $numbers
     */
    private function saveTicketNumbers(int $setoranId, array $lines): void
    {
        foreach ($lines as $line) {
            foreach (array_chunk($line['numbers'], 500) as $chunk) {
                DB::table('karcis_usages')->insert(array_map(
                    fn (int $number) => [
                        'karcis_allocation_id' => $line['allocation']->id,
                        'setoran_id' => $setoranId,
                        'nomor_seri' => $number,
                    ],
                    $chunk
                ));
            }
        }
    }
}