@extends('layouts.admin')

@section('title', 'Tambah Jenis Retribusi (Parkir)')

@section('page-title', 'Tambah Jenis Retribusi (Parkir)')


@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Tambah Jenis Sumber Pendapatan
        </h4>

        <p class="text-muted mb-0">
            Tambahkan master data jenis sumber pendapatan untuk objek pendapatan.
        </p>

    </div>


    <a
        href="{{ route('admin.jenis-parkir.index') }}"
        class="btn btn-outline-secondary"
    >

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>



{{-- ==========================================================
    VALIDATION ERROR
========================================================== --}}

@if($errors->any())

    <div class="alert alert-danger alert-dismissible fade show" role="alert">

        <div class="fw-semibold mb-2">

            <i class="bi bi-exclamation-triangle me-2"></i>

            Terdapat kesalahan pada data yang dimasukkan.

        </div>


        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>

    </div>

@endif



{{-- ==========================================================
    FORM
========================================================== --}}

<form
    action="{{ route('admin.jenis-parkir.store') }}"
    method="POST"
>

    @csrf


    <div class="card">

        {{-- ======================================================
            HEADER
        ======================================================= --}}

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-signpost-2 me-2 text-success"></i>

                Informasi Jenis Sumber Pendapatan

            </h6>

        </div>



        {{-- ======================================================
            BODY
        ======================================================= --}}

        <div class="card-body">

            <div class="row g-4">


                {{-- ==================================================
                    KODE
                =================================================== --}}

                <div class="col-md-6">

                    <label
                        for="kode"
                        class="form-label fw-semibold"
                    >

                        Kode Jenis Sumber Pendapatan

                        <span class="text-danger">
                            *
                        </span>

                    </label>


                    <input
                        type="text"
                        id="kode"
                        name="kode"
                        class="form-control @error('kode') is-invalid @enderror"
                        value="{{ old('kode') }}"
                        placeholder="Contoh: R-PJTU"
                        maxlength="20"
                        required
                        autofocus
                    >


                    @error('kode')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                    <div class="form-text">

                        Kode harus unik dan maksimal 20 karakter.

                    </div>

                </div>



                {{-- ==================================================
                    NAMA
                =================================================== --}}

                <div class="col-md-6">

                    <label
                        for="nama"
                        class="form-label fw-semibold"
                    >

                        Nama Jenis Sumber Pendapatan

                        <span class="text-danger">
                            *
                        </span>

                    </label>


                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}"
                        placeholder="Contoh: Parkir Tepi Jalan Umum"
                        maxlength="255"
                        required
                    >


                    @error('nama')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                {{-- ==================================================
                    DESKRIPSI
                =================================================== --}}

                <div class="col-12">

                    <label
                        for="deskripsi"
                        class="form-label fw-semibold"
                    >

                        Deskripsi

                    </label>


                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="5"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        placeholder="Masukkan deskripsi jenis parkir..."
                    >{{ old('deskripsi') }}</textarea>


                    @error('deskripsi')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                    <div class="form-text">

                        Deskripsi bersifat opsional.

                    </div>

                </div>



                {{-- ==================================================
                    STATUS
                =================================================== --}}

                <div class="col-md-6">

                    <label
                        for="status"
                        class="form-label fw-semibold"
                    >

                        Status

                        <span class="text-danger">
                            *
                        </span>

                    </label>


                    <select
                        id="status"
                        name="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >

                        <option
                            value="1"
                            @selected(old('status', '1') === '1')
                        >
                            Aktif
                        </option>


                        <option
                            value="0"
                            @selected(old('status') === '0')
                        >
                            Nonaktif
                        </option>

                    </select>


                    @error('status')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                    <div class="form-text">

                        Jenis parkir aktif dapat digunakan pada Titik Parkir.

                    </div>

                </div>

            </div>

        </div>



        {{-- ======================================================
            FOOTER
        ======================================================= --}}

        <div class="card-footer bg-white border-top">

            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('admin.jenis-parkir.index') }}"
                    class="btn btn-light border"
                >

                    <i class="bi bi-x-circle me-1"></i>

                    Batal

                </a>


                <button
                    type="submit"
                    class="btn btn-success"
                >

                    <i class="bi bi-save me-1"></i>

                    Simpan Jenis Parkir

                </button>

            </div>

        </div>

    </div>

</form>

@endsection