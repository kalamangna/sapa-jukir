@extends('layouts.admin')

@section('title', 'Tambah Jenis Petugas')

@section('page-title', 'Tambah Jenis Petugas')


@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Tambah Jenis Petugas
        </h4>

        <p class="text-muted mb-0">
            Tambahkan master data jenis Petugas baru.
        </p>

    </div>


    <a
        href="{{ route('admin.jenis-jukir.index') }}"
        class="btn btn-outline-secondary"
    >

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>



<form
    action="{{ route('admin.jenis-jukir.store') }}"
    method="POST"
>

    @csrf


    <div class="card">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-tags me-2 text-success"></i>

                Informasi Jenis Petugas

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-4">


                {{-- ======================================================
                    KODE
                ======================================================= --}}

                <div class="col-md-6">

                    <label
                        for="kode"
                        class="form-label fw-semibold"
                    >

                        Kode Jenis Petugas

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
                        placeholder="Contoh: JNS-001"
                        maxlength="20"
                        required
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



                {{-- ======================================================
                    NAMA
                ======================================================= --}}

                <div class="col-md-6">

                    <label
                        for="nama"
                        class="form-label fw-semibold"
                    >

                        Nama Jenis Petugas

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
                        placeholder="Contoh: Petugas Resmi"
                        required
                    >


                    @error('nama')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                {{-- ======================================================
                    DESKRIPSI
                ======================================================= --}}

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
                        placeholder="Masukkan deskripsi jenis Petugas..."
                    >{{ old('deskripsi') }}</textarea>


                    @error('deskripsi')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                {{-- ======================================================
                    STATUS
                ======================================================= --}}

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

                        <option value="1"
                            @selected(old('status', '1') == '1')
                        >
                            Aktif
                        </option>

                        <option value="0"
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

                        Jenis Petugas yang aktif dapat digunakan pada data Petugas.

                    </div>

                </div>

            </div>

        </div>



        {{-- ==========================================================
            ACTION
        =========================================================== --}}

        <div class="card-footer bg-white border-top">

            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('admin.jenis-jukir.index') }}"
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

                    Simpan Jenis Petugas

                </button>

            </div>

        </div>

    </div>

</form>

@endsection