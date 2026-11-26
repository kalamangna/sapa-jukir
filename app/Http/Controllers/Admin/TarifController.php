<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisParkir;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class TarifController extends Controller
{
    /**
     * Menampilkan daftar Tarif.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

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
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.tarif.index',
            compact(
                'tarifs',
                'search'
            )
        );
    }


    /**
     * Menampilkan form tambah Tarif.
     */
    public function create()
    {
        $jenisParkirs = JenisParkir::query()
            ->where('status', true)
            ->orderBy('nama')
            ->get();

        return view(
            'admin.tarif.create',
            compact('jenisParkirs')
        );
    }


    /**
     * Menyimpan Tarif baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'jenis_parkir_id' => [
                'required',
                'exists:jenis_parkirs,id',
            ],

            'jenis_kendaraan' => [
                'required',
                'in:motor,mobil_kecil,mobil_besar',
            ],

            'nominal' => [
                'required',
                'numeric',
                'min:0',
            ],

            'berlaku_mulai' => [
                'required',
                'date',
            ],

            'berlaku_sampai' => [
                'nullable',
                'date',
                'after_or_equal:berlaku_mulai',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

        ]);

        Tarif::create($validated);

        return redirect()
            ->route('admin.tarif.index')
            ->with(
                'success',
                'Tarif berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail Tarif.
     */
    public function show(Tarif $tarif)
    {
        $tarif->load('jenisParkir');

        return view(
            'admin.tarif.show',
            compact('tarif')
        );
    }


    /**
     * Menampilkan form edit Tarif.
     */
    public function edit(Tarif $tarif)
    {
        $jenisParkirs = JenisParkir::query()
            ->where(function ($query) use ($tarif) {

                $query->where('status', true)
                    ->orWhere(
                        'id',
                        $tarif->jenis_parkir_id
                    );

            })
            ->orderBy('nama')
            ->get();

        return view(
            'admin.tarif.edit',
            compact(
                'tarif',
                'jenisParkirs'
            )
        );
    }


    /**
     * Memperbarui Tarif.
     */
    public function update(
        Request $request,
        Tarif $tarif
    ) {
        $validated = $request->validate([

            'jenis_parkir_id' => [
                'required',
                'exists:jenis_parkirs,id',
            ],

            'jenis_kendaraan' => [
                'required',
                'in:motor,mobil_kecil,mobil_besar',
            ],

            'nominal' => [
                'required',
                'numeric',
                'min:0',
            ],

            'berlaku_mulai' => [
                'required',
                'date',
            ],

            'berlaku_sampai' => [
                'nullable',
                'date',
                'after_or_equal:berlaku_mulai',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

        ]);

        $tarif->update($validated);

        return redirect()
            ->route('admin.tarif.index')
            ->with(
                'success',
                'Tarif berhasil diperbarui.'
            );
    }


    /**
     * Menghapus Tarif.
     */
    public function destroy(Tarif $tarif)
    {
        try {

            DB::transaction(function () use ($tarif) {

                $tarif->delete();

            });

        } catch (QueryException $e) {

            return redirect()
                ->route('admin.tarif.index')
                ->with(
                    'error',
                    'Tarif tidak dapat dihapus karena masih memiliki data terkait.'
                );
        }

        return redirect()
            ->route('admin.tarif.index')
            ->with(
                'success',
                'Tarif berhasil dihapus.'
            );
    }
}
