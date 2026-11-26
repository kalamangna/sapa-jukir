@extends('layouts.admin')

@section('title', 'Laporan Setoran')

@section('page-title', 'Laporan Setoran')

@section('content')

<div class="mb-4">

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">

        <div>

            <h4 class="fw-bold mb-1">
                Laporan Setoran
            </h4>

            <p class="text-muted mb-0">
                Rekap dan monitoring setoran petugas.
            </p>

        </div>


        <div>

            <a
                href="{{ route('admin.laporan.setoran.cetak', request()->query()) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="btn btn-primary"
            >

                <i class="bi bi-printer me-1"></i>

                Cetak Laporan

            </a>

        </div>

    </div>

</div>


{{-- ==========================================================
    RINGKASAN
=========================================================== --}}

<div class="row g-3 mb-4">


    {{-- TOTAL SETORAN --}}

    <div class="col-12 col-md-6 col-xl-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body text-center">

                <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto mb-3" style="width:50px;height:50px;">

                    <i class="bi bi-receipt fs-4"></i>

                </div>

                <div class="text-muted small">
                    Total Setoran
                </div>

                <div class="fs-4 fw-bold mt-2">
                    {{ number_format($totalSetoran, 0, ',', '.') }}
                </div>

            </div>

        </div>

    </div>


    {{-- BELUM VERIFIKASI --}}

    <div class="col-12 col-md-6 col-xl-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body text-center">

                <div class="rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center mx-auto mb-3" style="width:50px;height:50px;">

                    <i class="bi bi-hourglass-split fs-4"></i>

                </div>

                <div class="text-muted small">
                    Belum Verifikasi
                </div>

                <div class="fs-4 fw-bold mt-2">
                    {{ number_format($totalBelumVerifikasi, 0, ',', '.') }}
                </div>

            </div>

        </div>

    </div>


    {{-- TERVERIFIKASI --}}

    <div class="col-12 col-md-6 col-xl-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body text-center">

                <div class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center mx-auto mb-3" style="width:50px;height:50px;">

                    <i class="bi bi-check-circle fs-4"></i>

                </div>

                <div class="text-muted small">
                    Terverifikasi
                </div>

                <div class="fs-4 fw-bold mt-2">
                    {{ number_format($totalTerverifikasi, 0, ',', '.') }}
                </div>

            </div>

        </div>

    </div>


    {{-- DITOLAK --}}

    <div class="col-12 col-md-6 col-xl-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body text-center">

                <div class="rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center mx-auto mb-3" style="width:50px;height:50px;">

                    <i class="bi bi-x-circle fs-4"></i>

                </div>

                <div class="text-muted small">
                    Ditolak
                </div>

                <div class="fs-4 fw-bold mt-2">
                    {{ number_format($totalDitolak, 0, ',', '.') }}
                </div>

            </div>

        </div>

    </div>

</div>


{{-- ==========================================================
    RINGKASAN KEUANGAN
=========================================================== --}}

<div class="row g-3 mb-4">


    <div class="col-12 col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center">

                <div class="text-muted small mb-1">
                    Total Pendapatan Bruto
                </div>

                <div class="fs-5 fw-bold">
                    Rp {{ number_format($totalPendapatanBruto, 0, ',', '.') }}
                </div>

            </div>

        </div>

    </div>


    <div class="col-12 col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center">

                <div class="text-muted small mb-1">
                    Total Jumlah Setoran
                </div>

                <div class="fs-5 fw-bold">
                    Rp {{ number_format($totalJumlahSetoran, 0, ',', '.') }}
                </div>

            </div>

        </div>

    </div>


    <div class="col-12 col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center">

                <div class="text-muted small mb-1">
                    Total Selisih
                </div>

                <div class="fs-5 fw-bold">
                    Rp {{ number_format($totalSelisih, 0, ',', '.') }}
                </div>

            </div>

        </div>

    </div>

</div>


