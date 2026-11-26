@extends('layouts.admin')

@section('title', 'Detail Tarif')

@section('page-title', 'Detail Tarif')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>
        <h4 class="mb-1 fw-bold">
            Detail Tarif
        </h4>

        <p class="text-muted mb-0">
            Informasi lengkap tarif parkir.
        </p>
    </div>

    <div class="d-flex gap-2">

        <a
            href="{{ route('admin.tarif.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>

        <a
            href="{{ route('admin.tarif.edit', $tarif) }}"
            class="btn btn-warning"
        >
            <i class="bi bi-pencil-square me-1"></i>
            Edit Tarif
        </a>

    </div>

</div>


{{-- ==========================================================
    RINGKASAN TARIF
========================================================== --}}

<div class="card mb-4">

    <div class="card-body">

        <div class="row align-items-center g-4">

            <div class="col-md-auto">

                <div
                    class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center"
                    style="width:100px;height:100px;"
                >

                    <i
                        class="bi bi-cash-stack"
                        style="font-size:42px;"
                    ></i>

                </div>

            </div>


            <div class="col">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3">

                    <div>

                        <h3 class="fw-bold mb-2">
                            Rp {{ number_format($tarif->nominal, 0, ',', '.') }}
                        </h3>

                        <div class="mb-2">

                            @if($tarif->jenisParkir)

                                <span class="badge text-bg-light border">

                                    {{ $tarif->jenisParkir->nama }}

                                </span>

                            @else

                                <span class="badge text-bg-light border">
                                    Jenis Parkir Tidak Ditemukan
                                </span>

                            @endif

                        </div>

                        <div class="text-muted">

                            <i class="bi bi-car-front me-1"></i>

                            {{ ucfirst($tarif->jenis_kendaraan) }}

                        </div>

                    </div>


                    {{-- STATUS --}}

                    <div>

                        @if($tarif->status)

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


{{-- ==========================================================
    DETAIL
========================================================== --}}

<div class="row g-4">


    {{-- ======================================================
        INFORMASI TARIF
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-cash-stack me-2 text-success"></i>

                    Informasi Tarif

                </h6>

            </div>


            <div class="card-body">

                <dl class="row mb-0">


                    {{-- JENIS PARKIR --}}

                    <dt class="col-sm-5 text-muted">
                        Jenis Parkir
                    </dt>

                    <dd class="col-sm-7">

                        @if($tarif->jenisParkir)

                            <div class="fw-semibold">

                                {{ $tarif->jenisParkir->nama }}

                            </div>

                            @if($tarif->jenisParkir->kode)

                                <small class="text-muted font-monospace">

                                    {{ $tarif->jenisParkir->kode }}

                                </small>

                            @endif

                        @else

                            -

                        @endif

                    </dd>



                    {{-- JENIS KENDARAAN --}}

                    <dt class="col-sm-5 text-muted">
                        Jenis Kendaraan
                    </dt>

                    <dd class="col-sm-7">

                        <span class="fw-semibold">

                            {{ ucfirst($tarif->jenis_kendaraan) }}

                        </span>

                    </dd>



                    {{-- NOMINAL --}}

                    <dt class="col-sm-5 text-muted">
                        Nominal
                    </dt>

                    <dd class="col-sm-7">

                        <span class="fw-bold text-success">

                            Rp {{ number_format($tarif->nominal, 0, ',', '.') }}

                        </span>

                    </dd>



                    {{-- STATUS --}}

                    <dt class="col-sm-5 text-muted">
                        Status
                    </dt>

                    <dd class="col-sm-7">

                        @if($tarif->status)

                            <span class="badge bg-success">
                                Aktif
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                Nonaktif
                            </span>

                        @endif

                    </dd>

                </dl>

            </div>

        </div>

    </div>



    {{-- ======================================================
        MASA BERLAKU
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-calendar-range me-2 text-success"></i>

                    Masa Berlaku

                </h6>

            </div>


            <div class="card-body">

                <dl class="row mb-0">


                    <dt class="col-sm-5 text-muted">
                        Berlaku Mulai
                    </dt>

                    <dd class="col-sm-7">

                        @if($tarif->berlaku_mulai)

                            {{ $tarif->berlaku_mulai->format('d-m-Y') }}

                        @else

                            -

                        @endif

                    </dd>



                    <dt class="col-sm-5 text-muted">
                        Berlaku Sampai
                    </dt>

                    <dd class="col-sm-7">

                        @if($tarif->berlaku_sampai)

                            {{ $tarif->berlaku_sampai->format('d-m-Y') }}

                        @else

                            <span class="text-muted">
                                Tidak dibatasi
                            </span>

                        @endif

                    </dd>



                    <dt class="col-sm-5 text-muted">
                        Status Masa Berlaku
                    </dt>

                    <dd class="col-sm-7">

                        @if(!$tarif->berlaku_mulai && !$tarif->berlaku_sampai)

                            <span class="badge text-bg-light border">
                                Tidak ditentukan
                            </span>

                        @elseif(
                            $tarif->berlaku_sampai &&
                            $tarif->berlaku_sampai->isPast()
                        )

                            <span class="badge bg-danger">
                                Sudah Berakhir
                            </span>

                        @elseif(
                            $tarif->berlaku_mulai &&
                            $tarif->berlaku_mulai->isFuture()
                        )

                            <span class="badge bg-warning text-dark">
                                Belum Berlaku
                            </span>

                        @else

                            <span class="badge bg-success">
                                Sedang Berlaku
                            </span>

                        @endif

                    </dd>

                </dl>

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

                @if($tarif->keterangan)

                    <div class="lh-lg">

                        {!! nl2br(e($tarif->keterangan)) !!}

                    </div>

                @else

                    <div class="text-center py-4 text-muted">

                        <i
                            class="bi bi-file-earmark-text"
                            style="font-size:38px;"
                        ></i>

                        <div class="mt-2">

                            Belum ada keterangan untuk tarif ini.

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>



    {{-- ======================================================
        INFORMASI SISTEM
    ======================================================= --}}

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="row text-muted small">

                    <div class="col-md-6">

                        <i class="bi bi-calendar-plus me-1"></i>

                        Dibuat:

                        {{ $tarif->created_at?->format('d-m-Y H:i') ?? '-' }}

                    </div>


                    <div class="col-md-6 text-md-end">

                        <i class="bi bi-calendar-check me-1"></i>

                        Terakhir Diubah:

                        {{ $tarif->updated_at?->format('d-m-Y H:i') ?? '-' }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection