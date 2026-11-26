@extends('layouts.admin')

@section('title', 'Jenis Sumber Pendapatan')

@section('page-title', 'Jenis Sumber Pendapatan')


@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Jenis Sumber Pendapatan
        </h4>

        <p class="text-muted mb-0">
            Kelola master data jenis sumber pendapatan untuk objek pendapatan.
        </p>

    </div>


    <a
        href="{{ route('admin.jenis-parkir.create') }}"
        class="btn btn-success"
    >
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Jenis Sumber Pendapatan
    </a>

</div>



{{-- ==========================================================
    SEARCH
========================================================== --}}

<div class="card mb-4">

    <div class="card-body">

        <form
            action="{{ route('admin.jenis-parkir.index') }}"
            method="GET"
        >

            <div class="row g-3 align-items-end">

                <div class="col-md-6">

                    <label
                        for="search"
                        class="form-label fw-semibold"
                    >
                        Cari Jenis Sumber Pendapatan
                    </label>


                    <div class="input-group">

                        <span class="input-group-text bg-white">

                            <i class="bi bi-search"></i>

                        </span>


                        <input
                            type="text"
                            id="search"
                            name="search"
                            class="form-control"
                            placeholder="TJU-01 atau Parkir Tepi Jalan"
                            value="{{ $search }}"
                        >

                    </div>

                </div>


                <div class="col-md-auto">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-search me-1"></i>

                        Filter

                    </button>

                </div>


                @if($search)

                    <div class="col-md-auto">

                        <a
                            href="{{ route('admin.jenis-parkir.index') }}"
                            class="btn btn-outline-secondary"
                        >

                            <i class="bi bi-arrow-counterclockwise me-1"></i>

                            Reset

                        </a>

                    </div>

                @endif

            </div>

        </form>

    </div>

</div>



{{-- ==========================================================
    TABLE
========================================================== --}}

