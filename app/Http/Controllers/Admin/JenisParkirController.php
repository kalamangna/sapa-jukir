<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJenisParkirRequest;
use App\Http\Requests\UpdateJenisParkirRequest;
use App\Models\JenisParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class JenisParkirController extends Controller
{
    /**
     * Menampilkan daftar Jenis Parkir.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $jenisParkirs = JenisParkir::query()
            ->withCount([
                'titikParkirs',
                'tarifs',
            ])
            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('kode', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%");

                });

            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.jenis-parkir.index',
            compact(
                'jenisParkirs',
                'search'
            )
        );
    }


    /**
     * Menampilkan form tambah Jenis Parkir.
     */
    public function create()
    {
        return view('admin.jenis-parkir.create');
    }


    /**
     * Menyimpan Jenis Parkir baru.
     */
    public function store(StoreJenisParkirRequest $request)
    {
        JenisParkir::create(
            $request->validated()
        );

        return redirect()
            ->route('admin.jenis-parkir.index')
            ->with(
                'success',
                'Jenis Parkir berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail Jenis Parkir.
     */
    public function show(JenisParkir $jenisParkir)
    {
        $jenisParkir->load([
            'titikParkirs.kecamatan',
            'titikParkirs.kelurahan',
            'tarifs',
        ])->loadCount([
            'titikParkirs',
            'tarifs',
        ]);

        return view(
            'admin.jenis-parkir.show',
            compact('jenisParkir')
        );
    }


    /**
     * Menampilkan form edit Jenis Parkir.
     */
    public function edit(JenisParkir $jenisParkir)
    {
        return view(
            'admin.jenis-parkir.edit',
            compact('jenisParkir')
        );
    }


    /**
     * Memperbarui Jenis Parkir.
     */
    public function update(
        UpdateJenisParkirRequest $request,
        JenisParkir $jenisParkir
    ) {
        $jenisParkir->update(
            $request->validated()
        );

        return redirect()
            ->route('admin.jenis-parkir.index')
            ->with(
                'success',
                'Jenis Parkir berhasil diperbarui.'
            );
    }


    /**
     * Menghapus Jenis Parkir.
     */
    public function destroy(JenisParkir $jenisParkir)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH MASIH DIGUNAKAN
        |--------------------------------------------------------------------------
        */

        if (
            $jenisParkir->titikParkirs()->exists() ||
            $jenisParkir->tarifs()->exists()
        ) {

            return redirect()
                ->route('admin.jenis-parkir.index')
                ->with(
                    'error',
                    'Jenis Parkir tidak dapat dihapus karena masih digunakan oleh Titik Parkir atau Tarif.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA
        |--------------------------------------------------------------------------
        */

        try {

            DB::transaction(function () use ($jenisParkir) {

                $jenisParkir->delete();

            });

        } catch (QueryException $e) {

            return redirect()
                ->route('admin.jenis-parkir.index')
                ->with(
                    'error',
                    'Jenis Parkir tidak dapat dihapus karena masih memiliki data yang terkait.'
                );
        }


        return redirect()
            ->route('admin.jenis-parkir.index')
            ->with(
                'success',
                'Jenis Parkir berhasil dihapus.'
            );
    }
}