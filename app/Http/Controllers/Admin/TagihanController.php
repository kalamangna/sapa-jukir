<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ObjekPendapatan;
use App\Models\Pembayaran;
use App\Models\SumberPemasukan;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $sourceId = $request->input('sumber_pemasukan_id');
        $tagihans = Tagihan::with(['sumberPemasukan', 'objekPendapatan', 'pembayarans'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($sourceId, fn ($query) => $query->where('sumber_pemasukan_id', $sourceId))
            ->latest('tanggal_jatuh_tempo')
            ->paginate(15)
            ->withQueryString();

        return view('admin.tagihan.index', [
            'tagihans' => $tagihans,
            'status' => $status,
            'sourceId' => $sourceId,
            'sumberPemasukans' => SumberPemasukan::where('status', true)->orderBy('nama')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.tagihan.create', [
            'sumberPemasukans' => SumberPemasukan::where('status', true)->orderBy('nama')->get(),
            'objekPendapatans' => ObjekPendapatan::where('status', 'aktif')->with('sumberPemasukan')->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sumber_pemasukan_id' => ['required', 'exists:sumber_pemasukans,id'],
            'objek_pendapatan_id' => ['nullable', 'exists:objek_pendapatans,id'],
            'nomor_tagihan' => ['nullable', 'string', 'max:80', 'unique:tagihans,nomor_tagihan'],
            'pihak_tertagih' => ['nullable', 'string', 'max:150'],
            'uraian' => ['required', 'string', 'max:255'],
            'tanggal_terbit' => ['required', 'date'],
            'tanggal_jatuh_tempo' => ['required', 'date', 'after_or_equal:tanggal_terbit'],
            'nilai_tagihan' => ['required', 'numeric', 'min:0.01'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $object = ! empty($data['objek_pendapatan_id']) ? ObjekPendapatan::find($data['objek_pendapatan_id']) : null;
        if ($object && (int) $object->sumber_pemasukan_id !== (int) $data['sumber_pemasukan_id']) {
            return back()->withErrors(['objek_pendapatan_id' => 'Objek harus berasal dari sumber pendapatan yang sama.'])->withInput();
        }

        $data['nomor_tagihan'] = $data['nomor_tagihan'] ?? 'TAG-' . now()->format('YmHis') . '-' . Str::upper(Str::random(5));
        Tagihan::create($data);

        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil dibuat.');
    }

    public function bayar(Request $request, Tagihan $tagihan)
    {
        $data = $request->validate([
            'tanggal_bayar' => ['required', 'date'],
            'jumlah_bayar' => ['required', 'numeric', 'min:0.01'],
            'metode' => ['nullable', 'string', 'max:30'],
            'referensi' => ['nullable', 'string', 'max:100'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        if ((float) $data['jumlah_bayar'] > $tagihan->sisa_tagihan) {
            return back()->withErrors(['jumlah_bayar' => 'Pembayaran melebihi sisa tagihan.'])->withInput();
        }

        $data['dibuat_oleh'] = Auth::id();
        $tagihan->pembayarans()->create($data);
        $tagihan->update(['status' => $tagihan->fresh()->sisa_tagihan <= 0 ? 'lunas' : 'sebagian']);

        return back()->with('success', 'Pembayaran berhasil dicatat.');
    }
}