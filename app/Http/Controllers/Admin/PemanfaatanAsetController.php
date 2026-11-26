<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaAset;
use App\Models\PemanfaatanAset;
use App\Models\SumberPemasukan;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PemanfaatanAsetController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $pemanfaatans = PemanfaatanAset::with(['areaAset.asetDaerah', 'tagihan'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest('tanggal_mulai')->paginate(15)->withQueryString();

        return view('admin.pemanfaatan-aset.index', compact('pemanfaatans', 'status'));
    }

    public function create()
    {
        return view('admin.pemanfaatan-aset.create', [
            'areas' => AreaAset::with('asetDaerah')->where('status', '!=', 'nonaktif')->orderBy('nama_area')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $utilization = PemanfaatanAset::create($data);
        if ($utilization->status === 'aktif') {
            $utilization->areaAset()->update(['status' => 'dimanfaatkan', 'pemanfaat_terakhir' => $utilization->pihak_pemanfaat]);
            $this->createTagihan($utilization);
        }

        return redirect()->route('admin.pemanfaatan-aset.index')->with('success', 'Pemanfaatan aset berhasil dicatat.');
    }

    public function edit(PemanfaatanAset $pemanfaatanAset)
    {
        return view('admin.pemanfaatan-aset.edit', [
            'pemanfaatan' => $pemanfaatanAset,
            'areas' => AreaAset::with('asetDaerah')->where('status', '!=', 'nonaktif')->orWhereKey($pemanfaatanAset->area_aset_id)->orderBy('nama_area')->get(),
        ]);
    }

    public function update(Request $request, PemanfaatanAset $pemanfaatanAset)
    {
        $pemanfaatanAset->update($this->validated($request));
        $pemanfaatanAset->areaAset()->update([
            'status' => $pemanfaatanAset->status === 'aktif' ? 'dimanfaatkan' : 'tersedia',
            'pemanfaat_terakhir' => $pemanfaatanAset->pihak_pemanfaat,
        ]);
        if ($pemanfaatanAset->status === 'aktif' && ! $pemanfaatanAset->tagihan_id) {
            $this->createTagihan($pemanfaatanAset);
        }

        return redirect()->route('admin.pemanfaatan-aset.index')->with('success', 'Pemanfaatan aset berhasil diperbarui.');
    }

    public function destroy(PemanfaatanAset $pemanfaatanAset)
    {
        $area = $pemanfaatanAset->areaAset;
        $pemanfaatanAset->delete();
        if ($area) $area->update(['status' => 'tersedia']);
        return back()->with('success', 'Pemanfaatan aset berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'area_aset_id' => ['required', 'exists:area_asets,id'],
            'pihak_pemanfaat' => ['required', 'string', 'max:255'],
            'jenis_kegiatan' => ['required', 'string', 'max:255'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'tarif_sewa' => ['nullable', 'numeric', 'min:0'],
            'nilai_sewa' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:direncanakan,aktif,selesai,dibatalkan'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function createTagihan(PemanfaatanAset $pemanfaatan): void
    {
        $sourceId = SumberPemasukan::whereIn('kode', ['R-JASA-USAHA', 'R-SPATKT'])->value('id');
        if (! $sourceId) {
            return;
        }

        $tagihan = Tagihan::create([
            'sumber_pemasukan_id' => $sourceId,
            'nomor_tagihan' => 'TAG-ASET-' . $pemanfaatan->id . '-' . Str::upper(Str::random(5)),
            'pihak_tertagih' => $pemanfaatan->pihak_pemanfaat,
            'uraian' => 'Pemanfaatan ' . $pemanfaatan->jenis_kegiatan,
            'tanggal_terbit' => $pemanfaatan->tanggal_mulai,
            'tanggal_jatuh_tempo' => $pemanfaatan->tanggal_selesai,
            'nilai_tagihan' => $pemanfaatan->nilai_sewa,
            'status' => 'terbit',
        ]);
        $pemanfaatan->update(['tagihan_id' => $tagihan->id]);
    }
}