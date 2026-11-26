@extends('layouts.admin')

@section('title', 'Data Petugas')

@section('page-title', 'Data Petugas')


@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Data Petugas
        </h4>

        <p class="text-muted mb-0">
            Kelola data Petugas Kabupaten Sinjai.
        </p>

    </div>


    <a
        href="{{ route('admin.jukir.create') }}"
        class="btn btn-success"
    >
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Petugas
    </a>

</div>



{{-- ==========================================================
    SEARCH & FILTER
========================================================== --}}

<div class="card mb-4">

    <div class="card-body">

        <form
            action="{{ route('admin.jukir.index') }}"
            method="GET"
        >

            <div class="row g-3 align-items-end">

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Cari Data Petugas
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white">

                            <i class="bi bi-search"></i>

                        </span>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari nama, NIK, atau kode Petugas..."
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
                            href="{{ route('admin.jukir.index') }}"
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
    TABLE Petugas
========================================================== --}}

<div class="card">

    <div class="card-body p-0">


        {{-- HEADER --}}

        <div class="d-flex justify-content-between align-items-center p-4 border-bottom">

            <div>

                <h6 class="mb-1 fw-bold">

                    Daftar Petugas

                </h6>

                <small class="text-muted">

                    Total:
                    {{ $jukirs->total() }}
                    data Petugas

                </small>

            </div>

        </div>



        @if($jukirs->count())

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="ps-4">
                                No
                            </th>

                            <th>
                                Petugas
                            </th>

                            <th class="text-center">
                                NIK
                            </th>

                            <th class="text-center">
                                Jenis
                            </th>

                            <th>
                                Wilayah
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

                        @foreach($jukirs as $jukir)

                            <tr>

                                {{-- NOMOR --}}

                                <td class="ps-4 text-muted">

                                    {{
                                        $jukirs->firstItem()
                                        +
                                        $loop->index
                                    }}

                                </td>



                                {{-- IDENTITAS Petugas --}}

                                <td>

                                    <div class="d-flex align-items-center gap-3">


                                        {{-- FOTO --}}

                                        @if($jukir->foto)

                                            <img
                                                src="{{ asset('storage/' . $jukir->foto) }}"
                                                alt="{{ $jukir->nama }}"
                                                class="rounded-circle object-fit-cover"
                                                width="48"
                                                height="48"
                                            >

                                        @else

                                            <div
                                                class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center fw-bold"
                                                style="width:48px;height:48px;"
                                            >

                                                {{ strtoupper(substr($jukir->nama, 0, 1)) }}

                                            </div>

                                        @endif


                                        <div>

                                            <div class="fw-semibold">

                                                {{ $jukir->nama }}

                                            </div>


                                            <small class="text-muted">

                                                {{ $jukir->kode_jukir }}

                                            </small>

                                        </div>

                                    </div>

                                </td>



                                {{-- NIK --}}

                                <td class="text-center">

                                    <span class="font-monospace">

                                        {{ $jukir->nik }}

                                    </span>

                                </td>



                                {{-- JENIS Petugas --}}

                                <td class="text-center">

                                    @if($jukir->jenisJukir)

                                        <span class="badge text-bg-light border">

                                            {{ $jukir->jenisJukir->nama }}

                                        </span>

                                    @else

                                        <span class="text-muted">

                                            -

                                        </span>

                                    @endif

                                </td>



                                {{-- WILAYAH --}}

                                <td>

                                    <div class="small fw-semibold">

                                        {{ $jukir->kecamatan?->nama ?? '-' }}

                                    </div>


                                    <small class="text-muted">

                                        {{ $jukir->kelurahan?->nama ?? '-' }}

                                    </small>

                                </td>



                                {{-- STATUS --}}

                                <td>

                                    @if($jukir->status === 'aktif')

                                        <span class="badge bg-success">

                                            Aktif

                                        </span>

                                    @elseif($jukir->status === 'nonaktif')

                                        <span class="badge bg-secondary">

                                            Nonaktif

                                        </span>

                                    @elseif($jukir->status === 'ditangguhkan')

                                        <span class="badge bg-warning text-dark">

                                            Ditangguhkan

                                        </span>

                                    @elseif($jukir->status === 'berhenti')

                                        <span class="badge bg-danger">

                                            Berhenti

                                        </span>

                                    @endif

                                </td>



                                {{-- AKSI --}}

                                <td class="text-center pe-4">

                                    <div class="btn-group">


                                        {{-- DETAIL --}}

                                        <a
                                            href="{{ route('admin.jukir.show', $jukir) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Detail"
                                        >

                                            <i class="bi bi-eye"></i>

                                        </a>



                                        {{-- EDIT --}}

                                        <a
                                            href="{{ route('admin.jukir.edit', $jukir) }}"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Edit"
                                        >

                                            <i class="bi bi-pencil-square"></i>

                                        </a>



                                    {{-- HAPUS --}}

<button
    type="button"
    class="btn btn-sm btn-outline-danger btn-delete-jukir"
    title="Hapus"
    data-bs-toggle="modal"
    data-bs-target="#deleteJukirModal"
    data-url="{{ route('admin.jukir.destroy', $jukir) }}"
    data-nama="{{ $jukir->nama }}"
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

            @if($jukirs->hasPages())

                <div class="p-4 border-top">

                    {{ $jukirs->links() }}

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
                        class="bi bi-person-badge text-muted"
                        style="font-size:30px;"
                    ></i>

                </div>


                <h5 class="fw-semibold">

                    Data Petugas Belum Tersedia

                </h5>


                <p class="text-muted mb-4">

                    @if($search)

                        Data Petugas dengan kata kunci
                        <strong>"{{ $search }}"</strong>
                        tidak ditemukan.

                    @else

                        Belum ada data Petugas yang terdaftar.

                    @endif

                </p>


                @if($search)

                    <a
                        href="{{ route('admin.jukir.index') }}"
                        class="btn btn-outline-secondary"
                    >

                        <i class="bi bi-arrow-left me-1"></i>

                        Kembali ke Semua Data

                    </a>

                @else

                    <a
                        href="{{ route('admin.jukir.create') }}"
                        class="btn btn-success"
                    >

                        <i class="bi bi-plus-circle me-1"></i>

                        Tambah Petugas Pertama

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
    id="deleteJukirModal"
    tabindex="-1"
    aria-labelledby="deleteJukirModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5
                    class="modal-title fw-bold"
                    id="deleteJukirModalLabel"
                >

                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>

                    Hapus Data Petugas

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                <p class="mb-2">

                    Apakah Anda yakin ingin menghapus data Petugas:

                </p>

                <div class="alert alert-danger mb-0">

                    <strong id="deleteJukirName">
                        -
                    </strong>

                </div>

                <p class="text-muted small mt-3 mb-0">

                    Data yang sudah dihapus tidak dapat dikembalikan.
                    Foto Petugas dan foto KTP yang terkait juga akan dihapus.

                </p>

            </div>


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
                    id="deleteJukirForm"
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

    const deleteButtons =
        document.querySelectorAll('.btn-delete-jukir');

    const deleteForm =
        document.getElementById('deleteJukirForm');

    const deleteName =
        document.getElementById('deleteJukirName');


    deleteButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const url =
                this.dataset.url;

            const nama =
                this.dataset.nama;


            deleteForm.action = url;

            deleteName.textContent = nama;

        });

    });

});

</script>

@endpush