<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSumberPemasukanRequest;
use App\Http\Requests\UpdateSumberPemasukanRequest;
use App\Models\SumberPemasukan;
use Illuminate\Http\Request;

class SumberPemasukanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sumberPemasukans = SumberPemasukan::query()
            ->when($search, fn ($query) => $query->where(function ($builder) use ($search) {
                $builder->where('kode', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");
            }))
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('admin.sumber-pemasukan.index', compact('sumberPemasukans', 'search'));
    }

    public function create()
    {
        return view('admin.sumber-pemasukan.create');
    }

    public function store(StoreSumberPemasukanRequest $request)
    {
        SumberPemasukan::create($request->validated());

        return redirect()->route('admin.sumber-pemasukan.index')->with('success', 'Sumber pendapatan berhasil ditambahkan.');
    }

    public function edit(SumberPemasukan $sumberPemasukan)
    {
        return view('admin.sumber-pemasukan.edit', compact('sumberPemasukan'));
    }

    public function update(UpdateSumberPemasukanRequest $request, SumberPemasukan $sumberPemasukan)
    {
        $sumberPemasukan->update($request->validated());

        return redirect()->route('admin.sumber-pemasukan.index')->with('success', 'Sumber pendapatan berhasil diperbarui.');
    }

    public function destroy(SumberPemasukan $sumberPemasukan)
    {
        if ($sumberPemasukan->setorans()->exists() || $sumberPemasukan->titikParkirs()->exists() || $sumberPemasukan->targetPendapatans()->exists()) {
            return back()->with('error', 'Sumber pendapatan tidak dapat dihapus karena masih digunakan.');
        }

        $sumberPemasukan->delete();

        return redirect()->route('admin.sumber-pemasukan.index')->with('success', 'Sumber pendapatan berhasil dihapus.');
    }

}