<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\TitikParkir;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public const JENIS = [
        'tarif_parkir_tidak_sesuai' => 'Tarif Parkir Tidak Sesuai',
        'pelayanan_jukir_tidak_sesuai' => 'Pelayanan Jukir Tidak Sesuai',
        'lokasi_parkir_belum_terdaftar' => 'Lokasi Parkir Belum Terdaftar',
        'jukir_tidak_memakai_atribut' => 'Jukir Tidak Memakai Atribut Resmi',
        'lainnya' => 'Lainnya',
    ];

    public function create(Request $request)
    {
        $titikParkir = $request->filled('titik_parkir')
            ? TitikParkir::find($request->integer('titik_parkir'))
            : null;

        return view('pengaduan', [
            'jenisPengaduan' => self::JENIS,
            'titikParkir' => $titikParkir,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'nik' => ['required', 'digits:16'],
            'telepon' => ['required', 'string', 'max:30'],
            'titik_parkir' => ['nullable', 'string', 'max:255'],
            'lokasi_parkir' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'in:' . implode(',', array_keys(self::JENIS))],
            'detail' => ['required', 'string', 'max:5000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pengaduan', 'local');
        }

        Pengaduan::create($data);

        return redirect()->route('pengaduan.create')->with('success', 'Aduan berhasil dikirim. Terima kasih atas laporan Anda.');
    }
}
