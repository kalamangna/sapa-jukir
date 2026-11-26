@extends('layouts.admin')

@section('title', 'Detail Jenis Retribusi (Parkir)')

@section('page-title', 'Detail Jenis Retribusi (Parkir)')


@section('content')

{{-- ==========================================================
    HEADER
========================================================== --}}

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Detail Jenis Sumber Pendapatan
        </h4>

        <p class="text-muted mb-0">
            Informasi lengkap master data jenis sumber pendapatan untuk objek pendapatan.
        </p>

    </div>


    <div class="d-flex gap-2">

        <a
            href="{{ route('admin.jenis-parkir.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Kembali

        </a>


        <a
            href="{{ route('admin.jenis-parkir.edit', $jenisParkir) }}"
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
                        class="bi bi-signpost-2"
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

                                {{ $jenisParkir->kode }}

                            </span>

                        </div>


                        <h3 class="fw-bold mb-2">

                            {{ $jenisParkir->nama }}

                        </h3>


                        <div class="text-muted">

                            Master data jenis sumber pendapatan.

                        </div>

                    </div>



                    {{-- STATUS --}}

                    <div>

                        @if($jenisParkir->status)

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
        INFORMASI JENIS PARKIR
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-info-circle me-2 text-success"></i>

                    Informasi Jenis Sumber Pendapatan

                </h6>

            </div>



            <div class="card-body">

                <dl class="row mb-0">


                    {{-- KODE --}}

                    <dt class="col-sm-5 text-muted">
                        Kode
                    </dt>

                    <dd class="col-sm-7">

                        <span class="font-monospace fw-semibold">

                            {{ $jenisParkir->kode }}

                        </span>

                    </dd>



                    {{-- NAMA --}}

                    <dt class="col-sm-5 text-muted">
                        Nama Jenis
                    </dt>

                    <dd class="col-sm-7">

                        {{ $jenisParkir->nama }}

                    </dd>



                    {{-- STATUS --}}

                    <dt class="col-sm-5 text-muted">
                        Status
                    </dt>

                    <dd class="col-sm-7">

                        @if($jenisParkir->status)

                            <span class="badge bg-success">
                                Aktif
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                Nonaktif
                            </span>

                        @endif

                    </dd>



                    {{-- DIBUAT --}}

                    <dt class="col-sm-5 text-muted">
                        Dibuat
                    </dt>

                    <dd class="col-sm-7">

                        {{ $jenisParkir->created_at?->format('d-m-Y H:i') ?? '-' }}

                    </dd>



                    {{-- DIUBAH --}}

                    <dt class="col-sm-5 text-muted">
                        Terakhir Diubah
                    </dt>

                    <dd class="col-sm-7">

                        {{ $jenisParkir->updated_at?->format('d-m-Y H:i') ?? '-' }}

                    </dd>

                </dl>

            </div>

        </div>

    </div>



    {{-- ======================================================
        STATISTIK
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-bar-chart me-2 text-success"></i>

                    Statistik Parkir

                </h6>

            </div>



            <div class="card-body">

                <div class="row g-3 text-center">


                    {{-- TITIK PARKIR --}}

                    <div class="col-6">

                        <div
                            class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:85px;height:85px;"
                        >

                            <i
                                class="bi bi-geo-alt"
                                style="font-size:36px;"
                            ></i>

                        </div>


                        <h2 class="fw-bold mb-1">

                            {{ $jenisParkir->titik_parkirs_count }}

                        </h2>


                        <p class="text-muted mb-0">

                            Titik Parkir

                        </p>

                    </div>



                    {{-- TARIF --}}

                    <div class="col-6">

                        <div
                            class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:85px;height:85px;"
                        >

                            <i
                                class="bi bi-cash-stack"
                                style="font-size:36px;"
                            ></i>

                        </div>


                        <h2 class="fw-bold mb-1">

                            {{ $jenisParkir->tarifs_count }}

                        </h2>


                        <p class="text-muted mb-0">

                            Tarif

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ======================================================
        DESKRIPSI
    ======================================================= --}}

    <div class="col-12">

        <div class="card">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-chat-left-text me-2 text-success"></i>

                    Deskripsi

                </h6>

            </div>



            <div class="card-body">

                @if($jenisParkir->deskripsi)

                    <div class="lh-lg">

                        {!! nl2br(e($jenisParkir->deskripsi)) !!}

                    </div>

                @else

                    <div class="text-center py-4 text-muted">

                        <i
                            class="bi bi-file-earmark-text"
                            style="font-size:38px;"
                        ></i>


                        <div class="mt-2">

                            Belum ada deskripsi untuk jenis parkir ini.

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>



    {{-- ======================================================
        DAFTAR TITIK PARKIR
    ======================================================= --}}

    <div class="col-12">

        <div class="card">

            <div
                class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center"
            >

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-geo-alt me-2 text-success"></i>

                    Daftar Titik Parkir

                </h6>


                <span class="badge text-bg-light border">

                    {{ $jenisParkir->titik_parkirs_count }}

                    Titik

                </span>

            </div>



            @if($jenisParkir->titikParkirs->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">
                                    No
                                </th>

                                <th>
                                    Kode Titik
                                </th>

                                <th>
                                    Nama Titik
                                </th>

                                <th>
                                    Wilayah
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>



                        <tbody>

                            @foreach($jenisParkir->titikParkirs as $titikParkir)

                                <tr>

                                    <td class="ps-4 text-muted">

                                        {{ $loop->iteration }}

                                    </td>


                                    <td>

                                        <span class="font-monospace fw-semibold">

                                            {{ $titikParkir->kode_titik }}

                                        </span>

                                    </td>


                                    <td>

                                        <div class="fw-semibold">

                                            {{ $titikParkir->nama }}

                                        </div>


                                        <small class="text-muted">

                                            {{ \Illuminate\Support\Str::limit(
                                                $titikParkir->alamat,
                                                60
                                            ) }}

                                        </small>

                                    </td>


                                    <td>

                                        <div class="small fw-semibold">

                                            {{ $titikParkir->kecamatan?->nama ?? '-' }}

                                        </div>


                                        <small class="text-muted">

                                            {{ $titikParkir->kelurahan?->nama ?? '-' }}

                                        </small>

                                    </td>


                                    <td>

                                        @if($titikParkir->status === 'aktif')

                                            <span class="badge bg-success">
                                                Aktif
                                            </span>

                                        @elseif($titikParkir->status === 'nonaktif')

                                            <span class="badge bg-secondary">
                                                Nonaktif
                                            </span>

                                        @elseif($titikParkir->status === 'sementara')

                                            <span class="badge bg-warning text-dark">
                                                Sementara
                                            </span>

                                        @elseif($titikParkir->status === 'bermasalah')

                                            <span class="badge bg-danger">
                                                Bermasalah
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <div
                        class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:70px;height:70px;"
                    >

                        <i
                            class="bi bi-geo-alt text-muted"
                            style="font-size:30px;"
                        ></i>

                    </div>


                    <h6 class="fw-semibold">

                        Belum Ada Titik Parkir

                    </h6>


                    <p class="text-muted mb-0">

                        Belum ada titik parkir yang menggunakan
                        jenis parkir ini.

                    </p>

                </div>

            @endif

        </div>

    </div>



    {{-- ======================================================
        DAFTAR TARIF
    ======================================================= --}}

    <div class="col-12">

        <div class="card">

            <div
                class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center"
            >

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-cash-stack me-2 text-success"></i>

                    Daftar Tarif

                </h6>


                <span class="badge text-bg-light border">

                    {{ $jenisParkir->tarifs_count }}

                    Tarif

                </span>

            </div>



            @if($jenisParkir->tarifs->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">
                                    No
                                </th>

                                <th>
                                    Jenis Kendaraan
                                </th>

                                <th>
                                    Nominal
                                </th>

                                <th>
                                    Berlaku Mulai
                                </th>

                                <th>
                                    Berlaku Sampai
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>



                        <tbody>

                            @foreach($jenisParkir->tarifs as $tarif)

                                <tr>

                                    <td class="ps-4 text-muted">

                                        {{ $loop->iteration }}

                                    </td>


                                    <td>

                                        <span class="fw-semibold">

                                            {{ $tarif->jenis_kendaraan }}

                                        </span>

                                    </td>


                                    <td>

                                        <span class="fw-semibold">

                                            Rp
                                            {{ number_format(
                                                $tarif->nominal,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </span>

                                    </td>


                                    <td>

                                        {{ $tarif->berlaku_mulai?->format('d-m-Y') ?? '-' }}

                                    </td>


                                    <td>

                                        {{ $tarif->berlaku_sampai?->format('d-m-Y') ?? '-' }}

                                    </td>


                                    <td>

                                        @if($tarif->status)

                                            <span class="badge bg-success">

                                                Aktif

                                            </span>

                                        @else

                                            <span class="badge bg-secondary">

                                                Nonaktif

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <div
                        class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:70px;height:70px;"
                    >

                        <i
                            class="bi bi-cash-stack text-muted"
                            style="font-size:30px;"
                        ></i>

                    </div>


                    <h6 class="fw-semibold">

                        Belum Ada Tarif

                    </h6>


                    <p class="text-muted mb-0">

                        Belum ada tarif yang terdaftar
                        untuk jenis parkir ini.

                    </p>

                </div>

            @endif

        </div>

    </div>


</div>

@endsection