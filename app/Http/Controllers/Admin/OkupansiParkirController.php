<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OkupansiParkir;
use App\Models\TitikParkir;
use Illuminate\Http\Request;

class OkupansiParkirController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());
        $okupansis = OkupansiParkir::with('titikParkir')
            ->whereDate('tanggal', $tanggal)->latest()->paginate(15)->withQueryString();
        return view('admin.okupansi-parkir.index', compact('okupansis', 'tanggal'));
    }

    public function create()
    {
        return view('admin.okupansi-parkir.create', [
            'titikParkirs' => TitikParkir::where('status', 'aktif')->whereHas('sumberPemasukan', fn ($query) => $query->where('kode', 'R-TKP'))->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titik_parkir_id' => ['required', 'exists:titik_parkirs,id'],
            'tanggal' => ['required', 'date'],
            'jumlah_motor' => ['required', 'integer', 'min:0'],
            'jumlah_mobil' => ['required', 'integer', 'min:0'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);
        $point = TitikParkir::with('sumberPemasukan')->findOrFail($data['titik_parkir_id']);
        if ($point->sumberPemasukan?->kode !== 'R-TKP') {
            return back()->withErrors(['titik_parkir_id' => 'Okupansi hanya dapat dicatat untuk parkir khusus.'])->withInput();
        }
        if ($point->kapasitas_total !== null && $data['jumlah_motor'] + $data['jumlah_mobil'] > $point->kapasitas_total) {
            return back()->withErrors(['jumlah_motor' => 'Jumlah kendaraan melebihi kapasitas total titik parkir.'])->withInput();
        }
        OkupansiParkir::updateOrCreate(
            ['titik_parkir_id' => $data['titik_parkir_id'], 'tanggal' => $data['tanggal']],
            $data
        );
        return redirect()->route('admin.okupansi-parkir.index', ['tanggal' => $data['tanggal']])->with('success', 'Okupansi parkir berhasil dicatat.');
    }
}