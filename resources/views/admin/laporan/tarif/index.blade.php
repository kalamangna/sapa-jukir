@extends('layouts.admin')

@section('title', 'Laporan Tarif')

@section('page-title', 'Laporan Tarif')

@section('content')

<div class="container-fluid px-0">

    {{-- =====================================================
         HEADER
    ====================================================== --}}
    <div class="d-flex flex-column flex-md-row
                justify-content-between align-items-md-center
                gap-3 mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Laporan Tarif
            </h4>

            <p class="text-muted mb-0 small">
                Daftar tarif parkir berdasarkan jenis parkir dan jenis kendaraan.
            </p>
        </div>

        <a href="{{ route('admin.laporan.tarif.cetak', request()->query()) }}"
           target="_blank"
           class="btn btn-danger">

            <i class="bi bi-printer me-2"></i>

            Cetak Laporan

        </a>

    </div>


    {{-- =====================================================
         RINGKASAN
    ====================================================== --}}
    <div class="row g-3 mb-4">

        {{-- TOTAL TARIF --}}
        <div class="col-12 col-md-4">

            <div class="card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small fw-semibold">
                                Total Tarif
                            </div>

                            <div class="fs-3 fw-bold text-dark mt-1">

                                {{ number_format($totalTarif ?? 0, 0, ',', '.') }}

                            </div>

                            <div class="text-muted small mt-1">
                                Seluruh data tarif
                            </div>

                        </div>

                        <div class="rounded-3 bg-primary-subtle
                                    text-primary d-flex align-items-center
                                    justify-content-center"
                             style="width:48px;height:48px;">

                            <i class="bi bi-cash-stack fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TARIF AKTIF --}}
        <div class="col-12 col-md-4">

            <div class="card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small fw-semibold">
                                Tarif Aktif
                            </div>

                            <div class="fs-3 fw-bold text-success mt-1">

                                {{ number_format($tarifAktif ?? 0, 0, ',', '.') }}

                            </div>

                            <div class="text-muted small mt-1">
                                Tarif yang sedang berlaku
                            </div>

                        </div>

                        <div class="rounded-3 bg-success-subtle
                                    text-success d-flex align-items-center
                                    justify-content-center"
                             style="width:48px;height:48px;">

                            <i class="bi bi-check-circle fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TARIF TIDAK AKTIF --}}
        <div class="col-12 col-md-4">

            <div class="card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small fw-semibold">
                                Tidak Aktif
                            </div>

                            <div class="fs-3 fw-bold text-danger mt-1">

                                {{ number_format($tarifTidakAktif ?? 0, 0, ',', '.') }}

                            </div>

                            <div class="text-muted small mt-1">
                                Tarif yang tidak berlaku
                            </div>

                        </div>

                        <div class="rounded-3 bg-danger-subtle
                                    text-danger d-flex align-items-center
                                    justify-content-center"
                             style="width:48px;height:48px;">

                            <i class="bi bi-x-circle fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTER
    ====================================================== --}}
    <div class="card mb-4">

        <div class="card-header bg-white py-3">

            <div class="d-flex align-items-center">

                <i class="bi bi-funnel text-muted me-2"></i>

                <span class="fw-semibold">
                    Filter Laporan
                </span>

            </div>

        </div>


        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.laporan.tarif') }}">

                <div class="row g-3">

                    {{-- PENCARIAN --}}
                    <div class="col-12 col-lg-6">

                        <label for="search"
                               class="form-label small fw-semibold">

                            Pencarian

                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">

                                <i class="bi bi-search text-muted"></i>

                            </span>

                            <input type="text"
                                   id="search"
                                   name="search"
                                   value="{{ $search ?? '' }}"
                                   class="form-control"
                                   placeholder="Cari jenis kendaraan / keterangan...">

                        </div>

                    </div>


                    {{-- JENIS PARKIR --}}
                    <div class="col-12 col-md-6 col-lg-3">

                        <label for="jenis_parkir_id"
                               class="form-label small fw-semibold">

                            Jenis Parkir

                        </label>

                        <select id="jenis_parkir_id"
                                name="jenis_parkir_id"
                                class="form-select">

                            <option value="">
                                Semua Jenis Parkir
                            </option>

                            @foreach($jenisParkirs as $jenisParkir)

                                <option value="{{ $jenisParkir->id }}"
                                    {{ (string) ($jenisParkirId ?? '') === (string) $jenisParkir->id ? 'selected' : '' }}>

                                    {{ $jenisParkir->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- STATUS --}}
                    <div class="col-12 col-md-6 col-lg-3">

                        <label for="status"
                               class="form-label small fw-semibold">

                            Status

                        </label>

                        <select id="status"
                                name="status"
                                class="form-select">

                            <option value="">
                                Semua Status
                            </option>

                            <option value="1"
                                {{ (string) ($status ?? '') === '1' ? 'selected' : '' }}>

                                Aktif

                            </option>

                            <option value="0"
                                {{ (string) ($status ?? '') === '0' ? 'selected' : '' }}>

                                Tidak Aktif

                            </option>

                        </select>

                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="d-flex flex-wrap gap-2 mt-4">

                    <button type="submit"
                            class="btn btn-success">

                        <i class="bi bi-search me-1"></i>

                        Filter

                    </button>


                    <a href="{{ route('admin.laporan.tarif') }}"
                       class="btn btn-outline-secondary">

                        <i class="bi bi-arrow-counterclockwise me-1"></i>

                        Reset

                    </a>


                    <a href="{{ route('admin.laporan.tarif.cetak', request()->query()) }}"
                       target="_blank"
                       class="btn btn-secondary">

                        <i class="bi bi-printer me-1"></i>

                        Cetak

                    </a>

                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         TABEL
    ====================================================== --}}
    <div class="card">

        {{-- HEADER --}}
        <div class="card-header bg-white py-3">

            <div class="d-flex flex-column flex-md-row
                        justify-content-between
                        align-items-md-center gap-2">

                <div>

                    <div class="fw-semibold">
                        Data Tarif
                    </div>

                    <div class="text-muted small mt-1">
                        Menampilkan daftar tarif parkir.
                    </div>

                </div>

                <div class="text-muted small">

                    Total:

                    <strong class="text-dark">
                        {{ $tarifs->total() }}
                    </strong>

                    data

                </div>

            </div>

        </div>


        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="text-center small"
                            style="width:60px;">

                            No

                        </th>

                        <th class="small">
                            Jenis Parkir
                        </th>

                        <th class="small">
                            Jenis Kendaraan
                        </th>

                        <th class="small text-end">
                            Nominal
                        </th>

                        <th class="small">
                            Berlaku Mulai
                        </th>

                        <th class="small">
                            Berlaku Sampai
                        </th>

                        <th class="small text-center">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($tarifs as $tarif)

                        <tr>

                            {{-- NO --}}
                            <td class="text-center text-muted small">

                                {{ $tarifs->firstItem() + $loop->index }}

                            </td>


                            {{-- JENIS PARKIR --}}
                            <td>

                                <div class="fw-semibold small">

                                    {{ $tarif->jenisParkir->nama ?? '-' }}

                                </div>

                            </td>


                            {{-- JENIS KENDARAAN --}}
                            <td>

                                <div class="fw-semibold small">

                                    {{ $tarif->jenis_kendaraan ?? '-' }}

                                </div>

                                @if($tarif->keterangan)

                                    <div class="text-muted"
                                         style="font-size:11px;">

                                        {{ $tarif->keterangan }}

                                    </div>

                                @endif

                            </td>


                            {{-- NOMINAL --}}
                            <td class="text-end">

                                <span class="fw-semibold small">

                                    Rp
                                    {{ number_format((float) $tarif->nominal, 0, ',', '.') }}

                                </span>

                            </td>


                            {{-- BERLAKU MULAI --}}
                            <td class="text-muted small">

                                {{ $tarif->berlaku_mulai
                                    ? $tarif->berlaku_mulai->translatedFormat('d M Y')
                                    : '-' }}

                            </td>


                            {{-- BERLAKU SAMPAI --}}
                            <td class="text-muted small">

                                {{ $tarif->berlaku_sampai
                                    ? $tarif->berlaku_sampai->translatedFormat('d M Y')
                                    : '-' }}

                            </td>


                            {{-- STATUS --}}
                            <td class="text-center">

                                @if($tarif->status)

                                    <span class="badge rounded-pill
                                                 text-bg-success">

                                        <i class="bi bi-check-circle me-1"></i>

                                        Aktif

                                    </span>

                                @else

                                    <span class="badge rounded-pill
                                                 text-bg-danger">

                                        <i class="bi bi-x-circle me-1"></i>

                                        Tidak Aktif

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i class="bi bi-file-earmark-x fs-1"></i>

                                    <div class="fw-semibold mt-2">

                                        Data tarif tidak ditemukan

                                    </div>

                                    <div class="small mt-1">

                                        Coba ubah kata pencarian atau filter.

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($tarifs->hasPages())

            <div class="card-footer bg-white">

                {{ $tarifs->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

@endsection