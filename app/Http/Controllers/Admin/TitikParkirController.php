<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTitikParkirRequest;
use App\Http\Requests\UpdateTitikParkirRequest;
use App\Models\TitikParkir;
use App\Models\JenisParkir;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\SumberPemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class TitikParkirController extends Controller
{
    /**
     * Menampilkan daftar Titik Parkir.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategoriRetribusi = $request->input('kategori_retribusi', 'all');

        $categoryMap = [
            'R-PJTU' => 'Retribusi Pelayanan Parkir Tepi Jalan Umum',
            'R-TKU' => 'Retribusi Penyediaan Tempat Kegiatan Usaha',
            'R-TKP' => 'Retribusi Tempat Khusus Parkir',
            'R-SPATKT' => 'Retribusi Sewa Pelataran Area Terminal untuk Kegiatan Tertentu',
        ];

        $query = TitikParkir::query()
            ->with([
                'jenisParkir',
                'sumberPemasukan',
                'kecamatan',
                'kelurahan',
                'targetPendapatans' => function ($query) {
                    $query->where('tahun', now()->year)
                        ->where('bulan', now()->month);
                },
            ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_titik', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%");
                });
            })
            ->when($kategoriRetribusi !== 'all', function ($query) use ($kategoriRetribusi) {
                $query->whereHas('sumberPemasukan', function ($sumberQuery) use ($kategoriRetribusi) {
                    $sumberQuery->where('kode', $kategoriRetribusi);
                });
            })
            ->latest();

        $titikParkirs = $query->get();

        $groupedTitikParkirs = collect(array_keys($categoryMap))
            ->map(function (string $code) use ($titikParkirs, $categoryMap) {
                $items = $titikParkirs->filter(function ($titik) use ($code) {
                    $sourceCode = $titik->sumberPemasukan?->kode;

                    if (in_array($code, ['R-SPATKT'], true)) {
                        return in_array($sourceCode, ['R-SPATKT', 'R-JASA-USAHA'], true);
                    }

                    return $sourceCode === $code;
                });

                return [
                    'code' => $code,
                    'label' => $categoryMap[$code],
                    'items' => $items->values(),
                ];
            })
            ->filter(fn (array $group) => $kategoriRetribusi === 'all' || $group['code'] === $kategoriRetribusi || ($kategoriRetribusi === 'R-JASA-USAHA' && $group['code'] === 'R-SPATKT'))
            ->values();

        return view(
            'admin.titik-parkir.index',
            compact(
                'groupedTitikParkirs',
                'search',
                'kategoriRetribusi',
                'categoryMap'
            )
        );
    }


    /**
     * Menampilkan form tambah Titik Parkir.
     */
    public function create()
    {
        $jenisParkirs = JenisParkir::query()
            ->where('status', true)
            ->orderBy('nama')
            ->get();

        $sumberPemasukans = SumberPemasukan::where('status', true)->orderBy('nama')->get();

        $kecamatans = Kecamatan::query()
            ->orderBy('nama')
            ->get();

        $kelurahans = Kelurahan::query()
            ->orderBy('nama')
            ->get();

        return view(
            'admin.titik-parkir.create',
            compact(
                'jenisParkirs',
                'sumberPemasukans',
                'kecamatans',
                'kelurahans'
            )
        );
    }


    /**
     * Menyimpan Titik Parkir baru.
     */
    public function store(StoreTitikParkirRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {

            $validated['foto'] = $request
                ->file('foto')
                ->store('titik-parkir', 'public');
        }

        TitikParkir::create($validated);

        return redirect()
            ->route('admin.titik-parkir.index')
            ->with(
                'success',
                'Titik Parkir berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail Titik Parkir.
     */
    public function show(TitikParkir $titikParkir)
{
    $titikParkir->load([
        'jenisParkir.tarifs',
        'kecamatan',
        'kelurahan',
        'penempatanJukirs.jukir',
    ]);

    return view(
        'admin.titik-parkir.show',
        compact('titikParkir')
    );
}

    /**
     * Menampilkan form edit Titik Parkir.
     */
    public function edit(TitikParkir $titikParkir)
    {
        $jenisParkirs = JenisParkir::query()
            ->where('status', true)
            ->orWhere('id', $titikParkir->jenis_parkir_id)
            ->orderBy('nama')
            ->get();

        $sumberPemasukans = SumberPemasukan::where('status', true)->orderBy('nama')->get();

        $kecamatans = Kecamatan::query()
            ->orderBy('nama')
            ->get();

        $kelurahans = Kelurahan::query()
            ->orderBy('nama')
            ->get();

        return view(
            'admin.titik-parkir.edit',
            compact(
                'titikParkir',
                'jenisParkirs',
                'sumberPemasukans',
                'kecamatans',
                'kelurahans'
            )
        );
    }


    /**
     * Memperbarui Titik Parkir.
     */
    public function update(
        UpdateTitikParkirRequest $request,
        TitikParkir $titikParkir
    ) {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {

            $validated['foto'] = $request
                ->file('foto')
                ->store('titik-parkir', 'public');
        }

        $titikParkir->update($validated);

        return redirect()
            ->route('admin.titik-parkir.index')
            ->with(
                'success',
                'Titik Parkir berhasil diperbarui.'
            );
    }


    /**
     * Menghapus Titik Parkir.
     */
    public function destroy(TitikParkir $titikParkir)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK DATA TERKAIT
        |--------------------------------------------------------------------------
        */

      if (
    $titikParkir->penempatanJukirs()->exists()
) {

            return redirect()
                ->route('admin.titik-parkir.index')
                ->with(
                    'error',
                    'Titik Parkir tidak dapat dihapus karena masih digunakan oleh Penempatan Jukir.'
                );
        }


        try {

            DB::transaction(function () use ($titikParkir) {

                $titikParkir->delete();

            });

        } catch (QueryException $e) {

            return redirect()
                ->route('admin.titik-parkir.index')
                ->with(
                    'error',
                    'Titik Parkir tidak dapat dihapus karena masih memiliki data terkait.'
                );
        }


        return redirect()
            ->route('admin.titik-parkir.index')
            ->with(
                'success',
                'Titik Parkir berhasil dihapus.'
            );
    }
}