<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $galleryRows = Gallery::query()
            ->when($search, function ($query, $search) {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            })
            ->orderBy('urutan')
            ->latest()
            ->get();
        $galleryGroups = $galleryRows
            ->groupBy(fn ($gallery) => $gallery->gallery_group ?: 'legacy-' . $gallery->id)
            ->map(function ($items) {
                $gallery = $items->first();
                $gallery->gallery_images = $items->pluck('gambar')->values();
                $gallery->gallery_ids = $items->pluck('id')->values();
                return $gallery;
            })
            ->values();
        $perPage = 10;
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $galleries = new \Illuminate\Pagination\LengthAwarePaginator(
            $galleryGroups->forPage($currentPage, $perPage)->values(),
            $galleryGroups->count(),
            $perPage,
            $currentPage,
            ['path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('admin.gallery.index', compact('galleries', 'search'));
    }

    public function create()
    {
        return view('admin.gallery.create', ['kategoriOptions' => Gallery::CATEGORIES]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['gallery_group'] = (string) Str::uuid();

        foreach ($request->file('gambar') as $gambar) {
            Gallery::create(array_merge($data, [
                'gambar' => $gambar->store('gallery', 'public'),
            ]));
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        $galleryImages = $gallery->gallery_group
            ? Gallery::where('gallery_group', $gallery->gallery_group)->pluck('gambar')
            : collect([$gallery->gambar]);

        return view('admin.gallery.edit', compact('gallery', 'galleryImages') + ['kategoriOptions' => Gallery::CATEGORIES]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $this->validated($request, false);
        $data['is_active'] = $request->boolean('is_active');

        $galleryGroup = $gallery->gallery_group ?: (string) Str::uuid();
        $existingCount = Gallery::where('gallery_group', $galleryGroup)->count() ?: 1;
        $newImages = $request->file('gambar', []);

        if (count($newImages) + $existingCount > 3) {
            return back()->withErrors(['gambar' => 'Satu kegiatan maksimal memiliki 3 foto.'])->withInput();
        }

        unset($data['gambar']);
        $data['gallery_group'] = $galleryGroup;
        $gallery->update($data);

        foreach ($newImages as $gambar) {
            Gallery::create(array_merge($data, [
                'gambar' => $gambar->store('gallery', 'public'),
            ]));
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Dokumentasi berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $galleryItems = $gallery->gallery_group
            ? Gallery::where('gallery_group', $gallery->gallery_group)->get()
            : collect([$gallery]);

        foreach ($galleryItems as $galleryItem) {
            Storage::disk('public')->delete($galleryItem->gambar);
            $galleryItem->delete();
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Dokumentasi berhasil dihapus.');
    }

    private function validated(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in(Gallery::CATEGORIES)],
            'tanggal_kegiatan' => ['nullable', 'date'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => [$imageRequired ? 'required' : 'nullable', 'array', 'max:3'],
            'gambar.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
