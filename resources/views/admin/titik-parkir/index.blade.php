@extends('layouts.admin')

@section('title', 'Titik / Objek Pendapatan')

@section('page-title', 'Titik / Objek Pendapatan')


@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Titik / Objek Pendapatan
        </h4>

        <p class="text-muted mb-0">
            Kelola data titik dan objek pendapatan daerah.
        </p>

    </div>


    <a
        href="{{ route('admin.titik-parkir.create') }}"
        class="btn btn-success"
    >

        <i class="bi bi-plus-circle me-1"></i>

            Tambah Titik / Objek Pendapatan

    </a>

</div>




{{-- ==========================================================
    SEARCH
========================================================== --}}

<div class="card mb-4">

    <div class="card-body">

        <form
            action="{{ route('admin.titik-parkir.index') }}"
            method="GET"
        >

            <div class="row g-3 align-items-end">

                <div class="col-md-5">

                    <label
                        for="search"
                        class="form-label fw-semibold"
                    >

                        Cari Titik / Objek Pendapatan

                    </label>


                    <div class="input-group">

                        <span class="input-group-text bg-white">

                            <i class="bi bi-search"></i>

                        </span>


                        <input
                            type="text"
                            id="search"
                            name="search"
                            class="form-control"
                            placeholder="Cari kode, nama, atau alamat..."
                            value="{{ $search }}"
                        >

                    </div>

                </div>

                <div class="col-md-4">
                    <label for="kategori_retribusi" class="form-label fw-semibold">
                        Kategori Titik/Objek Pendapatan
                    </label>
                    <select id="kategori_retribusi" name="kategori_retribusi" class="form-select">
                        <option value="all" @selected($kategoriRetribusi === 'all')>Semua Kategori</option>
                        <option value="R-PJTU" @selected($kategoriRetribusi === 'R-PJTU')>Retribusi Pelayanan Parkir Tepi Jalan Umum</option>
                        <option value="R-TKU" @selected($kategoriRetribusi === 'R-TKU')>Retribusi Penyediaan Tempat Kegiatan Usaha</option>
                        <option value="R-TKP" @selected($kategoriRetribusi === 'R-TKP')>Retribusi Tempat Khusus Parkir</option>
                        <option value="R-SPATKT" @selected($kategoriRetribusi === 'R-SPATKT' || $kategoriRetribusi === 'R-JASA-USAHA')>Retribusi Sewa Pelataran Area Terminal untuk Kegiatan Tertentu</option>
                    </select>
                </div>

                <div class="col-md-auto">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-search me-1"></i>

                        Cari

                    </button>

                </div>


                @if($search || $kategoriRetribusi !== 'all')

                    <div class="col-md-auto">

                        <a
                            href="{{ route('admin.titik-parkir.index') }}"
                            class="btn btn-outline-secondary"
                        >

                            <i class="bi bi-arrow-counterclockclockwise me-1"></i>

                            Reset

                        </a>

                    </div>

                @endif

            </div>

        </form>

    </div>

</div>



{{-- ==========================================================
    TABLE BY CATEGORY
========================================================== --}}