<div class="card">

    <div class="card-body p-0">

        <div class="d-flex justify-content-between align-items-center p-4 border-bottom">

            <div>

                <h6 class="mb-1 fw-bold">
                    Daftar Jenis Sumber Pendapatan

                <small class="text-muted">

                    Total: {{ $jenisParkirs->total() }} data

                </small>

            </div>

        </div>



        @if($jenisParkirs->count())

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="ps-4">
                                No
                            </th>

                            <th>
                                Kode
                            </th>

                            <th>
                                Nama Jenis Sumber Pendapatan
                            </th>

                            <th>
                                Deskripsi
                            </th>

                            <th class="text-center">
                                Objek
                            </th>

                            <th class="text-center">
                                Tarif
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

                        @foreach($jenisParkirs as $jenisParkir)

                            <tr>

                                {{-- NOMOR --}}

                                <td class="ps-4 text-muted">

                                    {{
                                        $jenisParkirs->firstItem()
                                        + $loop->index
                                    }}

                                </td>



                                {{-- KODE --}}

                                <td>

                                    <span class="font-monospace fw-semibold">

                                        {{ $jenisParkir->kode }}

                                    </span>

                                </td>



                                {{-- NAMA --}}

                                <td>

                                    <div class="fw-semibold">

                                        {{ $jenisParkir->nama }}

                                    </div>

                                </td>



                                {{-- DESKRIPSI --}}

                                <td>

                                    @if($jenisParkir->deskripsi)

                                        <span class="text-muted">

                                            {{ \Illuminate\Support\Str::limit(
                                                $jenisParkir->deskripsi,
                                                60
                                            ) }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>



                                {{-- JUMLAH TITIK PARKIR --}}

                                <td class="text-center">

                                    <span class="badge text-bg-light border">

                                        {{ $jenisParkir->titik_parkirs_count }}

                                    </span>

                                </td>



                                {{-- JUMLAH TARIF --}}

                                <td class="text-center">

                                    <span class="badge text-bg-light border">

                                        {{ $jenisParkir->tarifs_count }}

                                    </span>

                                </td>



                                {{-- STATUS --}}

                                <td>

                                    @if($jenisParkir->status)

                                        <span class="badge bg-success">

                                            Aktif

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            Nonaktif

                                        </span>

                                    @endif

                                </td>



                                {{-- AKSI --}}

                                <td class="text-center pe-4">

                                    <div class="btn-group">

                                        {{-- DETAIL --}}

                                        <a
                                            href="{{ route('admin.jenis-parkir.show', $jenisParkir) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Detail"
                                            aria-label="Detail {{ $jenisParkir->nama }}"
                                        >

                                            <i class="bi bi-eye"></i>

                                        </a>



                                        {{-- EDIT --}}

                                        <a
                                            href="{{ route('admin.jenis-parkir.edit', $jenisParkir) }}"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Ubah"
                                            aria-label="Ubah {{ $jenisParkir->nama }}"
                                        >

                                            <i class="bi bi-pencil-square"></i>

                                        </a>



                                        {{-- HAPUS --}}

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger btn-delete-jenis-parkir"
                                            title="Hapus"
                                            aria-label="Hapus {{ $jenisParkir->nama }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteJenisParkirModal"
                                            data-url="{{ route('admin.jenis-parkir.destroy', $jenisParkir) }}"
                                            data-nama="{{ $jenisParkir->nama }}"
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>



            {{-- PAGINATION --}}

            @if($jenisParkirs->hasPages())

                <div class="p-4 border-top">

                    {{ $jenisParkirs->links() }}

                </div>

            @endif


        @else

            {{-- ======================================================
                EMPTY STATE
            ======================================================= --}}

            <div class="text-center py-5">

                <div
                    class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:70px;height:70px;"
                >

                    <i
                        class="bi bi-signpost text-muted"
                        style="font-size:30px;"
                    ></i>

                </div>



                <h5 class="fw-semibold">

                    Data Jenis Sumber Pendapatan Belum Tersedia

                </h5>



                <p class="text-muted mb-4">

                    @if($search)

                        Data dengan kata kunci

                        <strong>
                            "{{ $search }}"
                        </strong>

                        tidak ditemukan.

                    @else

                        Belum ada jenis sumber pendapatan yang terdaftar.

                    @endif

                </p>



                @if($search)

                    <a
                        href="{{ route('admin.jenis-parkir.index') }}"
                        class="btn btn-outline-secondary"
                    >

                        <i class="bi bi-arrow-left me-1"></i>

                        Kembali ke Semua Data

                    </a>

                @else

                    <a
                        href="{{ route('admin.jenis-parkir.create') }}"
                        class="btn btn-success"
                    >

                        <i class="bi bi-plus-circle me-1"></i>

                        Tambah Jenis Parkir Pertama

                    </a>

                @endif

            </div>

        @endif

    </div>

</div>



{{-- ==========================================================
    MODAL KONFIRMASI HAPUS
========================================================== --}}

<div
    class="modal fade"
    id="deleteJenisParkirModal"
    tabindex="-1"
    aria-labelledby="deleteJenisParkirModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            {{-- HEADER --}}

            <div class="modal-header">

                <h5
                    class="modal-title fw-bold"
                    id="deleteJenisParkirModalLabel"
                >

                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>

                    Hapus Jenis Parkir

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Tutup dialog"
                ></button>

            </div>



            {{-- BODY --}}

            <div class="modal-body">

                <p class="mb-2">

                    Hapus jenis parkir berikut?

                </p>


                <div class="alert alert-danger mb-0">

                    <strong id="deleteJenisParkirName">
                        -
                    </strong>

                </div>


                <p class="text-muted small mt-3 mb-0">

                    Data yang sudah dihapus tidak dapat dikembalikan.

                    Jika jenis parkir masih digunakan oleh Titik Parkir
                    atau Tarif, sistem tidak akan mengizinkan penghapusan.

                </p>

            </div>



            {{-- FOOTER --}}

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light border"
                    data-bs-dismiss="modal"
                >

                    <i class="bi bi-x-circle me-1"></i>

                    Batal

                </button>



                <form
                    id="deleteJenisParkirForm"
                    method="POST"
                >

                    @csrf

                    @method('DELETE')


                    <button
                        type="submit"
                        class="btn btn-danger"
                    >

                        <i class="bi bi-trash me-1"></i>

                        Ya, Hapus

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const deleteButtons = document.querySelectorAll(
        '.btn-delete-jenis-parkir'
    );


    const deleteForm = document.getElementById(
        'deleteJenisParkirForm'
    );


    const deleteName = document.getElementById(
        'deleteJenisParkirName'
    );


    deleteButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const url = this.dataset.url;

            const nama = this.dataset.nama;


            deleteForm.action = url;

            deleteName.textContent = nama;

        });

    });

});

</script>

@endpush