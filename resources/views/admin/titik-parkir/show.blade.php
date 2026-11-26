@extends('layouts.admin')

@section('title', 'Detail Titik/Objek Pendapatan')

@section('page-title', 'Detail Titik/Objek Pendapatan')

@section('content')

{{-- ==========================================================
    HEADER
========================================================== --}}

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Detail Titik/Objek Pendapatan
        </h4>

        <p class="text-muted mb-0">
            Informasi lengkap mengenai titik atau objek pendapatan.
        </p>

    </div>


    <div class="d-flex gap-2">

        <a
            href="{{ route('admin.titik-parkir.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Kembali

        </a>


        <a
            href="{{ route('admin.titik-parkir.edit', $titikParkir) }}"
            class="btn btn-warning"
        >

            <i class="bi bi-pencil-square me-1"></i>

            Edit Data

        </a>

    </div>

</div>



{{-- ==========================================================
    INFORMASI UTAMA
========================================================== --}}

<div class="card mb-4">

    <div class="card-body">

        <div class="row align-items-center g-4">


            {{-- FOTO / ICON --}}

            <div class="col-md-auto text-center">

                @if($titikParkir->foto)

                    <img
                        src="{{ asset('storage/' . $titikParkir->foto) }}"
                        alt="{{ $titikParkir->nama }}"
                        class="rounded"
                        style="
                            width:120px;
                            height:120px;
                            object-fit:cover;
                        "
                    >

                @else

                    <div
                        class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center"
                        style="width:100px;height:100px;"
                    >

                        <i
                            class="bi bi-geo-alt"
                            style="font-size:42px;"
                        ></i>

                    </div>

                @endif

            </div>



            {{-- INFORMASI TITIK --}}

            <div class="col">

                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3"
                >

                    <div>

                        <div class="mb-2">

                            <span
                                class="badge text-bg-light border font-monospace"
                            >

                                {{ $titikParkir->kode_titik }}

                            </span>

                        </div>


                        <h3 class="fw-bold mb-2">

                            {{ $titikParkir->nama }}

                        </h3>


                        <div class="text-muted">

                            <i class="bi bi-geo-alt me-1"></i>

                            {{ $titikParkir->alamat }}

                        </div>

                    </div>



                    {{-- STATUS --}}

                    <div>

                        @if($titikParkir->status === 'aktif')

                            <span class="badge bg-success fs-6">

                                <i class="bi bi-check-circle me-1"></i>

                                Aktif

                            </span>

                        @elseif($titikParkir->status === 'nonaktif')

                            <span class="badge bg-secondary fs-6">

                                <i class="bi bi-x-circle me-1"></i>

                                Nonaktif

                            </span>

                        @elseif($titikParkir->status === 'sementara')

                            <span class="badge bg-warning text-dark fs-6">

                                <i class="bi bi-clock me-1"></i>

                                Sementara

                            </span>

                        @elseif($titikParkir->status === 'bermasalah')

                            <span class="badge bg-danger fs-6">

                                <i class="bi bi-exclamation-triangle me-1"></i>

                                Bermasalah

                            </span>

                        @else

                            <span class="badge bg-secondary fs-6">

                                -

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ==========================================================
    DAFTAR PETUGAS
========================================================== --}}

