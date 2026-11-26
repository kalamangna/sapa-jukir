@extends('layouts.admin')

@section('title', 'Detail Petugas')

@section('page-title', 'Detail Petugas')


@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Detail Petugas
        </h4>

        <p class="text-muted mb-0">
            Informasi lengkap data Petugas.
        </p>

    </div>


    <div class="d-flex gap-2">

        <a
            href="{{ route('admin.jukir.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Kembali

        </a>


        <a
            href="{{ route('admin.jukir.edit', $jukir) }}"
            class="btn btn-warning"
        >

            <i class="bi bi-pencil-square me-1"></i>

            Edit Data

        </a>

    </div>

</div>



{{-- ==========================================================
    PROFIL Petugas
========================================================== --}}

<div class="card mb-4">

    <div class="card-body">

        <div class="row align-items-center">


            {{-- FOTO --}}

            <div class="col-md-auto text-center mb-3 mb-md-0">

                @if($jukir->foto)

                    <img
                        src="{{ asset('storage/' . $jukir->foto) }}"
                        alt="{{ $jukir->nama }}"
                        class="rounded-circle border object-fit-cover"
                        width="130"
                        height="130"
                    >

                @else

                    <div
                        class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center fw-bold"
                        style="width:130px;height:130px;font-size:42px;"
                    >

                        {{ strtoupper(substr($jukir->nama, 0, 1)) }}

                    </div>

                @endif

            </div>


            {{-- IDENTITAS UTAMA --}}

            <div class="col">

                <div class="d-flex flex-column flex-md-row justify-content-between gap-3">

                    <div>

                        <h3 class="fw-bold mb-1">

                            {{ $jukir->nama }}

                        </h3>

                        <div class="text-muted mb-2">

                            {{ $jukir->kode_jukir }}

                        </div>


                        @if($jukir->jenisJukir)

                            <span class="badge text-bg-light border">

                                {{ $jukir->jenisJukir->nama }}

                            </span>

                        @endif

                    </div>


                    <div>

                        @if($jukir->status === 'aktif')

                            <span class="badge bg-success fs-6">

                                Aktif

                            </span>

                        @elseif($jukir->status === 'nonaktif')

                            <span class="badge bg-secondary fs-6">

                                Nonaktif

                            </span>

                        @elseif($jukir->status === 'ditangguhkan')

                            <span class="badge bg-warning text-dark fs-6">

                                Ditangguhkan

                            </span>

                        @elseif($jukir->status === 'berhenti')

                            <span class="badge bg-danger fs-6">

                                Berhenti

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<div class="row g-4">


    {{-- ======================================================
        DATA IDENTITAS
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-person-vcard me-2 text-success"></i>

                    Data Identitas

                </h6>

            </div>


            <div class="card-body">

                <dl class="row mb-0">

                    <dt class="col-sm-5 text-muted">

                        Kode Petugas

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jukir->kode_jukir }}

                    </dd>


                    <dt class="col-sm-5 text-muted">

                        NIK

                    </dt>

                    <dd class="col-sm-7 font-monospace">

                        {{ $jukir->nik }}

                    </dd>


                    <dt class="col-sm-5 text-muted">

                        Nama

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jukir->nama }}

                    </dd>


                    <dt class="col-sm-5 text-muted">

                        Tempat Lahir

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jukir->tempat_lahir ?? '-' }}

                    </dd>


                    <dt class="col-sm-5 text-muted">

                        Tanggal Lahir

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jukir->tanggal_lahir?->format('d-m-Y') ?? '-' }}

                    </dd>


                    <dt class="col-sm-5 text-muted">

                        Jenis Kelamin

                    </dt>

                    <dd class="col-sm-7">

                        @if($jukir->jenis_kelamin === 'L')

                            Laki-laki

                        @elseif($jukir->jenis_kelamin === 'P')

                            Perempuan

                        @else

                            -

                        @endif

                    </dd>

                </dl>

            </div>

        </div>

    </div>



    {{-- ======================================================
        ALAMAT DAN WILAYAH
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-geo-alt me-2 text-success"></i>

                    Alamat dan Wilayah

                </h6>

            </div>


            <div class="card-body">

                <dl class="row mb-0">

                    <dt class="col-sm-5 text-muted">

                        Alamat

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jukir->alamat ?? '-' }}

                    </dd>


                    <dt class="col-sm-5 text-muted">

                        Kecamatan

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jukir->kecamatan?->nama ?? '-' }}

                    </dd>


                    <dt class="col-sm-5 text-muted">

                        Kelurahan

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jukir->kelurahan?->nama ?? '-' }}

                    </dd>


                    <dt class="col-sm-5 text-muted">

                        Nomor HP

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jukir->no_hp ?? '-' }}

                    </dd>

                </dl>

            </div>

        </div>

    </div>



    {{-- ======================================================
        DATA KARTU
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-credit-card me-2 text-success"></i>

                    Data Kartu

                </h6>

            </div>


            <div class="card-body">

                <dl class="row mb-0">

                    <dt class="col-sm-5 text-muted">

                        Nomor Kartu

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jukir->nomor_kartu ?? '-' }}

                    </dd>


                    <dt class="col-sm-5 text-muted">

                        Tanggal Terdaftar

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jukir->tanggal_terdaftar?->format('d-m-Y') ?? '-' }}

                    </dd>


                    <dt class="col-sm-5 text-muted">

                        Tanggal Berakhir

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jukir->tanggal_berakhir?->format('d-m-Y') ?? '-' }}

                    </dd>


                    <dt class="col-sm-5 text-muted">

                        Status

                    </dt>

                    <dd class="col-sm-7">

                        {{ ucfirst($jukir->status) }}

                    </dd>

                </dl>

            </div>

        </div>

    </div>



    {{-- ======================================================
        FOTO KTP
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-card-image me-2 text-success"></i>

                    Dokumen KTP

                </h6>

            </div>


            <div class="card-body text-center">

                @if($jukir->foto_ktp)

                    <a
                        href="{{ asset('storage/' . $jukir->foto_ktp) }}"
                        target="_blank"
                    >

                        <img
                            src="{{ asset('storage/' . $jukir->foto_ktp) }}"
                            alt="KTP {{ $jukir->nama }}"
                            class="img-fluid rounded border"
                            style="max-height:250px;"
                        >

                    </a>

                    <div class="small text-muted mt-2">

                        Klik gambar untuk melihat ukuran penuh.

                    </div>

                @else

                    <div class="py-4 text-muted">

                        <i
                            class="bi bi-card-image"
                            style="font-size:40px;"
                        ></i>

                        <div class="mt-2">

                            Foto KTP belum tersedia.

                        </div>

                    </div>

                @endif

                @if($jukir->dokumen_pendukung)
                    <div class="mt-3">
                        <div class="text-muted small mb-1">Dokumen Pendukung</div>
                        <a href="{{ asset('storage/' . $jukir->dokumen_pendukung) }}" target="_blank" rel="noopener">Lihat dokumen pendukung</a>
                    </div>
                @endif

            </div>

        </div>

    </div>



    {{-- ======================================================
        KETERANGAN
    ======================================================= --}}

    <div class="col-12">

        <div class="card">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-chat-left-text me-2 text-success"></i>

                    Keterangan

                </h6>

            </div>


            <div class="card-body">

                @if($jukir->keterangan)

                    {!! nl2br(e($jukir->keterangan)) !!}

                @else

                    <span class="text-muted">

                        Tidak ada keterangan.

                    </span>

                @endif

            </div>

        </div>

    </div>


</div>



@endsection