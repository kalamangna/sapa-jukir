@extends('layouts.admin')

@section('title', 'Data Setoran')

@section('page-title', 'Data Setoran')

@section('content')

<div class="container-fluid px-0">

    {{-- ==========================================================
        HEADER
    =========================================================== --}}

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Data Setoran
            </h4>

            <p class="text-muted mb-0">
                Kelola dan pantau data setoran Petugas.
            </p>
        </div>

        <div>
            <a
                href="{{ route('admin.setoran.create') }}"
                class="btn btn-primary"
            >
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Setoran
            </a>
        </div>

    </div>


    {{-- ==========================================================
        RINGKASAN
    =========================================================== --}}

    <div class="row g-3 mb-4">

        {{-- TOTAL SETORAN --}}

        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small mb-1">
                                Total Setoran
                            </div>

                            <div class="fs-4 fw-bold">
                                {{ number_format($totalSetoran, 0, ',', '.') }}
                            </div>

                        </div>

                        <div
                            class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                            style="width:52px;height:52px;"
                        >
                            <i class="bi bi-receipt fs-4"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- PENDAPATAN BRUTO --}}

        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small mb-1">
                                Pendapatan Bruto
                            </div>

                            <div class="fs-5 fw-bold text-success">
                                Rp {{ number_format($totalPendapatanBruto, 0, ',', '.') }}
                            </div>

                        </div>

                        <div
                            class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center"
                            style="width:52px;height:52px;"
                        >
                            <i class="bi bi-cash-stack fs-4"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TOTAL SETORAN --}}

        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small mb-1">
                                Jumlah Setoran
                            </div>

                            <div class="fs-5 fw-bold text-primary">
                                Rp {{ number_format($totalJumlahSetoran, 0, ',', '.') }}
                            </div>

                        </div>

                        <div
                            class="rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center"
                            style="width:52px;height:52px;"
                        >
                            <i class="bi bi-wallet2 fs-4"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- SELISIH --}}

        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small mb-1">
                                Total Selisih
                            </div>

                            <div
                                class="fs-5 fw-bold
                                {{ $totalSelisih > 0 ? 'text-danger' : 'text-success' }}"
                            >
                                Rp {{ number_format($totalSelisih, 0, ',', '.') }}
                            </div>

                        </div>

                        <div
                            class="rounded-3
                            {{ $totalSelisih > 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }}
                            d-flex align-items-center justify-content-center"
                            style="width:52px;height:52px;"
                        >
                            <i class="bi bi-graph-down-arrow fs-4"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
        FILTER
    =========================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <div class="d-flex align-items-center mb-3">

                <div
                    class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2"
                    style="width:40px;height:40px;"
                >
                    <i class="bi bi-funnel"></i>
                </div>

                <div>

                    <h6 class="fw-bold mb-0">
                        Filter Data
                    </h6>

                    <small class="text-muted">
                        Gunakan filter untuk mencari data setoran.
                    </small>

                </div>

            </div>


            <form
                method="GET"
                action="{{ route('admin.setoran.index') }}"
            >

                <div class="row g-3">

                    {{-- PENCARIAN --}}

                    <div class="col-12 col-lg-3">

                        <label class="form-label fw-semibold">
                            Pencarian
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                value="{{ $search }}"
                                placeholder="Kode / nama Petugas / titik/objek pendapatan..."
                            >

                        </div>

                    </div>


                    {{-- Petugas --}}

                    <div class="col-12 col-md-6 col-lg-2">

                        <label class="form-label fw-semibold">
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
                                    {{ $jukir->nama }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- TITIK / OBJEK PEMASUKAN --}}

                    <div class="col-12 col-md-6 col-lg-3">

                        <label class="form-label fw-semibold">
                            Titik/Objek Pendapatan
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
                                    {{ $titik->nama }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- STATUS --}}

                    {{-- KATEGORI PEMASUKAN --}}

                    <div class="col-12 col-md-6 col-lg-2">

                        <label class="form-label fw-semibold">
                            Kategori Pendapatan
                        </label>

                        <select name="sumber_pemasukan_id" class="form-select">

                            <option value="">Semua Kategori</option>

                            @foreach($sumberPemasukans as $sumberPemasukan)
                                <option value="{{ $sumberPemasukan->id }}" @selected($sumberPemasukanId == $sumberPemasukan->id)>{{ $sumberPemasukan->nama }}</option>
                            @endforeach

                        </select>

                    </div>

                    {{-- STATUS --}}

                    <div class="col-12 col-md-6 col-lg-2">

                        <label class="form-label fw-semibold">
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

                                    @switch($item)

                                        @case('belum_verifikasi')
                                            Belum Verifikasi
                                            @break

                                        @case('terverifikasi')
                                            Terverifikasi
                                            @break

                                        @case('ditolak')
                                            Ditolak
                                            @break

                                        @default
                                            {{ ucfirst(str_replace('_', ' ', $item)) }}

                                    @endswitch

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- TANGGAL MULAI --}}

                    <div class="col-12 col-md-6 col-lg-3">

                        <label class="form-label fw-semibold">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="tanggal_mulai"
                            class="form-control"
                            value="{{ $tanggalMulai }}"
                        >

                    </div>


                    {{-- TANGGAL SELESAI --}}

                    <div class="col-12 col-md-6 col-lg-3">

                        <label class="form-label fw-semibold">
                            Tanggal Selesai
                        </label>

                        <input
                            type="date"
                            name="tanggal_selesai"
                            class="form-control"
                            value="{{ $tanggalSelesai }}"
                        >

                    </div>


                    {{-- BUTTON --}}

                    <div class="col-12 d-flex flex-wrap gap-2 pt-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-search me-1"></i>

                            Terapkan Filter

                        </button>


                        <a
                            href="{{ route('admin.setoran.index') }}"
                            class="btn btn-light border"
                        >

                            <i class="bi bi-arrow-counterclockwise me-1"></i>

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ==========================================================
        TABEL DATA
    =========================================================== --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">


            {{-- HEADER TABEL --}}

            <div class="p-4 border-bottom">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Daftar Setoran
                        </h5>

                        <p class="text-muted small mb-0">
                            Menampilkan data setoran Petugas.
                        </p>

                    </div>

                    <span class="badge bg-light text-dark border">

                        {{ $setorans->total() }}

                        data

                    </span>

                </div>

            </div>


            {{-- TABLE RESPONSIVE --}}

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light text-center">

                        <tr>

                            <th class="text-center" style="width:60px;">
                                No
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Petugas
                            </th>

                            <th>
                                Titik/Objek Pendapatan
                            </th>

                            <th>
                                Kategori Pendapatan
                            </th>

                            <th class="text-center">
                                Kendaraan
                            </th>

                            <th class="text-end">
                                Pendapatan Bruto
                            </th>

                            <th class="text-end">
                                Jumlah Setoran
                            </th>

                            <th class="text-end">
                                Selisih
                            </th>

                            <th class="text-center">
                                Status
                            </th>

                            <th class="text-center" style="width:150px;">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($setorans as $index => $setoran)

                            <tr>

                                {{-- NO --}}

                                <td class="text-center">

                                    {{ $setorans->firstItem() + $index }}

                                </td>


                                {{-- TANGGAL --}}

                                <td>

                                    <div class="fw-semibold">

                                        {{ $setoran->tanggal?->translatedFormat('d F Y') }}

                                    </div>

                                </td>


                                {{-- Petugas --}}

                                <td>

                                    @if($setoran->jukir)

                                        <div class="fw-semibold">

                                            {{ $setoran->jukir->nama }}

                                        </div>

                                        @if($setoran->jukir->kode_jukir)

                                            <small class="text-muted">

                                                {{ $setoran->jukir->kode_jukir }}

                                            </small>

                                        @endif

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- TITIK PARKIR --}}

                                <td>

                                    @if($setoran->titikParkir)

                                        <div class="fw-semibold">

                                            {{ $setoran->titikParkir->nama }}

                                        </div>

                                        @if($setoran->titikParkir->kode_titik)

                                            <small class="text-muted">

                                                {{ $setoran->titikParkir->kode_titik }}

                                            </small>

                                        @endif

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- PENDAPATAN BRUTO --}}

                                <td>
                                    {{ $setoran->sumberPemasukan?->nama ?? $setoran->titikParkir?->jenisParkir?->nama ?? '-' }}
                                </td>

                                <td class="text-center">
                                    <span class="d-block">Motor: {{ $setoran->jumlah_motor ?? '-' }}</span>
                                    <span class="d-block">Mobil: {{ $setoran->jumlah_mobil ?? '-' }}</span>
                                </td>

                                {{-- PENDAPATAN BRUTO --}}

                                <td class="text-end">

                                    Rp
                                    {{ number_format($setoran->pendapatan_bruto, 0, ',', '.') }}

                                </td>


                                {{-- JUMLAH SETORAN --}}

                                <td class="text-end fw-semibold">

                                    Rp
                                    {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}

                                </td>


                                {{-- SELISIH --}}

                                <td class="text-end">

                                    <span
                                        class="fw-semibold
                                        {{ $setoran->selisih > 0 ? 'text-danger' : ($setoran->selisih < 0 ? 'text-success' : 'text-muted') }}"
                                    >

                                        Rp
                                        {{ number_format($setoran->selisih, 0, ',', '.') }}

                                    </span>

                                </td>


                                {{-- STATUS --}}

                                <td class="text-center">

                                    @switch($setoran->status)

                                        @case('belum_verifikasi')

                                            <span class="badge bg-warning-subtle text-warning-emphasis">

                                                <i class="bi bi-clock me-1"></i>

                                                Belum Verifikasi

                                            </span>

                                            @break


                                        @case('terverifikasi')

                                            <span class="badge bg-success-subtle text-success-emphasis">

                                                <i class="bi bi-check-circle me-1"></i>

                                                Terverifikasi

                                            </span>

                                            @break


                                        @case('ditolak')

                                            <span class="badge bg-danger-subtle text-danger-emphasis">

                                                <i class="bi bi-x-circle me-1"></i>

                                                Ditolak

                                            </span>

                                            @break


                                        @default

                                            <span class="badge bg-secondary-subtle text-secondary">

                                                {{ ucfirst(str_replace('_', ' ', $setoran->status)) }}

                                            </span>

                                    @endswitch

                                </td>


                                {{-- AKSI --}}

                                <td class="text-center">

                                    <div class="d-flex justify-content-center gap-1">

                                        {{-- DETAIL --}}

                                        <a
                                            href="{{ route('admin.setoran.show', $setoran->id) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Detail"
                                        >

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        {{-- EDIT --}}

                                        <a
                                            href="{{ route('admin.setoran.edit', $setoran->id) }}"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Edit"
                                        >

                                            <i class="bi bi-pencil"></i>

                                        </a>


                                        {{-- HAPUS --}}

                                        <form
                                            action="{{ route('admin.setoran.destroy', $setoran->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data setoran ini? Data yang sudah diverifikasi juga akan dihapus.')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Hapus"
                                            >

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center py-5"
                                >

                                    <div class="mb-3">

                                        <i
                                            class="bi bi-receipt text-muted"
                                            style="font-size:48px;"
                                        ></i>

                                    </div>

                                    <h6 class="fw-bold">
                                        Belum ada data setoran
                                    </h6>

                                    <p class="text-muted mb-3">
                                        Data setoran belum tersedia atau
                                        tidak ditemukan berdasarkan filter.
                                    </p>

                                    <a
                                        href="{{ route('admin.setoran.create') }}"
                                        class="btn btn-primary"
                                    >

                                        <i class="bi bi-plus-lg me-1"></i>

                                        Tambah Setoran

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ======================================================
                PAGINATION
            ======================================================= --}}

            @if($setorans->hasPages())

                <div class="p-4 border-top">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                        <div class="text-muted small">

                            Menampilkan

                            <strong>
                                {{ $setorans->firstItem() ?? 0 }}
                            </strong>

                            sampai

                            <strong>
                                {{ $setorans->lastItem() ?? 0 }}
                            </strong>

                            dari

                            <strong>
                                {{ $setorans->total() }}
                            </strong>

                            data.

                        </div>

                        <div>

                            {{ $setorans->links() }}

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection