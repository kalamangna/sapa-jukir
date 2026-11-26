@extends('layouts.admin')

@section('title', 'Laporan Titik/Objek Pendapatan')

@section('page-title', 'Laporan Titik/Objek Pendapatan')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Laporan Data Titik/Objek Pendapatan
        </h4>

        <p class="text-muted mb-0">
            Rekapitulasi data titik/objek pendapatan Kabupaten Sinjai.
        </p>

    </div>


    <a
        href="{{ route('admin.laporan.titik-parkir.cetak', request()->query()) }}"
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
            action="{{ route('admin.laporan.titik-parkir') }}"
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
                        placeholder="Kode, nama, atau alamat objek pendapatan"
                    >

                </div>


                {{-- JENIS PARKIR --}}

                <div class="col-md-4">

                    <label
                        for="jenis_parkir_id"
                        class="form-label fw-semibold"
                    >

                        Jenis Retribusi

                    </label>

                    <select
                        name="jenis_parkir_id"
                        id="jenis_parkir_id"
                        class="form-select"
                    >

                        <option value="">
                            Semua Jenis Retribusi
                        </option>

                        @foreach($jenisParkirs as $jenisParkir)

                            <option
                                value="{{ $jenisParkir->id }}"
                                @selected($jenisParkirId == $jenisParkir->id)
                            >

                                {{ $jenisParkir->kode }}
                                -
                                {{ $jenisParkir->nama }}

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


            <div class="d-flex justify-content-end gap-2 mt-4">

                <a
                    href="{{ route('admin.laporan.titik-parkir') }}"
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

    <div class="col-12 col-md-3">

        <div class="card h-100">

            <div class="card-body">

                <small class="text-muted">
                    Total Titik
                </small>

                <h3 class="fw-bold mb-0 mt-2">
                    {{ $titikParkirs->total() }}
                </h3>

            </div>

        </div>

    </div>


    <div class="col-12 col-md-3">

        <div class="card h-100">

            <div class="card-body">

                <small class="text-muted">
                    Kapasitas Motor
                </small>

                <h3 class="fw-bold mb-0 mt-2">

                    {{ number_format($titikParkirs->sum('kapasitas_motor')) }}

                </h3>

            </div>

        </div>

    </div>


    <div class="col-12 col-md-3">

        <div class="card h-100">

            <div class="card-body">

                <small class="text-muted">
                    Kapasitas Mobil
                </small>

                <h3 class="fw-bold mb-0 mt-2">

                    {{ number_format($titikParkirs->sum('kapasitas_mobil')) }}

                </h3>

            </div>

        </div>

    </div>


    <div class="col-12 col-md-3">

        <div class="card h-100">

            <div class="card-body">

                <small class="text-muted">
                    Target Bulanan
                </small>

                <h5 class="fw-bold mb-0 mt-2">

                    Rp
                    {{ number_format($titikParkirs->sum(fn ($titik) => $titik->targetPendapatans->sum('target')), 0, ',', '.') }}

                </h5>

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

                <i class="bi bi-geo-alt me-2 text-success"></i>

                Daftar Titik/Objek Pendapatan

            </h6>


            <span class="badge text-bg-light border">

                {{ $titikParkirs->total() }}

                Data

            </span>

        </div>

    </div>


    <div class="card-body p-0">

        @if($titikParkirs->count())

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
                                Kode
                            </th>

                            <th>
                                Titik Parkir
                            </th>

                            <th>
                                Jenis Retribusi
                            </th>

                            <th>
                                Alamat
                            </th>

                            <th class="text-center">
                                Motor
                            </th>

                            <th class="text-center">
                                Mobil
                            </th>

                            <th class="text-end">
                                Target Harian
                            </th>

                            <th class="text-end">
                                Target Bulanan
                            </th>

                            <th class="text-center">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($titikParkirs as $titik)

                            <tr>

                                <td class="text-center">

                                    {{ $titikParkirs->firstItem() + $loop->index }}

                                </td>


                                <td>

                                    <span class="font-monospace">

                                        {{ $titik->kode_titik }}

                                    </span>

                                </td>


                                <td>

                                    <div class="fw-semibold">

                                        {{ $titik->nama }}

                                    </div>

                                </td>


                                <td>

                                    @if($titik->jenisParkir)

                                        {{ $titik->jenisParkir->kode }}
                                        -
                                        {{ $titik->jenisParkir->nama }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    {{ $titik->alamat ?: '-' }}

                                </td>


                                <td class="text-center">

                                    {{ number_format($titik->kapasitas_motor) }}

                                </td>


                                <td class="text-center">

                                    {{ number_format($titik->kapasitas_mobil) }}

                                </td>


                                <td class="text-end">

                                    Rp
                                    {{ number_format($titik->targetPendapatans->sum('target') / 30, 0, ',', '.') }}

                                </td>


                                <td class="text-end">

                                    Rp
                                    {{ number_format($titik->targetPendapatans->sum('target'), 0, ',', '.') }}

                                </td>


                                <td class="text-center">

                                    @if($titik->status === 'aktif')

                                        <span class="badge bg-success">
                                            Aktif
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ ucfirst($titik->status) }}
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
                    class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:80px;height:80px;"
                >

                    <i
                        class="bi bi-geo-alt"
                        style="font-size:36px;"
                    ></i>

                </div>


                <h5 class="fw-bold mb-2">
                    Tidak Ada Data
                </h5>


                <p class="text-muted mb-0">
                    Tidak ditemukan data titik/objek pendapatan sesuai filter.
                </p>

            </div>

        @endif

    </div>


    @if($titikParkirs->hasPages())

        <div class="card-footer bg-white border-top">

            {{ $titikParkirs->links() }}

        </div>

    @endif

</div>

@endsection