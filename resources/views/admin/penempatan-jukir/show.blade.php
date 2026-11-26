@extends('layouts.admin')

@section('title', 'Detail Penempatan Petugas')

@section('page-title', 'Detail Penempatan Petugas')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

<div>

    <h4 class="mb-1 fw-bold">
        Detail Penempatan Petugas
    </h4>

    <p class="text-muted mb-0">
        Informasi lengkap penempatan Petugas.
    </p>

</div>


<div class="d-flex gap-2">

    @unless(auth()->user()->isPimpinan())
    <a
        href="{{ route('admin.penempatan-jukir.edit', $penempatanJukir) }}"
        class="btn btn-warning"
    >

        <i class="bi bi-pencil-square me-1"></i>

        Edit

    </a>
    @endunless


    <a
        href="{{ route('admin.penempatan-jukir.index') }}"
        class="btn btn-outline-secondary"
    >

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>

</div>

<div class="row g-4">

{{-- ======================================================
    INFORMASI Petugas
======================================================= --}}

<div class="col-lg-6">

    <div class="card h-100">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-person-badge me-2 text-success"></i>

                Informasi Petugas

            </h6>

        </div>


        <div class="card-body">

            @if($penempatanJukir->jukir)

                <div class="mb-3">

                    <div class="text-muted small">
                        Kode Petugas
                    </div>

                    <div class="fw-semibold font-monospace">
                        {{ $penempatanJukir->jukir->kode_jukir }}
                    </div>

                </div>


                <div class="mb-3">

                    <div class="text-muted small">
                        Nama Petugas
                    </div>

                    <div class="fw-semibold">
                        {{ $penempatanJukir->jukir->nama }}
                    </div>

                </div>


                <div class="mb-3">

                    <div class="text-muted small">
                        Jenis Kelamin
                    </div>

                    <div class="fw-semibold">

                        @if($penempatanJukir->jukir->jenis_kelamin === 'L')

                            Laki-laki

                        @elseif($penempatanJukir->jukir->jenis_kelamin === 'P')

                            Perempuan

                        @else

                            -

                        @endif

                    </div>

                </div>


                <div>

                    <div class="text-muted small">
                        Status Petugas
                    </div>

                    <div>

                        @if($penempatanJukir->jukir->status === 'aktif')

                            <span class="badge bg-success">
                                Aktif
                            </span>

                        @elseif($penempatanJukir->jukir->status === 'nonaktif')

                            <span class="badge bg-secondary">
                                Nonaktif
                            </span>

                        @elseif($penempatanJukir->jukir->status === 'sementara')

                            <span class="badge bg-warning text-dark">
                                Sementara
                            </span>

                        @elseif($penempatanJukir->jukir->status === 'bermasalah')

                            <span class="badge bg-danger">
                                Bermasalah
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ $penempatanJukir->jukir->status ?? '-' }}
                            </span>

                        @endif

                    </div>

                </div>

            @else

                <div class="text-muted">
                    Data Petugas tidak ditemukan.
                </div>

            @endif

        </div>

    </div>

</div>


{{-- ======================================================
    INFORMASI TITIK PARKIR
======================================================= --}}

<div class="col-lg-6">

    <div class="card h-100">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-geo-alt me-2 text-success"></i>

                Informasi Titik Parkir

            </h6>

        </div>


        <div class="card-body">

            @if($penempatanJukir->titikParkir)

                <div class="mb-3">

                    <div class="text-muted small">
                        Kode Titik
                    </div>

                    <div class="fw-semibold font-monospace">
                        {{ $penempatanJukir->titikParkir->kode_titik }}
                    </div>

                </div>


                <div class="mb-3">

                    <div class="text-muted small">
                        Nama Titik Parkir
                    </div>

                    <div class="fw-semibold">
                        {{ $penempatanJukir->titikParkir->nama }}
                    </div>

                </div>


                <div class="mb-3">

                    <div class="text-muted small">
                        Alamat
                    </div>

                    <div>
                        {{ $penempatanJukir->titikParkir->alamat ?? '-' }}
                    </div>

                </div>


                <div>

                    <div class="text-muted small">
                        Status Titik Parkir
                    </div>

                    <div>

                        @if($penempatanJukir->titikParkir->status === 'aktif')

                            <span class="badge bg-success">
                                Aktif
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ $penempatanJukir->titikParkir->status ?? '-' }}
                            </span>

                        @endif

                    </div>

                </div>

            @else

                <div class="text-muted">
                    Data titik parkir tidak ditemukan.
                </div>

            @endif

        </div>

    </div>

</div>


{{-- ======================================================
    INFORMASI PENEMPATAN
======================================================= --}}

<div class="col-12">

    <div class="card">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-clipboard-check me-2 text-success"></i>

                Informasi Penempatan

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-4">


                {{-- TANGGAL MULAI --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Tanggal Mulai
                    </div>

                    <div class="fw-semibold">

                        {{ $penempatanJukir->tanggal_mulai?->format('d-m-Y') ?? '-' }}

                    </div>

                </div>


                {{-- TANGGAL SELESAI --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Tanggal Selesai
                    </div>

                    <div class="fw-semibold">

                        {{ $penempatanJukir->tanggal_selesai?->format('d-m-Y') ?? '-' }}

                    </div>

                </div>


                {{-- STATUS --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Status Penempatan
                    </div>

                    <div>

                        @if($penempatanJukir->status === 'aktif')

                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Aktif
                            </span>

                        @elseif($penempatanJukir->status === 'selesai')

                            <span class="badge bg-secondary">
                                <i class="bi bi-check2-all me-1"></i>
                                Selesai
                            </span>

                        @elseif($penempatanJukir->status === 'dibatalkan')

                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle me-1"></i>
                                Dibatalkan
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                -
                            </span>

                        @endif

                    </div>

                </div>


                {{-- SURAT PENUGASAN --}}

                <div class="col-md-6">

                    <div class="text-muted small">
                        Surat Penugasan
                    </div>

                    <div class="fw-semibold">

                        {{ $penempatanJukir->surat_penugasan ?? '-' }}

                    </div>

                </div>


                {{-- CREATED AT --}}

                <div class="col-md-6">

                    <div class="text-muted small">
                        Dibuat
                    </div>

                    <div class="fw-semibold">

                        {{ $penempatanJukir->created_at?->format('d-m-Y H:i') ?? '-' }}

                    </div>

                </div>


                {{-- KETERANGAN --}}

                <div class="col-12">

                    <div class="text-muted small mb-1">
                        Keterangan
                    </div>

                    <div class="p-3 bg-light rounded">

                        {{ $penempatanJukir->keterangan ?? '-' }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

@endsection
