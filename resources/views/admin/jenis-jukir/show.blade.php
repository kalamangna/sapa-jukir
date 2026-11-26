@extends('layouts.admin')

@section('title', 'Detail Jenis Petugas')

@section('page-title', 'Detail Jenis Petugas')


@section('content')

{{-- ==========================================================
    HEADER
========================================================== --}}

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Detail Jenis Petugas
        </h4>

        <p class="text-muted mb-0">
            Informasi lengkap master jenis Petugas.
        </p>

    </div>


    <div class="d-flex gap-2">

        {{-- KEMBALI --}}

        <a
            href="{{ route('admin.jenis-jukir.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Kembali

        </a>


        {{-- EDIT --}}

        <a
            href="{{ route('admin.jenis-jukir.edit', $jenisJukir) }}"
            class="btn btn-warning"
        >

            <i class="bi bi-pencil-square me-1"></i>

            Ubah Data

        </a>

    </div>

</div>



{{-- ==========================================================
    INFORMASI UTAMA
========================================================== --}}

<div class="card mb-4">

    <div class="card-body">

        <div class="row align-items-center g-4">


            {{-- ICON --}}

            <div class="col-md-auto text-center">

                <div
                    class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center"
                    style="width:100px;height:100px;"
                >

                    <i
                        class="bi bi-tags"
                        style="font-size:42px;"
                    ></i>

                </div>

            </div>



            {{-- INFORMASI --}}

            <div class="col">

                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3"
                >

                    <div>

                        <div class="mb-2">

                            <span
                                class="badge text-bg-light border font-monospace"
                            >

                                {{ $jenisJukir->kode }}

                            </span>

                        </div>


                        <h3 class="fw-bold mb-2">

                            {{ $jenisJukir->nama }}

                        </h3>


                        <div class="text-muted">

                            Master data jenis Petugas.

                        </div>

                    </div>



                    {{-- STATUS --}}

                    <div>

                        @if($jenisJukir->status)

                            <span class="badge bg-success fs-6">

                                <i class="bi bi-check-circle me-1"></i>

                                Aktif

                            </span>

                        @else

                            <span class="badge bg-secondary fs-6">

                                <i class="bi bi-x-circle me-1"></i>

                                Nonaktif

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
        INFORMASI JENIS Petugas
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">


            {{-- HEADER CARD --}}

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-info-circle me-2 text-success"></i>

                    Informasi Jenis Petugas

                </h6>

            </div>



            {{-- BODY --}}

            <div class="card-body">

                <dl class="row mb-0">


                    {{-- KODE --}}

                    <dt class="col-sm-5 text-muted">

                        Kode

                    </dt>

                    <dd class="col-sm-7">

                        <span class="font-monospace fw-semibold">

                            {{ $jenisJukir->kode }}

                        </span>

                    </dd>



                    {{-- NAMA --}}

                    <dt class="col-sm-5 text-muted">

                        Nama Jenis

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jenisJukir->nama }}

                    </dd>



                    {{-- STATUS --}}

                    <dt class="col-sm-5 text-muted">

                        Status

                    </dt>

                    <dd class="col-sm-7">

                        @if($jenisJukir->status)

                            <span class="badge bg-success">

                                Aktif

                            </span>

                        @else

                            <span class="badge bg-secondary">

                                Nonaktif

                            </span>

                        @endif

                    </dd>



                    {{-- TANGGAL DIBUAT --}}

                    <dt class="col-sm-5 text-muted">

                        Dibuat

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jenisJukir->created_at?->format('d-m-Y H:i') ?? '-' }}

                    </dd>



                    {{-- TERAKHIR DIUPDATE --}}

                    <dt class="col-sm-5 text-muted">

                        Terakhir Diubah

                    </dt>

                    <dd class="col-sm-7">

                        {{ $jenisJukir->updated_at?->format('d-m-Y H:i') ?? '-' }}

                    </dd>


                </dl>

            </div>

        </div>

    </div>



    {{-- ======================================================
        STATISTIK Petugas
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">


            {{-- HEADER --}}

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-bar-chart me-2 text-success"></i>

                    Statistik Petugas

                </h6>

            </div>



            {{-- BODY --}}

            <div class="card-body">

                <div class="text-center py-3">


                    <div
                        class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:100px;height:100px;"
                    >

                        <i
                            class="bi bi-person-badge"
                            style="font-size:42px;"
                        ></i>

                    </div>


                    <h2 class="fw-bold mb-1">

                        {{ $jenisJukir->jukirs_count }}

                    </h2>


                    <p class="text-muted mb-0">

                        Total Petugas menggunakan jenis ini.

                    </p>

                </div>

            </div>

        </div>

    </div>



    {{-- ======================================================
        DESKRIPSI
    ======================================================= --}}

    <div class="col-12">

        <div class="card">


            {{-- HEADER --}}

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-chat-left-text me-2 text-success"></i>

                    Deskripsi

                </h6>

            </div>



            {{-- BODY --}}

            <div class="card-body">

                @if($jenisJukir->deskripsi)

                    <div class="lh-lg">

                        {!! nl2br(e($jenisJukir->deskripsi)) !!}

                    </div>

                @else

                    <div class="text-center py-4 text-muted">

                        <i
                            class="bi bi-file-earmark-text"
                            style="font-size:38px;"
                        ></i>


                        <div class="mt-2">

                            Belum ada deskripsi untuk jenis Petugas ini.

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>



    {{-- ======================================================
        DAFTAR Petugas
    ======================================================= --}}

    <div class="col-12">

        <div class="card">


            {{-- HEADER --}}

            <div
                class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center"
            >

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-people me-2 text-success"></i>

                    Daftar Petugas

                </h6>


                <span class="badge text-bg-light border">

                    {{ $jenisJukir->jukirs_count }}

                    Petugas

                </span>

            </div>



            {{-- BODY --}}

            @if($jenisJukir->jukirs_count > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">

                                    No

                                </th>


                                <th>

                                    Petugas

                                </th>


                                <th>

                                    NIK

                                </th>


                                <th>

                                    Wilayah

                                </th>


                                <th>

                                    Status

                                </th>


                                <th class="text-center pe-4">

                                    Aksi

                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($jenisJukir->jukirs as $jukir)

                                <tr>


                                    {{-- NOMOR --}}

                                    <td class="ps-4 text-muted">

                                        {{ $loop->iteration }}

                                    </td>



                                    {{-- Petugas --}}

                                    <td>

                                        <div class="d-flex align-items-center gap-3">


                                            {{-- FOTO --}}

                                            @if($jukir->foto)

                                                <img
                                                    src="{{ asset('storage/' . $jukir->foto) }}"
                                                    alt="{{ $jukir->nama }}"
                                                    class="rounded-circle object-fit-cover"
                                                    width="45"
                                                    height="45"
                                                >

                                            @else

                                                <div
                                                    class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center fw-bold"
                                                    style="width:45px;height:45px;"
                                                >

                                                    {{ strtoupper(substr($jukir->nama, 0, 1)) }}

                                                </div>

                                            @endif



                                            <div>

                                                <div class="fw-semibold">

                                                    {{ $jukir->nama }}

                                                </div>


                                                <small class="text-muted">

                                                    {{ $jukir->kode_jukir }}

                                                </small>

                                            </div>

                                        </div>

                                    </td>



                                    {{-- NIK --}}

                                    <td>

                                        <span class="font-monospace">

                                            {{ $jukir->nik }}

                                        </span>

                                    </td>



                                    {{-- WILAYAH --}}

                                    <td>

                                        <div class="small fw-semibold">

                                            {{ $jukir->kecamatan?->nama ?? '-' }}

                                        </div>


                                        <small class="text-muted">

                                            {{ $jukir->kelurahan?->nama ?? '-' }}

                                        </small>

                                    </td>



                                    {{-- STATUS --}}

                                    <td>

                                        @if($jukir->status === 'aktif')

                                            <span class="badge bg-success">

                                                Aktif

                                            </span>

                                        @elseif($jukir->status === 'nonaktif')

                                            <span class="badge bg-secondary">

                                                Nonaktif

                                            </span>

                                        @elseif($jukir->status === 'ditangguhkan')

                                            <span class="badge bg-warning text-dark">

                                                Ditangguhkan

                                            </span>

                                        @elseif($jukir->status === 'berhenti')

                                            <span class="badge bg-danger">

                                                Berhenti

                                            </span>

                                        @endif

                                    </td>



                                    {{-- AKSI --}}

                                    <td class="text-center pe-4">

                                        <a
                                            href="{{ route('admin.jukir.show', $jukir) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Lihat Detail Petugas"
                                            aria-label="Lihat Detail {{ $jukir->nama }}"
                                        >

                                            <i class="bi bi-eye"></i>

                                        </a>

                                    </td>


                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                {{-- EMPTY STATE --}}

                <div class="text-center py-5">

                    <div
                        class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:70px;height:70px;"
                    >

                        <i
                            class="bi bi-person-badge text-muted"
                            style="font-size:30px;"
                        ></i>

                    </div>


                    <h6 class="fw-semibold">

                        Belum Ada Petugas

                    </h6>


                    <p class="text-muted mb-0">

                        Belum ada data Petugas yang menggunakan
                        jenis ini.

                    </p>

                </div>

            @endif

        </div>

    </div>


</div>

@endsection