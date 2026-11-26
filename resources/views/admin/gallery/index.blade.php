@extends('layouts.admin')

@section('title', 'Gallery')
@section('page-title', 'Gallery')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Gallery Publik</h4>
        <p class="text-muted mb-0">Kelola dokumentasi yang tampil pada halaman publik.</p>
    </div>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i>Tambah Dokumentasi
    </a>
</div>

<div class="card">
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Kegiatan Pasar Sentral">
            </div>
            <div class="col-auto"><button class="btn btn-outline-secondary" type="submit">Filter</button></div>
            @if($search)<div class="col-auto"><a class="btn btn-light" href="{{ route('admin.gallery.index') }}">Reset</a></div>@endif
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th width="80">Foto</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Urutan</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @forelse($galleries as $gallery)
                <tr>
                    <td>
                        <div class="d-flex gap-1">
                            @foreach($gallery->gallery_images as $galleryImage)
                                <img src="{{ asset('storage/' . $galleryImage) }}" alt="{{ $gallery->judul }}" width="64" height="48" class="rounded object-fit-cover">
                            @endforeach
                        </div>
                    </td>
                    <td><strong>{{ $gallery->judul }}</strong><div class="small text-muted">{{ Str::limit($gallery->deskripsi, 70) }}</div></td>
                    <td>{{ $gallery->kategori ?: '-' }}</td>
                    <td><span class="badge {{ $gallery->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $gallery->is_active ? 'Aktif' : 'Tidak aktif' }}</span></td>
                    <td>{{ $gallery->urutan }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn btn-sm btn-outline-warning" title="Ubah" aria-label="Ubah {{ $gallery->judul }}"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus dokumentasi ini? Foto terkait akan ikut terhapus.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit" title="Hapus" aria-label="Hapus {{ $gallery->judul }}"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Belum ada dokumentasi galeri.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($galleries->hasPages())<div class="card-footer">{{ $galleries->links() }}</div>@endif
</div>
@endsection
