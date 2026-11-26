<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeringatanCapaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeringatanCapaianController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $peringatans = PeringatanCapaian::with(['sumberPemasukan', 'titikParkir', 'objekPendapatan', 'ditindaklanjutiOleh'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.peringatan-capaian.index', compact('peringatans', 'status'));
    }

    public function update(Request $request, PeringatanCapaian $peringatanCapaian)
    {
        $data = $request->validate([
            'status' => ['required', 'in:terbuka,ditindaklanjuti,selesai'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['ditindaklanjuti_oleh'] = Auth::id();
        $data['ditindaklanjuti_at'] = now();
        $peringatanCapaian->update($data);

        return back()->with('success', 'Status peringatan berhasil diperbarui.');
    }
}