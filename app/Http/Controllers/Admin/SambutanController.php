<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sambutan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SambutanController extends Controller
{
    public function index()
    {
        $sambutan = Sambutan::query()->latest()->first();
        return view('admin.sambutan.index', compact('sambutan'));
    }

    public function store(Request $request)
    {
        return $this->save($request, new Sambutan());
    }

    public function update(Request $request, Sambutan $sambutan)
    {
        return $this->save($request, $sambutan);
    }

    private function save(Request $request, Sambutan $sambutan)
    {
        $data = $request->validate([
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'foto_kadis' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'background_color' => ['nullable', 'string', 'max:255'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('foto')) {
            if ($sambutan->foto) {
                Storage::disk('public')->delete($sambutan->foto);
            }
            $data['foto'] = $request->file('foto')->store('sambutan', 'public');
        }

        if ($request->hasFile('foto_kadis')) {
            if ($sambutan->foto_kadis) {
                Storage::disk('public')->delete($sambutan->foto_kadis);
            }
            $data['foto_kadis'] = $request->file('foto_kadis')->store('sambutan', 'public');
        }

        $sambutan->fill($data)->save();

        return redirect()->route('admin.sambutan.index')->with('success', 'Sambutan Kepala Dinas berhasil disimpan.');
    }
}
