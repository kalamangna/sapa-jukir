@extends('layouts.admin')
@section('title', 'Objek Pendapatan')
@section('page-title', 'Objek Pendapatan')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Objek Pendapatan</h4>
        <p class="text-muted mb-0">Kelola objek pendapatan untuk parkir, usaha, dan aset daerah sesuai kategori sumber pendapatan.</p>
    </div>

    <a href="{{ route('admin.objek-pendapatan.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle me-1"></i>Tambah Objek
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.objek-pendapatan.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="search" class="form-label fw-semibold">Cari Objek</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="search" name="search" value="{{ $search }}" class="form-control" placeholder="OBJ-01 atau Kios Pasar">
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="sumber_pemasukan_id" class="form-label fw-semibold">Kategori Pendapatan</label>
                    <select id="sumber_pemasukan_id" name="sumber_pemasukan_id" class="form-select">
                        <option value="">Semua kategori pendapatan</option>
                        @foreach($sumberPemasukans as $sumber)
                            <option value="{{ $sumber->id }}" @selected((string) $sumberId === (string) $sumber->id)>{{ $sumber->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                    @if($search || $sumberId)
                        <a href="{{ route('admin.objek-pendapatan.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-list-ul me-2 text-primary"></i>Daftar Objek Pendapatan
            </h6>
            <span class="badge text-bg-light border">{{ $objeks->total() }} Data</span>
        </div>
    </div>

    <div class="card-body p-0">
        @if($objeks->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width:60px;">#</th>
                            <th>Kode</th>
                            <th>Nama Objek</th>
                            <th>Kategori Pendapatan</th>
                            <th>Jenis Objek</th>
                            <th>Potensi Bulanan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width:160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($objeks as $index => $objek)
                            <tr>
                                <td class="text-center text-muted">{{ $objeks->firstItem() + $index }}</td>
                                <td class="fw-semibold">{{ $objek->kode }}</td>
                                <td>{{ $objek->nama }}</td>
                                <td>{{ $objek->sumberPemasukan->nama }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($objek->tipe)) }}</td>
                                <td>Rp {{ number_format($objek->potensi_bulanan ?? 0, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $objek->status === 'aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ ucfirst($objek->status) }}
                                    </span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.objek-pendapatan.edit', $objek) }}" class="btn btn-sm btn-outline-warning" title="Ubah" aria-label="Ubah {{ $objek->nama }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.objek-pendapatan.destroy', $objek) }}" class="d-inline" onsubmit="return confirm('Hapus objek pendapatan ini? Data terkait pada objek ini dapat terpengaruh.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" aria-label="Hapus {{ $objek->nama }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inboxes fs-1 text-muted"></i>
                <p class="text-muted mt-3 mb-0">Belum ada objek pendapatan.</p>
            </div>
        @endif
    </div>

    @if($objeks->hasPages())
        <div class="card-footer bg-white">
            {{ $objeks->links() }}
        </div>
    @endif
</div>
@endsection