@php
    $totalData = collect($groupedTitikParkirs)->sum(fn ($group) => $group['items']->count());
    $categoryStyles = [
        'R-PJTU' => ['badge' => 'bg-primary-subtle text-primary-emphasis border border-primary-subtle', 'accent' => '#0d6efd'],
        'R-TKU' => ['badge' => 'bg-success-subtle text-success-emphasis border border-success-subtle', 'accent' => '#198754'],
        'R-TKP' => ['badge' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle', 'accent' => '#ffc107'],
        'R-JASA-USAHA' => ['badge' => 'bg-info-subtle text-info-emphasis border border-info-subtle', 'accent' => '#0dcaf0'],
        'R-SPATKT' => ['badge' => 'bg-info-subtle text-info-emphasis border border-info-subtle', 'accent' => '#0dcaf0'],
    ];
@endphp

@if($groupedTitikParkirs->isNotEmpty())
    @foreach($groupedTitikParkirs as $group)
        @php
            $style = $categoryStyles[$group['code']] ?? ['badge' => 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle', 'accent' => '#6c757d'];
        @endphp
        <div class="card mb-4" style="border-top: 4px solid {{ $style['accent'] }};">
            <div class="card-body p-0">
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                    <div>
                        <span class="badge {{ $style['badge'] }} rounded-pill px-3 py-2 mb-2">
                            {{ $group['label'] }}
                        </span>
                        <h6 class="mb-1 fw-bold">{{ $group['label'] }}</h6>
                        <small class="text-muted">Total: {{ $group['items']->count() }} data</small>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Titik / Objek</th>
                                <th>Sumber Pendapatan</th>
                                <th>Wilayah</th>
                                <th>Kapasitas</th>
                                <th>Target</th>
                                <th>Status</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($group['items']->isNotEmpty())
                                @foreach($group['items'] as $index => $titikParkir)
                                    <tr>
                                        <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $titikParkir->nama }}</div>
                                            <div><span class="font-monospace small text-muted">{{ $titikParkir->kode_titik }}</span></div>
                                            @if($titikParkir->alamat)
                                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($titikParkir->alamat, 55) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($titikParkir->sumberPemasukan)
                                                <div class="fw-semibold">{{ $titikParkir->sumberPemasukan->nama }}</div>
                                                <small class="text-muted font-monospace">{{ $titikParkir->sumberPemasukan->kode }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="small fw-semibold">{{ $titikParkir->kecamatan?->nama ?? '-' }}</div>
                                            <small class="text-muted">{{ $titikParkir->kelurahan?->nama ?? '-' }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $isBusinessAsset = in_array($titikParkir->sumberPemasukan?->kode, ['R-TKU', 'R-JASA-USAHA', 'R-SPATKT'], true);
                                            @endphp
                                            @if($isBusinessAsset)
                                                <div class="small"><i class="bi bi-building me-1"></i>Unit: <strong>{{ $titikParkir->jumlah_unit ?? 0 }}</strong></div>
                                                <div class="small"><i class="bi bi-rulers me-1"></i>Luas: <strong>{{ number_format((float) ($titikParkir->luas_m2 ?? 0), 0, ',', '.') }} m²</strong></div>
                                            @else
                                                <div class="small"><i class="bi bi-bicycle me-1"></i>Motor: <strong>{{ $titikParkir->kapasitas_motor ?? 0 }}</strong></div>
                                                <div class="small"><i class="bi bi-car-front me-1"></i>Mobil: <strong>{{ $titikParkir->kapasitas_mobil ?? 0 }}</strong></div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="small">Bulanan</div>
                                            <strong>Rp {{ number_format($titikParkir->targetPendapatans->sum('target'), 0, ',', '.') }}</strong>
                                            <div class="small text-muted">/ bulan</div>
                                        </td>
                                        <td>
                                            @if($titikParkir->status === 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($titikParkir->status === 'nonaktif')
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @elseif($titikParkir->status === 'sementara')
                                                <span class="badge bg-warning text-dark">Sementara</span>
                                            @elseif($titikParkir->status === 'bermasalah')
                                                <span class="badge bg-danger">Bermasalah</span>
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.titik-parkir.show', $titikParkir) }}" class="btn btn-sm btn-outline-primary" title="Detail"><i class="bi bi-eye"></i></a>
                                                <a href="{{ route('admin.titik-parkir.edit', $titikParkir) }}" class="btn btn-sm btn-outline-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-titik-parkir" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteTitikParkirModal" data-url="{{ route('admin.titik-parkir.destroy', $titikParkir) }}" data-nama="{{ $titikParkir->nama }}" data-kode="{{ $titikParkir->kode_titik }}"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Belum ada data pada kategori ini.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="card">
        <div class="card-body">
            <div class="text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px;">
                    <i class="bi bi-geo-alt text-muted" style="font-size:30px;"></i>
                </div>
                <h5 class="fw-semibold">Data Titik / Objek Belum Tersedia</h5>
                <p class="text-muted mb-4">
                    @if($search)
                        Data dengan kata kunci <strong>"{{ $search }}"</strong> tidak ditemukan.
                    @else
                        Belum ada data untuk kategori yang dipilih.
                    @endif
                </p>
                @if($search || $kategoriRetribusi !== 'all')
                    <a href="{{ route('admin.titik-parkir.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali ke Semua Data</a>
                @else
                    <a href="{{ route('admin.titik-parkir.create') }}" class="btn btn-success"><i class="bi bi-plus-circle me-1"></i>Tambah Titik/Objek Pendapatan Pertama</a>
                @endif
            </div>
        </div>
    </div>
@endif



{{-- ==========================================================
    MODAL KONFIRMASI HAPUS
========================================================== --}}

<div
    class="modal fade"
    id="deleteTitikParkirModal"
    tabindex="-1"
    aria-labelledby="deleteTitikParkirModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5
                    class="modal-title fw-bold"
                    id="deleteTitikParkirModalLabel"
                >

                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>

                    Hapus Titik/Objek Pendapatan

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>



            <div class="modal-body">

                <p class="mb-2">

                    Apakah Anda yakin ingin menghapus titik/objek pendapatan:

                </p>


                <div class="alert alert-danger mb-0">

                    <strong id="deleteTitikParkirName">
                        -
                    </strong>

                    <div class="small mt-1">

                        Kode:
                        <span id="deleteTitikParkirKode">
                            -
                        </span>

                    </div>

                </div>


                <div class="alert alert-warning mt-3 mb-0">

                    <i class="bi bi-exclamation-triangle me-2"></i>

                    Titik/Objek Pendapatan yang masih digunakan oleh
                    Penempatan Petugas atau Tarif tidak dapat dihapus.

                </div>


                <p class="text-muted small mt-3 mb-0">

                    Data yang sudah dihapus tidak dapat dikembalikan.

                </p>

            </div>



            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light border"
                    data-bs-dismiss="modal"
                >

                    <i class="bi bi-x-circle me-1"></i>

                    Batal

                </button>


                <form
                    id="deleteTitikParkirForm"
                    method="POST"
                >

                    @csrf

                    @method('DELETE')


                    <button
                        type="submit"
                        class="btn btn-danger"
                    >

                        <i class="bi bi-trash me-1"></i>

                        Ya, Hapus

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const deleteButtons = document.querySelectorAll(
        '.btn-delete-titik-parkir'
    );

    const deleteForm = document.getElementById(
        'deleteTitikParkirForm'
    );

    const deleteName = document.getElementById(
        'deleteTitikParkirName'
    );

    const deleteKode = document.getElementById(
        'deleteTitikParkirKode'
    );


    deleteButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            deleteForm.action = this.dataset.url;

            deleteName.textContent = this.dataset.nama;

            deleteKode.textContent = this.dataset.kode;

        });

    });

});

</script>

@endpush