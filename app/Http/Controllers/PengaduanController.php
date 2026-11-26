<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\TitikParkir;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

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
            'formToken' => Crypt::encryptString((string) now()->timestamp),
        ]);
    }

    public function store(Request $request)
    {
        if ($request->filled('website')) {
            Log::warning('Pengaduan diabaikan karena honeypot terisi.', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->route('pengaduan.create')->with('success', 'Aduan berhasil dikirim. Terima kasih atas laporan Anda.');
        }

        $startedAt = $this->decodeFormToken($request->input('form_token'));
        $elapsed = $startedAt !== null ? now()->timestamp - $startedAt : null;

        if ($elapsed === null || $elapsed < 0 || $elapsed > 7200) {
            return back()
                ->withErrors(['form_token' => 'Sesi formulir tidak valid atau telah kedaluwarsa. Muat ulang halaman lalu kirim kembali.'])
                ->withInput();
        }

        if ($elapsed < 3) {
            return back()
                ->withErrors(['form_token' => 'Pengiriman terlalu cepat. Periksa kembali isian Anda lalu kirim ulang dalam beberapa detik.'])
                ->withInput();
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'nik' => ['required', 'digits:16'],
            'telepon' => ['required', 'string', 'regex:/^[0-9+\-\s()]{8,20}$/'],
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

    private function decodeFormToken(mixed $token): ?int
    {
        if (! is_string($token) || $token === '') {
            return null;
        }

        try {
            $decrypted = Crypt::decryptString($token);
        } catch (DecryptException) {
            return null;
        }

        return ctype_digit($decrypted) ? (int) $decrypted : null;
    }
}
