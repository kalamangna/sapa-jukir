@extends('layouts.admin')

@section('title', 'Pengaturan Berita')
@section('page-title', 'Pengaturan Berita')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Berita Publik</h4>
        <p class="text-muted mb-0">Kelola berita yang ditampilkan pada halaman publik SAPA JUKIR.</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i>Tambah Berita
    </a>
</div>

<div class="card">
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Penertiban Parkir Pasar">
            </div>
            <div class="col-auto"><button class="btn btn-outline-secondary" type="submit">Filter</button></div>
            @if($search)<div class="col-auto"><a class="btn btn-light" href="{{ route('admin.news.index') }}">Reset</a></div>@endif
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr><th width="96">Gambar</th><th>Judul</th><th>Kategori</th><th>Tanggal Publikasi</th><th>Status</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($newsItems as $news)
                <tr>
                    <td><img src="{{ asset('storage/' . $news->gambar) }}" alt="{{ $news->judul }}" width="76" height="56" class="rounded object-fit-cover"></td>
                    <td>
                        <strong>{{ $news->judul }}</strong>
                        <div class="small text-muted">{{ Str::limit($news->ringkasan, 80) }}</div>
                    </td>
                    <td>{{ $news->kategori ?: '-' }}</td>
                    <td>{{ $news->published_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td><span class="badge {{ $news->is_published ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $news->is_published ? 'Terbit' : 'Draft' }}</span></td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-sm btn-outline-warning" aria-label="Ubah {{ $news->judul }}"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.news.destroy', $news) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus berita ini? Konten dan foto berita akan dihapus permanen.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Hapus {{ $news->judul }}"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Belum ada berita. Tambahkan berita pertama untuk ditampilkan di halaman publik.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($newsItems->hasPages())<div class="card-footer">{{ $newsItems->links() }}</div>@endif
</div>
@endsection
