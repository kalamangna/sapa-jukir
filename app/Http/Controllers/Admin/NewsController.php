<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $newsItems = News::query()
            ->when($search !== '', fn ($query) => $query
                ->where(fn ($query) => $query
                    ->where('judul', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.news.index', compact('newsItems', 'search'));
    }

    public function create()
    {
        return view('admin.news.create', ['news' => new News()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['judul']);
        $data['gambar'] = $request->file('gambar')->store('news', 'public');
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($data['published_at'] ?? now()) : null;

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = $this->validated($request, false);
        $data['slug'] = $this->uniqueSlug($data['judul'], $news);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($data['published_at'] ?? $news->published_at ?? now()) : null;

        if ($request->hasFile('gambar')) {
            $newImage = $request->file('gambar')->store('news', 'public');
            Storage::disk('public')->delete($news->gambar);
            $data['gambar'] = $newImage;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        Storage::disk('public')->delete($news->gambar);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }

    private function validated(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'gambar' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function uniqueSlug(string $title, ?News $news = null): string
    {
        $baseSlug = Str::slug($title) ?: 'berita';
        $slug = $baseSlug;
        $suffix = 2;

        while (News::query()
            ->where('slug', $slug)
            ->when($news, fn ($query) => $query->where('id', '!=', $news->getKey()))
            ->exists()) {
            $slug = $baseSlug . '-' . $suffix++;
        }

        return $slug;
    }
}
