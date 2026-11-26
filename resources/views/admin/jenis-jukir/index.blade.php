@extends('layouts.admin')

@section('title', 'Jenis Petugas')

@section('page-title', 'Jenis Petugas')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Jenis Petugas
        </h4>

        <p class="text-muted mb-0">
            Kelola master data jenis Petugas.
        </p>

    </div>


    <a
        href="{{ route('admin.jenis-jukir.create') }}"
        class="btn btn-success"
    >
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Jenis Petugas
    </a>

</div>



{{-- ==========================================================
    SEARCH
========================================================== --}}

<div class="card mb-4">

    <div class="card-body">

        <form
            action="{{ route('admin.jenis-jukir.index') }}"
            method="GET"
        >

            <div class="row g-3 align-items-end">

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Cari Jenis Petugas
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white">

                            <i class="bi bi-search"></i>

                        </span>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari kode atau nama jenis Petugas..."
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
                        Cari
                    </button>

                </div>


                @if($search)

                    <div class="col-md-auto">

                        <a
                            href="{{ route('admin.jenis-jukir.index') }}"
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
                    Daftar Jenis Petugas
                </h6>

                <small class="text-muted">
                    Total: {{ $jenisJukirs->total() }} data
                </small>

            </div>

        </div>


        @if($jenisJukirs->count())

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
                                Nama Jenis
                            </th>

                            <th>
                                Deskripsi
                            </th>

                            <th class="text-center">
                                Jumlah Petugas
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

                        @foreach($jenisJukirs as $jenisJukir)

                            <tr>

                                <td class="ps-4 text-muted">

                                    {{
                                        $jenisJukirs->firstItem()
                                        + $loop->index
                                    }}

                                </td>


                                {{-- KODE --}}

                                <td>

                                    <span class="font-monospace fw-semibold">

                                        {{ $jenisJukir->kode }}

                                    </span>

                                </td>


                                {{-- NAMA --}}

                                <td>

                                    <div class="fw-semibold">

                                        {{ $jenisJukir->nama }}

                                    </div>

                                </td>


                                {{-- DESKRIPSI --}}

                                <td>

                                    @if($jenisJukir->deskripsi)

                                        <span class="text-muted">

                                            {{ \Illuminate\Support\Str::limit(
                                                $jenisJukir->deskripsi,
                                                60
                                            ) }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- JUMLAH Petugas --}}

                                <td class="text-center">

                                    <span class="badge text-bg-light border">

                                        {{ $jenisJukir->jukirs_count }}

                                    </span>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if($jenisJukir->status)

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
                                            href="{{ route('admin.jenis-jukir.show', $jenisJukir) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Detail"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>


                                        {{-- EDIT --}}

                                        <a
                                            href="{{ route('admin.jenis-jukir.edit', $jenisJukir) }}"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Edit"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>


                                        {{-- HAPUS --}}

                                      <button
    type="button"
    class="btn btn-sm btn-outline-danger btn-delete-jenis-jukir"
    title="Hapus"
    data-bs-toggle="modal"
    data-bs-target="#deleteJenisJukirModal"
    data-url="{{ route('admin.jenis-jukir.destroy', $jenisJukir) }}"
    data-nama="{{ $jenisJukir->nama }}"
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

            @if($jenisJukirs->hasPages())

                <div class="p-4 border-top">

                    {{ $jenisJukirs->links() }}

                </div>

            @endif


        @else

            {{-- EMPTY STATE --}}

            <div class="text-center py-5">

                <div
                    class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:70px;height:70px;"
                >

                    <i
                        class="bi bi-tags text-muted"
                        style="font-size:30px;"
                    ></i>

                </div>


                <h5 class="fw-semibold">

                    Data Jenis Petugas Belum Tersedia

                </h5>


                <p class="text-muted mb-4">

                    @if($search)

                        Data dengan kata kunci
                        <strong>"{{ $search }}"</strong>
                        tidak ditemukan.

                    @else

                        Belum ada jenis Petugas yang terdaftar.

                    @endif

                </p>


                @if($search)

                    <a
                        href="{{ route('admin.jenis-jukir.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali ke Semua Data
                    </a>

                @else

                    <a
                        href="{{ route('admin.jenis-jukir.create') }}"
                        class="btn btn-success"
                    >
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Jenis Petugas Pertama
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
    id="deleteJenisJukirModal"
    tabindex="-1"
    aria-labelledby="deleteJenisJukirModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            {{-- HEADER --}}

            <div class="modal-header">

                <h5
                    class="modal-title fw-bold"
                    id="deleteJenisJukirModalLabel"
                >

                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>

                    Hapus Jenis Petugas

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>



            {{-- BODY --}}

            <div class="modal-body">

                <p class="mb-2">

                    Apakah Anda yakin ingin menghapus jenis Petugas:

                </p>


                <div class="alert alert-danger mb-0">

                    <strong id="deleteJenisJukirName">

                        -

                    </strong>

                </div>


                <p class="text-muted small mt-3 mb-0">

                    Data yang sudah dihapus tidak dapat dikembalikan.

                    Jika jenis Petugas ini masih digunakan oleh data Petugas,
                    sistem tidak akan mengizinkan penghapusan.

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
                    id="deleteJenisJukirForm"
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
        '.btn-delete-jenis-jukir'
    );

    const deleteForm = document.getElementById(
        'deleteJenisJukirForm'
    );

    const deleteName = document.getElementById(
        'deleteJenisJukirName'
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