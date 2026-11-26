<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jukir;
use App\Models\KarcisAllocation;
use App\Models\SumberPemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class KarcisAllocationController extends Controller
{
    public function index()
    {
        $allocations = KarcisAllocation::query()
            ->with(['sumberPemasukan', 'jukir'])
            ->withCount('usages')
            ->latest('tanggal_penyerahan')
            ->latest()
            ->paginate(20);

        return view('admin.karcis.index', [
            'allocations' => $allocations,
            'sources' => SumberPemasukan::where('status', true)->orderBy('nama')->get(),
            'jukirs' => Jukir::where('status', 'aktif')->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sumber_pemasukan_id' => ['required', 'integer', 'exists:sumber_pemasukans,id'],
            'jukir_id' => ['nullable', 'integer', 'exists:jukirs,id'],
            'penerima' => ['required', 'string', 'max:150'],
            'jenis_karcis' => ['required', 'string', 'max:100'],
            'seri_prefix' => ['nullable', 'string', 'max:30', 'regex:/^[A-Za-z0-9\/-]*$/'],
            'nomor_awal' => ['required', 'string', 'max:20', 'regex:/^\d+$/'],
            'nomor_akhir' => ['required', 'string', 'max:20', 'regex:/^\d+$/'],
            'nilai_per_karcis' => ['required', 'integer', 'min:1'],
            'tanggal_penyerahan' => ['required', 'date'],
        ]);

        $startText = $data['nomor_awal'];
        $endText = $data['nomor_akhir'];
        $start = (int) $startText;
        $end = (int) $endText;

        if ($start < 1 || $start > $end || $end - $start + 1 > 100000) {
            throw ValidationException::withMessages([
                'nomor_akhir' => 'Rentang harus berurutan dan maksimal 100.000 karcis.',
            ]);
        }

        DB::transaction(function () use ($data, $startText, $endText, $start, $end) {
            SumberPemasukan::query()
                ->whereKey($data['sumber_pemasukan_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $prefix = strtoupper($data['seri_prefix'] ?? '');
            $overlap = KarcisAllocation::query()
                ->where('sumber_pemasukan_id', $data['sumber_pemasukan_id'])
                ->where('seri_prefix', $prefix)
                ->where('nomor_awal', '<=', $end)
                ->where('nomor_akhir', '>=', $start)
                ->exists();

            if ($overlap) {
                throw ValidationException::withMessages([
                    'nomor_awal' => 'Rentang seri tersebut sudah pernah diserahkan untuk sumber pemasukan dan awalan yang sama.',
                ]);
            }

            KarcisAllocation::create([
                'sumber_pemasukan_id' => $data['sumber_pemasukan_id'],
                'jukir_id' => $data['jukir_id'] ?? null,
                'penerima' => $data['penerima'],
                'jenis_karcis' => $data['jenis_karcis'],
                'seri_prefix' => $prefix,
                'nomor_awal' => $start,
                'nomor_akhir' => $end,
                'lebar_nomor' => max(strlen($startText), strlen($endText)),
                'nilai_per_karcis' => $data['nilai_per_karcis'],
                'tanggal_penyerahan' => $data['tanggal_penyerahan'],
            ]);
        });

        return redirect()->route('admin.karcis.index')->with('success', 'Rentang karcis berhasil dicatat.');
    }
}
