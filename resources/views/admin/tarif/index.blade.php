@extends('layouts.admin')

@section('title', 'Tarif Retribusi')

@section('page-title', 'Tarif Retribusi')

@section('content')

{{-- ==========================================================
    HEADER
========================================================== --}}

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Tarif Retribusi
        </h4>

        <p class="text-muted mb-0">
            Kelola tarif retribusi berdasarkan jenis kendaraan dan jenis retribusi.
        </p>

    </div>


    <a
        href="{{ route('admin.tarif.create') }}"
        class="btn btn-success"
    >

        <i class="bi bi-plus-circle me-1"></i>

        Tambah Tarif

    </a>

</div>





{{-- ==========================================================
    ERROR MESSAGE
========================================================== --}}




{{-- ==========================================================
    SEARCH
========================================================== --}}

<div class="card mb-4">

    <div class="card-body">

        <form
            action="{{ route('admin.tarif.index') }}"
            method="GET"
        >

            <div class="row g-3 align-items-end">

                <div class="col-md-10">

                    <label
                        for="search"
                        class="form-label fw-semibold"
                    >
                        Cari Tarif
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            class="form-control"
                            value="{{ $search }}"
                            placeholder="Roda 2 atau Parkir Pasar"
                        >

                    </div>

                </div>


                <div class="col-md-2">

                    <button
                        type="submit"
                        class="btn btn-success w-100"
                    >

                        <i class="bi bi-search me-1"></i>

                        Filter

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>



{{-- ==========================================================
    DATA TARIF
========================================================== --}}

<div class="card">

    <div class="card-header bg-white border-bottom py-3">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-cash-stack me-2 text-success"></i>

                Daftar Tarif

            </h6>


            <span class="badge text-bg-light border">

                {{ $tarifs->total() }}

                Data

            </span>

        </div>

    </div>


    <div class="card-body p-0">

        @if($tarifs->count())

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="text-center" style="width:60px;">
                                #
                            </th>

                            <th>
                                Jenis Retribusi
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

                            <th class="text-center">
                                Status
                            </th>

                            <th
                                class="text-center"
                                style="width:150px;"
                            >
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($tarifs as $tarif)

                            <tr>

                                {{-- NOMOR --}}

                                <td class="text-center">

                                    {{ $tarifs->firstItem() + $loop->index }}

                                </td>



                                {{-- JENIS PARKIR --}}

                                <td>

                                    @if($tarif->jenisParkir)

                                        <div class="fw-semibold">

                                            {{ $tarif->jenisParkir->nama }}

                                        </div>

                                        <small class="text-muted font-monospace">

                                            {{ $tarif->jenisParkir->kode }}

                                        </small>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>



                                {{-- JENIS KENDARAAN --}}

                                <td>

                                    <span class="fw-semibold">

                                        {{ $tarif->jenis_kendaraan }}

                                    </span>

                                </td>



                                {{-- NOMINAL --}}

                                <td>

                                    <span class="fw-semibold text-success">

                                        Rp
                                        {{ number_format(
                                            $tarif->nominal,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </span>

                                </td>



                                {{-- BERLAKU MULAI --}}

                                <td>

                                    {{ $tarif->berlaku_mulai?->format('d-m-Y') ?? '-' }}

                                </td>



                                {{-- BERLAKU SAMPAI --}}

                                <td>

                                    {{ $tarif->berlaku_sampai?->format('d-m-Y') ?? '-' }}

                                </td>



                                {{-- STATUS --}}

                                <td class="text-center">

                                    @if($tarif->status)

                                        <span class="badge bg-success">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Aktif

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            <i class="bi bi-x-circle me-1"></i>

                                            Nonaktif

                                        </span>

                                    @endif

                                </td>



                                {{-- AKSI --}}

                                <td class="text-center">

                                    <div class="d-flex justify-content-center gap-1">

                                        {{-- DETAIL --}}

                                        <a
                                            href="{{ route('admin.tarif.show', $tarif) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Detail"
                                            aria-label="Detail tarif {{ $tarif->jenis_kendaraan }}"
                                        >

                                            <i class="bi bi-eye"></i>

                                        </a>



                                        {{-- EDIT --}}

                                        <a
                                            href="{{ route('admin.tarif.edit', $tarif) }}"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Ubah"
                                            aria-label="Ubah tarif {{ $tarif->jenis_kendaraan }}"
                                        >

                                            <i class="bi bi-pencil-square"></i>

                                        </a>



                                        {{-- HAPUS --}}

                                        <form
                                            action="{{ route('admin.tarif.destroy', $tarif) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Hapus tarif retribusi ini? Tarif tidak lagi tersedia untuk pencatatan baru.');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Hapus"
                                                aria-label="Hapus tarif {{ $tarif->jenis_kendaraan }}"
                                            >

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </div>

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
                    class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:80px;height:80px;"
                >

                    <i
                        class="bi bi-cash-stack"
                        style="font-size:36px;"
                    ></i>

                </div>


                <h5 class="fw-bold mb-2">

                    Belum Ada Data Tarif

                </h5>


                @if($search)

                    <p class="text-muted mb-3">

                        Tidak ditemukan tarif dengan kata pencarian:

                        <strong>
                            "{{ $search }}"
                        </strong>

                    </p>

                    <a
                        href="{{ route('admin.tarif.index') }}"
                        class="btn btn-outline-secondary"
                    >

                        <i class="bi bi-arrow-counterclockwise me-1"></i>

                        Reset Pencarian

                    </a>

                @else

                    <p class="text-muted mb-3">

                        Belum ada data tarif parkir yang tersedia.

                    </p>

                    <a
                        href="{{ route('admin.tarif.create') }}"
                        class="btn btn-success"
                    >

                        <i class="bi bi-plus-circle me-1"></i>

                        Tambah Tarif

                    </a>

                @endif

            </div>

        @endif

    </div>


    {{-- ======================================================
        PAGINATION
    ======================================================= --}}

    @if($tarifs->hasPages())

        <div class="card-footer bg-white border-top">

            {{ $tarifs->links() }}

        </div>

    @endif

</div>

@endsection