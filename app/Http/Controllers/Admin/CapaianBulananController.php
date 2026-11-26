<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CapaianBulanan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CapaianBulananController extends Controller
{
    private const BULAN = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    public function index(Request $request)
    {
        $tahun = (int) $request->input('tahun', now()->year);
        $capaian = CapaianBulanan::where('tahun', $tahun)->orderBy('bulan')->get();
        return view('admin.capaian-bulanan.index', compact('capaian', 'tahun'));
    }

    public function create()
    {
        return view('admin.capaian-bulanan.create', ['bulan' => self::BULAN]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        CapaianBulanan::create($data);
        return redirect()->route('admin.capaian-bulanan.index', ['tahun' => $data['tahun']])->with('success', 'Capaian bulanan berhasil ditambahkan.');
    }

    public function edit(CapaianBulanan $capaianBulanan)
    {
        return view('admin.capaian-bulanan.edit', ['capaian' => $capaianBulanan, 'bulan' => self::BULAN]);
    }

    public function update(Request $request, CapaianBulanan $capaianBulanan)
    {
        $data = $this->validated($request, $capaianBulanan);
        $capaianBulanan->update($data);
        return redirect()->route('admin.capaian-bulanan.index', ['tahun' => $data['tahun']])->with('success', 'Capaian bulanan berhasil diperbarui.');
    }

    public function destroy(CapaianBulanan $capaianBulanan)
    {
        $tahun = $capaianBulanan->tahun;
        $capaianBulanan->delete();
        return redirect()->route('admin.capaian-bulanan.index', ['tahun' => $tahun])->with('success', 'Capaian bulanan dihapus. Data bulan tersebut kembali menggunakan perhitungan otomatis.');
    }

    private function validated(Request $request, ?CapaianBulanan $existing = null): array
    {
        $uniqueMonth = Rule::unique('capaian_bulanans', 'bulan')
            ->where(fn ($query) => $query->where('tahun', $request->input('tahun')));
        if ($existing) {
            $uniqueMonth = $uniqueMonth->ignore($existing->id);
        }

        return $request->validate([
            'tahun' => ['required', 'integer', 'min:2026', 'max:2100'],
            'bulan' => ['required', 'integer', 'between:1,12', $uniqueMonth],
            'target' => ['required', 'numeric', 'min:0'],
            'realisasi' => ['required', 'numeric', 'min:0'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}