{{-- ==========================================================
    FILTER
=========================================================== --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form
            class="setoran-filter-form"
            method="GET"
            action="{{ route('admin.laporan.setoran') }}"
        >

            <div class="row g-3">


                {{-- SEARCH --}}

                <div class="col-12 col-lg-3">

                    <label class="form-label fw-semibold text-center d-block">
                        Pencarian
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        class="form-control"
                        placeholder="Contoh: JK-001 atau Ahmad"
                    >

                </div>


                {{-- Petugas --}}

                <div class="col-12 col-md-6 col-lg-2">

                    <label class="form-label fw-semibold text-center d-block">
                        Petugas
                    </label>

                    <select
                        name="jukir_id"
                        class="form-select"
                    >

                        <option value="">
                            Semua Petugas
                        </option>

                        @foreach($jukirs as $jukir)

                            <option
                                value="{{ $jukir->id }}"
                                @selected($jukirId == $jukir->id)
                            >
                                {{ $jukir->kode_jukir }}
                                -
                                {{ $jukir->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>


{{-- TITIK / OBJEK PENDAPATAN --}}

                <div class="col-12 col-md-6 col-lg-4">

                    <label class="form-label fw-semibold text-center d-block">
                        Objek Pendapatan
                    </label>

                    <select
                        name="titik_parkir_id"
                        class="form-select text-center"
                    >

                        <option value="">
                            Semua Titik
                        </option>

                        @foreach($titikParkirs as $titik)

                            <option
                                value="{{ $titik->id }}"
                                @selected($titikParkirId == $titik->id)
                            >
                                {{ $titik->kode_titik }}
                                -
                                {{ $titik->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}

                <div class="col-12 col-md-6 col-lg-3">

                    <label class="form-label fw-semibold text-center d-block">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        @foreach($statuses as $item)

                            <option
                                value="{{ $item }}"
                                @selected($status === $item)
                            >

                                @if($item === 'belum_verifikasi')
                                    Belum Verifikasi
                                @elseif($item === 'terverifikasi')
                                    Terverifikasi
                                @elseif($item === 'ditolak')
                                    Ditolak
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $item)) }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- TANGGAL MULAI --}}

                <div class="col-12 col-md-6 col-lg-3">

                    <label class="form-label fw-semibold text-center d-block">
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        name="tanggal_mulai"
                        value="{{ $tanggalMulai }}"
                        class="form-control"
                    >

                </div>


                {{-- TANGGAL SELESAI --}}

                <div class="col-12 col-md-6 col-lg-3">

                    <label class="form-label fw-semibold text-center d-block">
                        Tanggal Selesai
                    </label>

                    <input
                        type="date"
                        name="tanggal_selesai"
                        value="{{ $tanggalSelesai }}"
                        class="form-control"
                    >

                </div>


                {{-- BUTTON --}}

                <div class="col-12">

                    <div class="d-flex flex-wrap gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-search me-1"></i>

                            Terapkan Filter

                        </button>


                        <a
                            href="{{ route('admin.laporan.setoran') }}"
                            class="btn btn-outline-secondary"
                        >

                            <i class="bi bi-arrow-counterclockwise me-1"></i>

                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- ==========================================================
    TABEL DATA
=========================================================== --}}

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

            <div>

                <h5 class="fw-bold mb-1">
                    Data Setoran
                </h5>

                <small class="text-muted">
                    Menampilkan {{ $setorans->count() }}
                    dari {{ $setorans->total() }} data.
                </small>

            </div>


            <a
                href="{{ route('admin.setoran.create') }}"
                class="btn btn-success"
            >

                <i class="bi bi-plus-lg me-1"></i>

                Tambah Setoran

            </a>

        </div>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="text-center">
                            #
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Petugas
                        </th>

                        <th>
                            Objek Pendapatan
                        </th>

                        <th class="text-end">
                            Pendapatan Bruto
                        </th>

                        <th class="text-end">
                            Setoran
                        </th>

                        <th class="text-end">
                            Selisih
                        </th>

                        <th class="text-center">
                            Status
                        </th>

                        <th class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($setorans as $setoran)

                        <tr>

                            <td class="text-center">

                                {{ $setorans->firstItem() + $loop->index }}

                            </td>


                            <td>

                                {{ \Carbon\Carbon::parse($setoran->tanggal)->format('d/m/Y') }}

                            </td>


                            <td>

                                @if($setoran->jukir)

                                    <div class="fw-semibold">
                                        {{ $setoran->jukir->nama }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $setoran->jukir->kode_jukir }}
                                    </small>

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($setoran->titikParkir)

                                    <div class="fw-semibold">
                                        {{ $setoran->titikParkir->nama }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $setoran->titikParkir->kode_titik }}
                                    </small>

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            <td class="text-end">

                                Rp
                                {{ number_format($setoran->pendapatan_bruto, 0, ',', '.') }}

                            </td>


                            <td class="text-end">

                                Rp
                                {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}

                            </td>


                            <td class="text-end">

                                Rp
                                {{ number_format($setoran->selisih, 0, ',', '.') }}

                            </td>


                            <td class="text-center">

                                @if($setoran->status === 'terverifikasi')

                                    <span class="badge bg-success-subtle text-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Terverifikasi
                                    </span>

                                @elseif($setoran->status === 'ditolak')

                                    <span class="badge bg-danger-subtle text-danger">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge bg-warning-subtle text-warning">
                                        <i class="bi bi-hourglass-split me-1"></i>
                                        Belum Verifikasi
                                    </span>

                                @endif

                            </td>


                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-1">

                                    <a
                                        href="{{ route('admin.setoran.show', $setoran->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Detail"
                                    >

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    <a
                                        href="{{ route('admin.setoran.edit', $setoran->id) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Ubah"
                                        aria-label="Ubah setoran {{ $setoran->jukir?->nama }}"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="text-center py-5"
                            >

                                <div class="text-muted">

                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                                    <div class="fw-semibold">
                                        Belum ada data setoran
                                    </div>

                                    <small>
                                        Data setoran akan muncul di sini.
                                    </small>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- PAGINATION --}}

    @if($setorans->hasPages())

        <div class="card-footer bg-white">

            {{ $setorans->links() }}

        </div>

    @endif

</div>

@endsection