<div class="card mb-4">

    <div class="card-header bg-white border-bottom py-3">

        <h6 class="mb-0 fw-bold">

            <i class="bi bi-people me-2 text-success"></i>

            Daftar Petugas

        </h6>

    </div>

    <div class="card-body p-0">

        @php
            $penugasanAktif = $titikParkir->penempatanJukirs
                ->sortByDesc(fn ($penempatan) => $penempatan->role === 'koordinator')
                ->values();
        @endphp

        @if($penugasanAktif->isNotEmpty())

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th class="text-center" style="width:60px;">No.</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Tempat Tugas</th>
                            <th>Target Per Hari</th>
                            <th>Waktu Kerja</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($penugasanAktif as $penempatan)

                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $penempatan->jukir?->nama ?? '-' }}</div>
                                    <small class="text-muted font-monospace">{{ $penempatan->jukir?->kode_jukir ?? '-' }}</small>
                                </td>
                                <td>
                                    @if($penempatan->role === 'koordinator')
                                        <span class="badge bg-primary">Koordinator</span>
                                    @elseif($penempatan->role === 'anggota')
                                        <span class="badge bg-secondary">Anggota</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $titikParkir->nama }}</div>
                                    <small class="text-muted font-monospace">{{ $titikParkir->kode_titik }}</small>
                                </td>
                                <td>
                                    @if($penempatan->target_per_hari !== null)
                                        Rp {{ number_format((float) $penempatan->target_per_hari, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{ $penempatan->waktu_kerja ?? '-' }}
                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="p-4 text-center text-muted">
                <i class="bi bi-people fs-3 d-block mb-2"></i>
                Belum ada petugas yang ditugaskan pada titik/objek pendapatan ini.
            </div>

        @endif

    </div>

</div>


{{-- ==========================================================
    INFORMASI DETAIL
========================================================== --}}

<div class="row g-4">


    {{-- ======================================================
        INFORMASI LOKASI
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-geo-alt me-2 text-success"></i>

                    Informasi Lokasi

                </h6>

            </div>


            <div class="card-body">

                <dl class="row mb-0">


                    <dt class="col-sm-5 text-muted">
                        Kode Titik/Objek
                    </dt>

                    <dd class="col-sm-7">

                        <span class="font-monospace fw-semibold">

                            {{ $titikParkir->kode_titik }}

                        </span>

                    </dd>



                    <dt class="col-sm-5 text-muted">
                        Nama Titik/Objek
                    </dt>

                    <dd class="col-sm-7">

                        {{ $titikParkir->nama }}

                    </dd>



                    <dt class="col-sm-5 text-muted">
                        Alamat
                    </dt>

                    <dd class="col-sm-7">

                        {{ $titikParkir->alamat }}

                    </dd>



                    <dt class="col-sm-5 text-muted">
                        Kecamatan
                    </dt>

                    <dd class="col-sm-7">

                        {{ $titikParkir->kecamatan?->nama ?? '-' }}

                    </dd>



                    <dt class="col-sm-5 text-muted">
                        Kelurahan
                    </dt>

                    <dd class="col-sm-7">

                        {{ $titikParkir->kelurahan?->nama ?? '-' }}

                    </dd>



                    <dt class="col-sm-5 text-muted">
                        Sumber Pendapatan
                    </dt>

                    <dd class="col-sm-7">

                        @if($titikParkir->sumberPemasukan)

                            <div class="fw-semibold">

                                {{ $titikParkir->sumberPemasukan->nama }}

                            </div>

                            <small class="text-muted font-monospace">

                                {{ $titikParkir->sumberPemasukan->kode }}

                            </small>

                        @else

                            -

                        @endif

                    </dd>



                    <dt class="col-sm-5 text-muted">
                        Status
                    </dt>

                    <dd class="col-sm-7">

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

                        @else

                            <span class="badge bg-secondary">
                                -
                            </span>

                        @endif

                    </dd>

                </dl>

            </div>

        </div>

    </div>



    {{-- ======================================================
        KOORDINAT
    ======================================================= --}}

    <div class="col-lg-6">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-map me-2 text-success"></i>

                    Koordinat Lokasi

                </h6>

            </div>


            <div class="card-body">

                <dl class="row mb-0">


                    <dt class="col-sm-5 text-muted">
                        Latitude
                    </dt>

                    <dd class="col-sm-7 font-monospace">

                        {{ $titikParkir->latitude ?? '-' }}

                    </dd>



                    <dt class="col-sm-5 text-muted">
                        Longitude
                    </dt>

                    <dd class="col-sm-7 font-monospace">

                        {{ $titikParkir->longitude ?? '-' }}

                    </dd>

                </dl>


                @if(
                    $titikParkir->latitude !== null &&
                    $titikParkir->longitude !== null
                )

                    <a
                        href="https://www.google.com/maps?q={{ $titikParkir->latitude }},{{ $titikParkir->longitude }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-outline-success w-100"
                    >

                        <i class="bi bi-map me-1"></i>

                        Buka di Google Maps

                    </a>

                @else

                    <div class="alert alert-light border mb-0">

                        <i class="bi bi-info-circle me-2"></i>

                        Koordinat lokasi belum tersedia.

                    </div>

                @endif

            </div>

        </div>

    </div>



    {{-- ======================================================
        KAPASITAS TITIK/OBJEK
    ======================================================= --}}

    @php
        $isBusinessAsset = in_array($titikParkir->sumberPemasukan?->kode, ['R-TKU', 'R-JASA-USAHA', 'R-SPATKT'], true);
    @endphp

    <div class="col-lg-6">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi {{ $isBusinessAsset ? 'bi-building' : 'bi-car-front' }} me-2 text-success"></i>

                    {{ $isBusinessAsset ? 'Kapasitas Unit / Luas' : 'Kapasitas Titik/Objek' }}

                </h6>

            </div>


            <div class="card-body">

                @if($isBusinessAsset)
                    <div class="row g-3 text-center">

                        <div class="col-6">

                            <div
                                class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:85px;height:85px;"
                            >

                                <i class="bi bi-building" style="font-size:36px;"></i>

                            </div>

                            <h2 class="fw-bold mb-1">
                                {{ $titikParkir->jumlah_unit ?? 0 }}
                            </h2>

                            <p class="text-muted mb-0">
                                Unit
                            </p>

                        </div>

                        <div class="col-6">

                            <div
                                class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:85px;height:85px;"
                            >

                                <i class="bi bi-rulers" style="font-size:36px;"></i>

                            </div>

                            <h2 class="fw-bold mb-1">
                                {{ number_format((float) ($titikParkir->luas_m2 ?? 0), 0, ',', '.') }}
                            </h2>

                            <p class="text-muted mb-0">
                                m²
                            </p>

                        </div>

                    </div>
                @else
                    <div class="row g-3 text-center">

                        <div class="col-6">

                            <div
                                class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:85px;height:85px;"
                            >

                                <i class="bi bi-bicycle" style="font-size:36px;"></i>

                            </div>

                            <h2 class="fw-bold mb-1">
                                {{ $titikParkir->kapasitas_motor ?? 0 }}
                            </h2>

                            <p class="text-muted mb-0">
                                Motor
                            </p>

                        </div>

                        <div class="col-6">

                            <div
                                class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:85px;height:85px;"
                            >

                                <i class="bi bi-car-front" style="font-size:36px;"></i>

                            </div>

                            <h2 class="fw-bold mb-1">
                                {{ $titikParkir->kapasitas_mobil ?? 0 }}
                            </h2>

                            <p class="text-muted mb-0">
                                Mobil
                            </p>

                        </div>

                    </div>
                @endif

            </div>

        </div>

    </div>



    @php
        $isBusinessAsset = in_array($titikParkir->sumberPemasukan?->kode, ['R-TKU', 'R-JASA-USAHA', 'R-SPATKT'], true);
    @endphp

    @if(! $isBusinessAsset)
        {{-- ======================================================
            POTENSI PARKIR
        ======================================================= --}}

        <div class="col-lg-6">

            <div class="card h-100">

                <div class="card-header bg-white border-bottom py-3">

                    <h6 class="mb-0 fw-bold">

                        <i class="bi bi-cash-stack me-2 text-success"></i>

                        Potensi Titik/Objek

                    </h6>

                </div>


                <div class="card-body">

                    <dl class="row mb-0">


                        <dt class="col-sm-5 text-muted">
                            Potensi Harian
                        </dt>

                        <dd class="col-sm-7 fw-semibold">

                            Rp
                            {{ number_format(
                                $titikParkir->potensi_harian ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}

                        </dd>



                        <dt class="col-sm-5 text-muted">
                            Potensi Bulanan
                        </dt>

                        <dd class="col-sm-7 fw-semibold">

                            Rp
                            {{ number_format(
                                $titikParkir->potensi_bulanan ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}

                        </dd>

                    </dl>

                </div>

            </div>

        </div>
    @endif



    {{-- ======================================================
        FOTO TITIK / OBJEK PENDAPATAN

    @if($titikParkir->foto)

        <div class="col-12">

            <div class="card">

                <div class="card-header bg-white border-bottom py-3">

                    <h6 class="mb-0 fw-bold">

                        <i class="bi bi-image me-2 text-success"></i>

                        Foto Titik / Objek Pendapatan

                    </h6>

                </div>


                <div class="card-body text-center">

                    <img
                        src="{{ asset('storage/' . $titikParkir->foto) }}"
                        alt="{{ $titikParkir->nama }}"
                        class="img-fluid rounded shadow-sm"
                        style="max-height:450px;"
                    >

                </div>

            </div>

        </div>

    @endif



    {{-- ======================================================
        KETERANGAN
    ======================================================= --}}

    <div class="{{ $isBusinessAsset ? 'col-lg-6' : 'col-12' }}">

        <div class="card h-100">

            <div class="card-header bg-white border-bottom py-3">

                <h6 class="mb-0 fw-bold">

                    <i class="bi bi-chat-left-text me-2 text-success"></i>

                    Keterangan

                </h6>

            </div>


            <div class="card-body">

                @if($titikParkir->keterangan)

                    <div class="lh-lg">

                        {!! nl2br(e($titikParkir->keterangan)) !!}

                    </div>

                @else

                    <div class="text-center py-4 text-muted">

                        <i
                            class="bi bi-file-earmark-text"
                            style="font-size:38px;"
                        ></i>

                        <div class="mt-2">

                            Belum ada keterangan untuk titik atau objek pendapatan ini.

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

                        {{ $titikParkir->created_at?->format('d-m-Y H:i') ?? '-' }}

                    </div>


                    <div class="col-md-6 text-md-end">

                        <i class="bi bi-calendar-check me-1"></i>

                        Terakhir Diubah:

                        {{ $titikParkir->updated_at?->format('d-m-Y H:i') ?? '-' }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection