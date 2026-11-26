@extends('layouts.admin')

@section('title', 'Laporan Penempatan Petugas')

@section('page-title', 'Laporan Penempatan Petugas')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Laporan Penempatan Petugas
        </h4>

        <p class="text-muted mb-0">
            Rekapitulasi penempatan Petugas pada setiap titik/objek pendapatan.
        </p>

    </div>


    {{-- CETAK --}}

    <a
        href="{{ route('admin.laporan.penempatan-jukir.cetak', request()->query()) }}"
        target="_blank"
        class="btn btn-success"
    >

        <i class="bi bi-printer me-1"></i>

        Cetak Laporan

    </a>

</div>


{{-- ==========================================================
    FILTER
========================================================== --}}

<div class="card mb-4">

    <div class="card-header bg-white border-bottom py-3">

        <h6 class="mb-0 fw-bold">

            <i class="bi bi-funnel me-2 text-success"></i>

            Filter Laporan

        </h6>

    </div>


    <div class="card-body">

        <form
            action="{{ route('admin.laporan.penempatan-jukir') }}"
            method="GET"
        >

            <div class="row g-3">

                {{-- PENCARIAN --}}

                <div class="col-md-5">

                    <label
                        for="search"
                        class="form-label fw-semibold"
                    >
                        Pencarian
                    </label>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Kode/nama Petugas, kode/nama titik/objek pendapatan"
                    >

                </div>


                {{-- TITIK / OBJEK PENDAPATAN --}}

                <div class="col-md-4">

                    <label
                        for="titik_parkir_id"
                        class="form-label fw-semibold"
                    >
                        Titik/Objek Pendapatan
                    </label>

                    <select
                        name="titik_parkir_id"
                        id="titik_parkir_id"
                        class="form-select"
                    >

                        <option value="">
                            Semua Titik/Objek Pendapatan
                        </option>

                        @foreach($titikParkirs as $titikParkir)

                            <option
                                value="{{ $titikParkir->id }}"
                                @selected($titikParkirId == $titikParkir->id)
                            >

                                {{ $titikParkir->kode_titik }}
                                -
                                {{ $titikParkir->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}

                <div class="col-md-3">

                    <label
                        for="status"
                        class="form-label fw-semibold"
                    >
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="form-select"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        @foreach($statuses as $itemStatus)

                            <option
                                value="{{ $itemStatus }}"
                                @selected($status === $itemStatus)
                            >

                                {{ ucfirst($itemStatus) }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- BUTTON --}}

            <div class="d-flex justify-content-end gap-2 mt-4">

                <a
                    href="{{ route('admin.laporan.penempatan-jukir') }}"
                    class="btn btn-outline-secondary"
                >

                    <i class="bi bi-arrow-counterclockwise me-1"></i>

                    Reset

                </a>


                <button
                    type="submit"
                    class="btn btn-success"
                >

                    <i class="bi bi-search me-1"></i>

                    Tampilkan

                </button>

            </div>

        </form>

    </div>

</div>


{{-- ==========================================================
    RINGKASAN
========================================================== --}}

<div class="row g-3 mb-4">

    {{-- TOTAL --}}

    <div class="col-12 col-md-3">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <small class="text-muted">
                            Total Penempatan
                        </small>

                        <h3 class="fw-bold mb-0 mt-2">
                            {{ number_format($totalPenempatan) }}
                        </h3>

                    </div>

                    <div class="text-success fs-3">
                        <i class="bi bi-person-workspace"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- AKTIF --}}

    <div class="col-12 col-md-3">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <small class="text-muted">
                            Penempatan Aktif
                        </small>

                        <h3 class="fw-bold mb-0 mt-2 text-success">
                            {{ number_format($totalPenempatanAktif) }}
                        </h3>

                    </div>

                    <div class="text-success fs-3">
                        <i class="bi bi-check-circle"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- SELESAI --}}

    <div class="col-12 col-md-3">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <small class="text-muted">
                            Selesai
                        </small>

                        <h3 class="fw-bold mb-0 mt-2">
                            {{ number_format($totalPenempatanSelesai) }}
                        </h3>

                    </div>

                    <div class="text-secondary fs-3">
                        <i class="bi bi-clock-history"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- DIBATALKAN --}}

    <div class="col-12 col-md-3">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <small class="text-muted">
                            Dibatalkan
                        </small>

                        <h3 class="fw-bold mb-0 mt-2">
                            {{ number_format($totalPenempatanDibatalkan) }}
                        </h3>

                    </div>

                    <div class="text-danger fs-3">
                        <i class="bi bi-x-circle"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ==========================================================
    DATA
