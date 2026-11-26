<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreObjekPendapatanRequest;
use App\Http\Requests\UpdateObjekPendapatanRequest;
use App\Models\ObjekPendapatan;
use App\Models\SumberPemasukan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ObjekPendapatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sumberId = $request->input('sumber_pemasukan_id');
        $tipe = $request->input('tipe');
        $objeks = ObjekPendapatan::with('sumberPemasukan')
            ->when($search, fn ($query) => $query->where(function ($builder) use ($search) {
                $builder->where('kode', 'like', "%{$search}%")->orWhere('nama', 'like', "%{$search}%");
            }))
            ->when($sumberId, fn ($query) => $query->where('sumber_pemasukan_id', $sumberId))
            ->when($tipe, fn ($query) => $query->where('tipe', $tipe))
            ->orderBy('nama')->paginate(15)->withQueryString();
        $sumberPemasukans = SumberPemasukan::where('status', true)->orderBy('nama')->get();

        return view('admin.objek-pendapatan.index', compact('objeks', 'sumberPemasukans', 'search', 'sumberId', 'tipe'));
    }

    public function create(Request $request)
    {
        return view('admin.objek-pendapatan.create', [
            'tipe' => $request->input('tipe'),
            'sumberPemasukans' => SumberPemasukan::where('status', true)->orderBy('nama')->get(),
        ]);
    }

    public function store(StoreObjekPendapatanRequest $request)
    {
        $data = $request->validated();
        $this->ensureUniqueCode($data);
        ObjekPendapatan::create($data);

        return redirect()->route('admin.objek-pendapatan.index')->with('success', 'Objek pendapatan berhasil ditambahkan.');
    }

    public function edit(ObjekPendapatan $objekPendapatan)
    {
        return view('admin.objek-pendapatan.edit', ['objek' => $objekPendapatan, 'sumberPemasukans' => SumberPemasukan::where('status', true)->orWhere('id', $objekPendapatan->sumber_pemasukan_id)->orderBy('nama')->get()]);
    }

    public function update(UpdateObjekPendapatanRequest $request, ObjekPendapatan $objekPendapatan)
    {
        $data = $request->validated();
        $this->ensureUniqueCode($data, $objekPendapatan);
        $objekPendapatan->update($data);

        return redirect()->route('admin.objek-pendapatan.index')->with('success', 'Objek pendapatan berhasil diperbarui.');
    }

    public function destroy(ObjekPendapatan $objekPendapatan)
    {
        if ($objekPendapatan->setorans()->exists() || $objekPendapatan->targetPendapatans()->exists()) {
            return back()->with('error', 'Objek pendapatan tidak dapat dihapus karena masih digunakan.');
        }
        $objekPendapatan->delete();

        return redirect()->route('admin.objek-pendapatan.index')->with('success', 'Objek pendapatan berhasil dihapus.');
    }

    private function ensureUniqueCode(array $data, ?ObjekPendapatan $existing = null): void
    {
        $query = ObjekPendapatan::where('sumber_pemasukan_id', $data['sumber_pemasukan_id'])->where('kode', $data['kode']);
        if ($existing) {
            $query->whereKeyNot($existing->id);
        }
        if ($query->exists()) {
            throw ValidationException::withMessages([
                'kode' => 'Kode objek pendapatan sudah digunakan pada sumber ini.',
            ]);
        }
    }
}