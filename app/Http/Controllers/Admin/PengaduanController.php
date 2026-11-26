<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $pengaduans = Pengaduan::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.pengaduan.index', compact('pengaduans', 'status'));
    }

    public function show(Pengaduan $pengaduan)
    {
        if (!$pengaduan->dibaca_at) {
            $pengaduan->update(['dibaca_at' => now()]);
        }

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $data = $request->validate([
            'status' => ['required', 'in:baru,diproses,selesai,ditolak'],
        ]);

        $pengaduan->update($data);

        return redirect()->route('admin.pengaduan.show', $pengaduan)->with('success', 'Status aduan berhasil diperbarui.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')->with('success', 'Laporan aduan berhasil dihapus.');
    }
}
