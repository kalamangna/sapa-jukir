<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ObjekPendapatan;
use App\Models\UnitUsaha;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitUsahaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $objekId = $request->input('objek_pendapatan_id');
        $units = UnitUsaha::with('objekPendapatan')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($objekId, fn ($query) => $query->where('objek_pendapatan_id', $objekId))
            ->orderBy('nama_unit')->paginate(15)->withQueryString();

        return view('admin.unit-usaha.index', [
            'units' => $units,
            'status' => $status,
            'objekId' => $objekId,
            'objeks' => ObjekPendapatan::where('status', 'aktif')->whereIn('tipe', ['tempat_usaha', 'aset_daerah'])->orderBy('nama')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.unit-usaha.create', [
            'objeks' => ObjekPendapatan::where('status', 'aktif')->whereIn('tipe', ['tempat_usaha', 'aset_daerah'])->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        UnitUsaha::create($data);

        return redirect()->route('admin.unit-usaha.index')->with('success', 'Unit usaha berhasil ditambahkan.');
    }

    public function edit(UnitUsaha $unitUsaha)
    {
        return view('admin.unit-usaha.edit', [
            'unit' => $unitUsaha,
            'objeks' => ObjekPendapatan::where('status', 'aktif')->whereIn('tipe', ['tempat_usaha', 'aset_daerah'])->orWhereKey($unitUsaha->objek_pendapatan_id)->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, UnitUsaha $unitUsaha)
    {
        $unitUsaha->update($this->validated($request, $unitUsaha));

        return redirect()->route('admin.unit-usaha.index')->with('success', 'Unit usaha berhasil diperbarui.');
    }

    public function destroy(UnitUsaha $unitUsaha)
    {
        if ($unitUsaha->tagihans()->exists()) {
            return back()->with('error', 'Unit tidak dapat dihapus karena sudah memiliki tagihan.');
        }
        $unitUsaha->delete();

        return back()->with('success', 'Unit usaha berhasil dihapus.');
    }

    private function validated(Request $request, ?UnitUsaha $existing = null): array
    {
        return $request->validate([
            'objek_pendapatan_id' => ['required', Rule::exists('objek_pendapatans', 'id')->whereIn('tipe', ['tempat_usaha', 'aset_daerah'])],
            'kode_unit' => ['required', 'string', 'max:50', Rule::unique('unit_usahas', 'kode_unit')->where(fn ($query) => $query->where('objek_pendapatan_id', $request->input('objek_pendapatan_id')))->ignore($existing?->id)],
            'nama_unit' => ['required', 'string', 'max:255'],
            'jenis_unit' => ['nullable', 'string', 'max:100'],
            'penyewa_nama' => ['nullable', 'string', 'max:255'],
            'penyewa_identitas' => ['nullable', 'string', 'max:100'],
            'luas_m2' => ['nullable', 'numeric', 'min:0'],
            'tarif_sewa' => ['nullable', 'numeric', 'min:0'],
            'kontrak_mulai' => ['nullable', 'date'],
            'kontrak_selesai' => ['nullable', 'date', 'after_or_equal:kontrak_mulai'],
            'status' => ['required', 'in:aktif,kosong,nonaktif'],
        ]);
    }
}