========================================================== --}}

<div class="card">

    <div class="card-header bg-white border-bottom py-3">

        <div class="d-flex justify-content-between align-items-center">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-person-workspace me-2 text-success"></i>

                Daftar Penempatan Petugas

            </h6>


            <span class="badge text-bg-light border">

                {{ $penempatans->total() }}

                Data

            </span>

        </div>

    </div>


    <div class="card-body p-0">

        @if($penempatans->count())

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th
                                class="text-center"
                                style="width:55px;"
                            >
                                #
                            </th>

                            <th>
                                Petugas
                            </th>

                            <th>
                                Titik Parkir
                            </th>

                            <th>
                                Tanggal Mulai
                            </th>

                            <th>
                                Tanggal Selesai
                            </th>

                            <th>
                                Surat Penugasan
                            </th>

                            <th class="text-center">
                                Status
                            </th>

                            <th>
                                Keterangan
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($penempatans as $penempatan)

                            <tr>

                                <td class="text-center">

                                    {{ $penempatans->firstItem() + $loop->index }}

                                </td>


                                {{-- Petugas --}}

                                <td>

                                    @if($penempatan->jukir)

                                        <div class="fw-semibold">

                                            {{ $penempatan->jukir->nama }}

                                        </div>

                                        @if($penempatan->jukir->kode_jukir)

                                            <small class="text-muted font-monospace">

                                                {{ $penempatan->jukir->kode_jukir }}

                                            </small>

                                        @endif

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- TITIK PARKIR --}}

                                <td>

                                    @if($penempatan->titikParkir)

                                        <div class="fw-semibold">

                                            {{ $penempatan->titikParkir->nama }}

                                        </div>

                                        @if($penempatan->titikParkir->kode_titik)

                                            <small class="text-muted font-monospace">

                                                {{ $penempatan->titikParkir->kode_titik }}

                                            </small>

                                        @endif

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- TANGGAL MULAI --}}

                                <td>

                                    @if($penempatan->tanggal_mulai)

                                        {{ $penempatan->tanggal_mulai->format('d-m-Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- TANGGAL SELESAI --}}

                                <td>

                                    @if($penempatan->tanggal_selesai)

                                        {{ $penempatan->tanggal_selesai->format('d-m-Y') }}

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- SURAT PENUGASAN --}}

                                <td>

                                    {{ $penempatan->surat_penugasan ?: '-' }}

                                </td>


                                {{-- STATUS --}}

                                <td class="text-center">

                                    @if($penempatan->status === 'aktif')

                                        <span class="badge bg-success">
                                            Aktif
                                        </span>

                                    @elseif($penempatan->status === 'selesai')

                                        <span class="badge bg-secondary">
                                            Selesai
                                        </span>

                                    @elseif($penempatan->status === 'dibatalkan')

                                        <span class="badge bg-danger">
                                            Dibatalkan
                                        </span>

                                    @else

                                        <span class="badge bg-light text-dark border">

                                            {{ ucfirst($penempatan->status) }}

                                        </span>

                                    @endif

                                </td>


                                {{-- KETERANGAN --}}

                                <td>

                                    {{ $penempatan->keterangan ?: '-' }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-5">

                <div
                    class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:80px;height:80px;"
                >

                    <i
                        class="bi bi-person-workspace"
                        style="font-size:36px;"
                    ></i>

                </div>


                <h5 class="fw-bold mb-2">
                    Belum Ada Data Penempatan
                </h5>


                <p class="text-muted mb-0">

                    Belum terdapat data penempatan Petugas
                    yang sesuai dengan filter.

                </p>

            </div>

        @endif

    </div>


    {{-- PAGINATION --}}

    @if($penempatans->hasPages())

        <div class="card-footer bg-white border-top">

            {{ $penempatans->links() }}

        </div>

    @endif

</div>

@endsection