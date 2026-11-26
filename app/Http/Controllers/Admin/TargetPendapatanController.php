<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTargetPendapatanRequest;
use App\Http\Requests\UpdateTargetPendapatanRequest;
use App\Models\SumberPemasukan;
use App\Models\TargetPendapatan;
use App\Models\TitikParkir;
use App\Models\ObjekPendapatan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TargetPendapatanController extends Controller
{
    private const BULAN = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    public function index(Request $request)
    {
        $tahun = (int) $request->input('tahun', now()->year);
        $sumberPemasukanId = $request->input('sumber_pemasukan_id');
        $titikParkirId = $request->input('titik_parkir_id');

        $targets = TargetPendapatan::query()
            ->with(['sumberPemasukan', 'titikParkir', 'objekPendapatan'])
            ->where('tahun', $tahun)
            ->when($sumberPemasukanId, fn ($query) => $query->where('sumber_pemasukan_id', $sumberPemasukanId))
            ->when($titikParkirId === 'aggregate', fn ($query) => $query->whereNull('titik_parkir_id'))
            ->when($titikParkirId && $titikParkirId !== 'aggregate', fn ($query) => $query->where('titik_parkir_id', $titikParkirId))
            ->orderBy('bulan')
            ->paginate(15)
            ->withQueryString();

        $sumberPemasukans = SumberPemasukan::where('status', true)->orderBy('nama')->get();
        $titikParkirs = TitikParkir::where('status', 'aktif')->orderBy('nama')->get();

        return view('admin.target-pendapatan.index', compact(
            'targets', 'tahun', 'sumberPemasukans', 'titikParkirs', 'sumberPemasukanId', 'titikParkirId'
        ));
    }

    public function create()
    {
        return view('admin.target-pendapatan.create', [
            'bulan' => self::BULAN,
            'sumberPemasukans' => SumberPemasukan::where('status', true)->orderBy('nama')->get(),
            'titikParkirs' => TitikParkir::where('status', 'aktif')->orderBy('nama')->get(),
        ]);
    }

    public function store(StoreTargetPendapatanRequest $request)
    {
        $data = $request->validated();
        $this->ensureUniquePeriod($data);
        TargetPendapatan::create($data);

        return redirect()->route('admin.target-pendapatan.index', ['tahun' => $data['tahun']])
            ->with('success', 'Target pendapatan berhasil ditambahkan.');
    }

    public function edit(TargetPendapatan $targetPendapatan)
    {
        return view('admin.target-pendapatan.edit', [
            'target' => $targetPendapatan,
            'bulan' => self::BULAN,
            'sumberPemasukans' => SumberPemasukan::where('status', true)->orderBy('nama')->get(),
            'titikParkirs' => TitikParkir::where('status', 'aktif')->orWhere('id', $targetPendapatan->titik_parkir_id)->orderBy('nama')->get(),
            'objekPendapatans' => ObjekPendapatan::where('status', 'aktif')->orWhere('id', $targetPendapatan->objek_pendapatan_id)->orderBy('nama')->get(),
        ]);
    }

    public function update(UpdateTargetPendapatanRequest $request, TargetPendapatan $targetPendapatan)
    {
        $data = $request->validated();
        $this->ensureUniquePeriod($data, $targetPendapatan);
        $targetPendapatan->update($data);

        return redirect()->route('admin.target-pendapatan.index', ['tahun' => $data['tahun']])
            ->with('success', 'Target pendapatan berhasil diperbarui.');
    }

    public function destroy(TargetPendapatan $targetPendapatan)
    {
        $tahun = $targetPendapatan->tahun;
        $targetPendapatan->delete();

        return redirect()->route('admin.target-pendapatan.index', ['tahun' => $tahun])
            ->with('success', 'Target pendapatan berhasil dihapus.');
    }

    private function ensureUniquePeriod(array $data, ?TargetPendapatan $existing = null): void
    {
        $query = TargetPendapatan::query()
            ->where('sumber_pemasukan_id', $data['sumber_pemasukan_id'])
            ->when($data['objek_pendapatan_id'] ?? null, fn ($builder, $id) => $builder->where('objek_pendapatan_id', $id), fn ($builder) => $builder->whereNull('objek_pendapatan_id'))
            ->where('tahun', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->when($data['titik_parkir_id'] ?? null, fn ($builder, $id) => $builder->where('titik_parkir_id', $id), fn ($builder) => $builder->whereNull('titik_parkir_id'));

        if ($existing) {
            $query->whereKeyNot($existing->id);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'bulan' => 'Target untuk sumber, lokasi, dan periode tersebut sudah ada.',
            ]);
        }
    }
}