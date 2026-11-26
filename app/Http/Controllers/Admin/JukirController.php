<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJukirRequest;
use App\Http\Requests\UpdateJukirRequest;
use App\Models\JenisJukir;
use App\Models\Jukir;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JukirController extends Controller
{
    /**
     * Menampilkan daftar Jukir.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $jukirs = Jukir::query()
            ->with([
                'jenisJukir',
                'kecamatan',
                'kelurahan',
            ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_jukir', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.jukir.index', compact(
            'jukirs',
            'search'
        ));
    }


    public function create()
{
    /*
    |--------------------------------------------------------------------------
    | JENIS JUKIR AKTIF
    |--------------------------------------------------------------------------
    */

    $jenisJukirs = JenisJukir::query()
        ->where('status', true)
        ->orderBy('nama')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | WILAYAH
    |--------------------------------------------------------------------------
    */

    $kecamatans = Kecamatan::query()
        ->orderBy('nama')
        ->get();

    $kelurahans = Kelurahan::query()
        ->orderBy('nama')
        ->get();


    return view(
        'admin.jukir.create',
        compact(
            'jenisJukirs',
            'kecamatans',
            'kelurahans'
        )
    );
}


    /**
     * Menyimpan data Jukir baru.
     */
    public function store(StoreJukirRequest $request)
    {
        DB::transaction(function () use ($request) {

            $data = $request->validated();

            /*
            |--------------------------------------------------------------------------
            | GENERATE KODE JUKIR
            |--------------------------------------------------------------------------
            */

            $data['kode_jukir'] = $this->generateKodeJukir();


            /*
            |--------------------------------------------------------------------------
            | UPLOAD FOTO
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('foto')) {

                $data['foto'] = $request
                    ->file('foto')
                    ->store('jukir/foto', 'public');
            }


            /*
            |--------------------------------------------------------------------------
            | UPLOAD FOTO KTP
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('foto_ktp')) {

                $data['foto_ktp'] = $request
                    ->file('foto_ktp')
                    ->store('jukir/ktp', 'public');
            }

                    if ($request->hasFile('dokumen_pendukung')) {
                    $data['dokumen_pendukung'] = $request
                        ->file('dokumen_pendukung')
                        ->store('jukir/dokumen-pendukung', 'public');
                    }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN DATA
            |--------------------------------------------------------------------------
            */

            Jukir::create($data);
        });

        return redirect()
            ->route('admin.jukir.index')
            ->with(
                'success',
                'Data Jukir berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail Jukir.
     */
    public function show(Jukir $jukir)
    {
        $jukir->load([
            'jenisJukir',
            'kecamatan',
            'kelurahan',
        ]);

        return view(
            'admin.jukir.show',
            compact('jukir')
        );
    }

public function edit(Jukir $jukir)
{
    $jenisJukirs = JenisJukir::query()
        ->orderBy('nama')
        ->get();

    $kecamatans = Kecamatan::query()
        ->orderBy('nama')
        ->get();

    $kelurahans = Kelurahan::query()
        ->orderBy('nama')
        ->get();

    return view('admin.jukir.edit', compact(
        'jukir',
        'jenisJukirs',
        'kecamatans',
        'kelurahans'
    ));
}


    /**
     * Memperbarui data Jukir.
     */
    public function update(
        UpdateJukirRequest $request,
        Jukir $jukir
    ) {
        $oldFoto = $jukir->foto;
        $oldFotoKtp = $jukir->foto_ktp;
        $oldDokumenPendukung = $jukir->dokumen_pendukung;

        $newFoto = null;
        $newFotoKtp = null;
        $newDokumenPendukung = null;

        DB::transaction(function () use (
            $request,
            $jukir,
            &$newFoto,
            &$newFotoKtp
            , &$newDokumenPendukung
        ) {

            $data = $request->validated();


            /*
            |--------------------------------------------------------------------------
            | UPLOAD FOTO BARU
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('foto')) {

                $newFoto = $request
                    ->file('foto')
                    ->store('jukir/foto', 'public');

                $data['foto'] = $newFoto;
            }


            /*
            |--------------------------------------------------------------------------
            | UPLOAD FOTO KTP BARU
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('foto_ktp')) {

                $newFotoKtp = $request
                    ->file('foto_ktp')
                    ->store('jukir/ktp', 'public');

                $data['foto_ktp'] = $newFotoKtp;
            }

            if ($request->hasFile('dokumen_pendukung')) {
                $newDokumenPendukung = $request
                    ->file('dokumen_pendukung')
                    ->store('jukir/dokumen-pendukung', 'public');

                $data['dokumen_pendukung'] = $newDokumenPendukung;
            }


            /*
            |--------------------------------------------------------------------------
            | UPDATE DATA
            |--------------------------------------------------------------------------
            */

            $jukir->update($data);
        });


        /*
        |--------------------------------------------------------------------------
        | HAPUS FILE LAMA SETELAH UPDATE BERHASIL
        |--------------------------------------------------------------------------
        */

        if (
            $newFoto &&
            $oldFoto &&
            $oldFoto !== $newFoto &&
            Storage::disk('public')->exists($oldFoto)
        ) {
            Storage::disk('public')->delete($oldFoto);
        }


        if (
            $newFotoKtp &&
            $oldFotoKtp &&
            $oldFotoKtp !== $newFotoKtp &&
            Storage::disk('public')->exists($oldFotoKtp)
        ) {
            Storage::disk('public')->delete($oldFotoKtp);
        }

        if (
            $newDokumenPendukung &&
            $oldDokumenPendukung &&
            $oldDokumenPendukung !== $newDokumenPendukung &&
            Storage::disk('public')->exists($oldDokumenPendukung)
        ) {
            Storage::disk('public')->delete($oldDokumenPendukung);
        }


        return redirect()
            ->route('admin.jukir.index')
            ->with(
                'success',
                'Data Jukir berhasil diperbarui.'
            );
    }


    /**
     * Menghapus data Jukir.
     */
    public function destroy(Jukir $jukir)
    {
        $foto = $jukir->foto;
        $fotoKtp = $jukir->foto_ktp;
        $dokumenPendukung = $jukir->dokumen_pendukung;

        DB::transaction(function () use ($jukir) {

            $jukir->delete();
        });


        /*
        |--------------------------------------------------------------------------
        | HAPUS FILE SETELAH DATA BERHASIL DIHAPUS
        |--------------------------------------------------------------------------
        */

        if (
            $foto &&
            Storage::disk('public')->exists($foto)
        ) {
            Storage::disk('public')->delete($foto);
        }


        if (
            $fotoKtp &&
            Storage::disk('public')->exists($fotoKtp)
        ) {
            Storage::disk('public')->delete($fotoKtp);
        }

        if (
            $dokumenPendukung &&
            Storage::disk('public')->exists($dokumenPendukung)
        ) {
            Storage::disk('public')->delete($dokumenPendukung);
        }


        return redirect()
            ->route('admin.jukir.index')
            ->with(
                'success',
                'Data Jukir berhasil dihapus.'
            );
    }


    /**
     * Generate kode Jukir.
     *
     * Format:
     * JKR-00001
     * JKR-00002
     * JKR-00003
     */
    private function generateKodeJukir(): string
    {
        $lastJukir = Jukir::query()
            ->lockForUpdate()
            ->orderByDesc('id')
            ->first();

        if (! $lastJukir) {
            return 'JKR-00001';
        }

        $number = (int) str_replace(
            'JKR-',
            '',
            $lastJukir->kode_jukir
        );

        $number++;

        return 'JKR-' . str_pad(
            $number,
            5,
            '0',
            STR_PAD_LEFT
        );
    }
}