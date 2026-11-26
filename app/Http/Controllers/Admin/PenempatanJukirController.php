<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePenempatanJukirRequest;
use App\Http\Requests\UpdatePenempatanJukirRequest;
use App\Models\Jukir;
use App\Models\PenempatanJukir;
use App\Models\TitikParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class PenempatanJukirController extends Controller
{
    /**
     * Menampilkan daftar Penempatan Jukir.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $penempatans = PenempatanJukir::query()
            ->with([
                'jukir',
                'titikParkir',
            ])
            ->when($search, function ($query, $search) {

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
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere(
                        'surat_penugasan',
                        'like',
                        "%{$search}%"
                    );

                });

            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.penempatan-jukir.index',
            compact(
                'penempatans',
                'search'
            )
        );
    }


    /**
     * Menampilkan form tambah Penempatan Jukir.
     */
    public function create()
    {
        $jukirs = Jukir::query()
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        $titikParkirs = TitikParkir::query()
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        return view(
            'admin.penempatan-jukir.create',
            compact(
                'jukirs',
                'titikParkirs'
            )
        );
    }


    /**
     * Menyimpan Penempatan Jukir baru.
     */
    public function store(StorePenempatanJukirRequest $request)
    {
        $validated = $request->validated();

        $validated['created_by'] = Auth::id();

        PenempatanJukir::create($validated);

        return redirect()
            ->route('admin.penempatan-jukir.index')
            ->with(
                'success',
                'Penempatan Jukir berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail Penempatan Jukir.
     */
    public function show(PenempatanJukir $penempatanJukir)
    {
        $penempatanJukir->load([
            'jukir',
            'titikParkir',
        ]);

        return view(
            'admin.penempatan-jukir.show',
            compact('penempatanJukir')
        );
    }


    /**
     * Menampilkan form edit Penempatan Jukir.
     */
    public function edit(PenempatanJukir $penempatanJukir)
    {
        $jukirs = Jukir::query()
            ->where('status', 'aktif')
            ->orWhere('id', $penempatanJukir->jukir_id)
            ->orderBy('nama')
            ->get();

        $titikParkirs = TitikParkir::query()
            ->where('status', 'aktif')
            ->orWhere('id', $penempatanJukir->titik_parkir_id)
            ->orderBy('nama')
            ->get();

        return view(
            'admin.penempatan-jukir.edit',
            compact(
                'penempatanJukir',
                'jukirs',
                'titikParkirs'
            )
        );
    }


    /**
     * Memperbarui Penempatan Jukir.
     */
    public function update(
        UpdatePenempatanJukirRequest $request,
        PenempatanJukir $penempatanJukir
    ) {
        $validated = $request->validated();

        $penempatanJukir->update($validated);

        return redirect()
            ->route('admin.penempatan-jukir.index')
            ->with(
                'success',
                'Penempatan Jukir berhasil diperbarui.'
            );
    }


    /**
     * Menghapus Penempatan Jukir.
     */
    public function destroy(PenempatanJukir $penempatanJukir)
    {
        try {

            DB::transaction(function () use ($penempatanJukir) {

                $penempatanJukir->delete();

            });

        } catch (QueryException $e) {

            return redirect()
                ->route('admin.penempatan-jukir.index')
                ->with(
                    'error',
                    'Penempatan Jukir tidak dapat dihapus karena masih memiliki data terkait.'
                );
        }

        return redirect()
            ->route('admin.penempatan-jukir.index')
            ->with(
                'success',
                'Penempatan Jukir berhasil dihapus.'
            );
    }
}