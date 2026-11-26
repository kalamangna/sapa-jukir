<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJenisJukirRequest;
use App\Http\Requests\UpdateJenisJukirRequest;
use App\Models\JenisJukir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class JenisJukirController extends Controller
{
    /**
     * Menampilkan daftar Jenis Jukir.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $jenisJukirs = JenisJukir::query()
            ->withCount('jukirs')
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
            'admin.jenis-jukir.index',
            compact(
                'jenisJukirs',
                'search'
            )
        );
    }


    /**
     * Menampilkan form tambah Jenis Jukir.
     */
    public function create()
    {
        return view('admin.jenis-jukir.create');
    }


    /**
     * Menyimpan Jenis Jukir baru.
     */
    public function store(StoreJenisJukirRequest $request)
    {
        JenisJukir::create(
            $request->validated()
        );

        return redirect()
            ->route('admin.jenis-jukir.index')
            ->with(
                'success',
                'Jenis Jukir berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail Jenis Jukir.
     */
    public function show(JenisJukir $jenisJukir)
    {
        $jenisJukir->load([
            'jukirs.kecamatan',
            'jukirs.kelurahan',
        ])->loadCount('jukirs');

        return view(
            'admin.jenis-jukir.show',
            compact('jenisJukir')
        );
    }


    /**
     * Menampilkan form edit Jenis Jukir.
     */
    public function edit(JenisJukir $jenisJukir)
    {
        return view(
            'admin.jenis-jukir.edit',
            compact('jenisJukir')
        );
    }


    /**
     * Memperbarui Jenis Jukir.
     */
    public function update(
        UpdateJenisJukirRequest $request,
        JenisJukir $jenisJukir
    ) {
        $jenisJukir->update(
            $request->validated()
        );

        return redirect()
            ->route('admin.jenis-jukir.index')
            ->with(
                'success',
                'Jenis Jukir berhasil diperbarui.'
            );
    }


    /**
     * Menghapus Jenis Jukir.
     */
    public function destroy(JenisJukir $jenisJukir)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH SUDAH DIGUNAKAN JUKIR
        |--------------------------------------------------------------------------
        */

        if ($jenisJukir->jukirs()->exists()) {

            return redirect()
                ->route('admin.jenis-jukir.index')
                ->with(
                    'error',
                    'Jenis Jukir tidak dapat dihapus karena masih digunakan oleh data Jukir.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA
        |--------------------------------------------------------------------------
        */

        try {

            DB::transaction(function () use ($jenisJukir) {

                $jenisJukir->delete();

            });

        } catch (QueryException $e) {

            return redirect()
                ->route('admin.jenis-jukir.index')
                ->with(
                    'error',
                    'Jenis Jukir tidak dapat dihapus karena masih memiliki data yang terkait.'
                );
        }


        return redirect()
            ->route('admin.jenis-jukir.index')
            ->with(
                'success',
                'Jenis Jukir berhasil dihapus.'
            );
    }
}