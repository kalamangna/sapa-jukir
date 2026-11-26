@extends('layouts.admin')

@section('title', 'Tambah Petugas')

@section('page-title', 'Tambah Petugas')


@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <h4 class="mb-1 fw-bold">
            Tambah Petugas
        </h4>

        <p class="text-muted mb-0">
            Tambahkan data Petugas baru ke dalam sistem.
        </p>

    </div>

    <a
        href="{{ route('admin.jukir.index') }}"
        class="btn btn-outline-secondary"
    >
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </a>

</div>


<form
    action="{{ route('admin.jukir.store') }}"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf


    {{-- ==========================================================
        INFORMASI UTAMA
    ========================================================== --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-person-vcard me-2 text-success"></i>

                Informasi Utama

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-3">


                {{-- JENIS Petugas --}}

                <div class="col-md-6">

                    <label
                        for="jenis_jukir_id"
                        class="form-label fw-semibold"
                    >

                        Jenis Petugas
                        <span class="text-danger">*</span>

                    </label>

                    <div class="d-flex align-items-center gap-2">

                        <select
                            name="jenis_jukir_id"
                            id="jenis_jukir_id"
                            class="form-select @error('jenis_jukir_id') is-invalid @enderror"
                            required
                        >

                            <option value="">
                                -- Pilih Jenis Petugas --
                            </option>

                            @foreach($jenisJukirs as $jenisJukir)

                                <option
                                    value="{{ $jenisJukir->id }}"
                                    @selected(old('jenis_jukir_id') == $jenisJukir->id)
                                >

                                    {{ $jenisJukir->nama }}

                                </option>

                            @endforeach

                        </select>

                        <a
                            href="{{ route('admin.jenis-jukir.create') }}"
                            class="btn btn-outline-primary btn-sm flex-shrink-0"
                            title="Tambah Jenis Petugas"
                        >
                            <i class="bi bi-plus-lg me-1"></i>
                            Tambah
                        </a>

                    </div>


                    @error('jenis_jukir_id')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- STATUS --}}

                <div class="col-md-6">

                    <label
                        for="status"
                        class="form-label fw-semibold"
                    >

                        Status
                        <span class="text-danger">*</span>

                    </label>


                    <select
                        name="status"
                        id="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >

                        <option value="aktif"
                            @selected(old('status', 'aktif') === 'aktif')
                        >
                            Aktif
                        </option>

                        <option value="nonaktif"
                            @selected(old('status') === 'nonaktif')
                        >
                            Nonaktif
                        </option>

                        <option value="ditangguhkan"
                            @selected(old('status') === 'ditangguhkan')
                        >
                            Ditangguhkan
                        </option>

                        <option value="berhenti"
                            @selected(old('status') === 'berhenti')
                        >
                            Berhenti
                        </option>

                    </select>


                    @error('status')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- NIK --}}

                <div class="col-md-6">

                    <label
                        for="nik"
                        class="form-label fw-semibold"
                    >

                        NIK
                        <span class="text-danger">*</span>

                    </label>


                    <input
                        type="text"
                        name="nik"
                        id="nik"
                        class="form-control @error('nik') is-invalid @enderror"
                        value="{{ old('nik') }}"
                        maxlength="16"
                        inputmode="numeric"
                        placeholder="Masukkan 16 digit NIK"
                        required
                    >


                    @error('nik')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- NAMA --}}

                <div class="col-md-6">

                    <label
                        for="nama"
                        class="form-label fw-semibold"
                    >

                        Nama Lengkap
                        <span class="text-danger">*</span>

                    </label>


                    <input
                        type="text"
                        name="nama"
                        id="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
                        required
                    >


                    @error('nama')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

            </div>

        </div>

    </div>



    {{-- ==========================================================
        DATA KELAHIRAN
    ========================================================== --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-calendar-event me-2 text-success"></i>

                Data Kelahiran

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-3">


                {{-- TEMPAT LAHIR --}}

                <div class="col-md-4">

                    <label
                        for="tempat_lahir"
                        class="form-label fw-semibold"
                    >

                        Tempat Lahir

                    </label>


                    <input
                        type="text"
                        name="tempat_lahir"
                        id="tempat_lahir"
                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                        value="{{ old('tempat_lahir') }}"
                        placeholder="Contoh: Sinjai"
                    >


                    @error('tempat_lahir')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- TANGGAL LAHIR --}}

                <div class="col-md-4">

                    <label
                        for="tanggal_lahir"
                        class="form-label fw-semibold"
                    >

                        Tanggal Lahir

                    </label>


                    <input
                        type="date"
                        name="tanggal_lahir"
                        id="tanggal_lahir"
                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir') }}"
                    >


                    @error('tanggal_lahir')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- JENIS KELAMIN --}}

                <div class="col-md-4">

                    <label
                        for="jenis_kelamin"
                        class="form-label fw-semibold"
                    >

                        Jenis Kelamin

                    </label>


                    <select
                        name="jenis_kelamin"
                        id="jenis_kelamin"
                        class="form-select @error('jenis_kelamin') is-invalid @enderror"
                    >

                        <option value="">
                            -- Pilih Jenis Kelamin --
                        </option>

                        <option
                            value="L"
                            @selected(old('jenis_kelamin') === 'L')
                        >
                            Laki-laki
                        </option>

                        <option
                            value="P"
                            @selected(old('jenis_kelamin') === 'P')
                        >
                            Perempuan
                        </option>

                    </select>


                    @error('jenis_kelamin')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

            </div>

        </div>

    </div>



    {{-- ==========================================================
        ALAMAT DAN WILAYAH
    ========================================================== --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-geo-alt me-2 text-success"></i>

                Alamat dan Wilayah

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-3">


                {{-- ALAMAT --}}

                <div class="col-12">

                    <label
                        for="alamat"
                        class="form-label fw-semibold"
                    >

                        Alamat

                    </label>


                    <textarea
                        name="alamat"
                        id="alamat"
                        rows="3"
                        class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Masukkan alamat lengkap"
                    >{{ old('alamat') }}</textarea>


                    @error('alamat')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- KECAMATAN --}}

                <div class="col-md-6">

                    <label
                        for="kecamatan_id"
                        class="form-label fw-semibold"
                    >

                        Kecamatan

                    </label>


                    <select
                        name="kecamatan_id"
                        id="kecamatan_id"
                        class="form-select @error('kecamatan_id') is-invalid @enderror"
                    >

                        <option value="">
                            -- Pilih Kecamatan --
                        </option>

                        @foreach($kecamatans as $kecamatan)

                            <option
                                value="{{ $kecamatan->id }}"
                                @selected(old('kecamatan_id') == $kecamatan->id)
                            >

                                {{ $kecamatan->nama }}

                            </option>

                        @endforeach

                    </select>


                    @error('kecamatan_id')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- KELURAHAN --}}

                <div class="col-md-6">

                    <label
                        for="kelurahan_id"
                        class="form-label fw-semibold"
                    >

                        Kelurahan

                    </label>


                    <select
                        name="kelurahan_id"
                        id="kelurahan_id"
                        class="form-select @error('kelurahan_id') is-invalid @enderror"
                    >

                        <option value="">
                            -- Pilih Kelurahan --
                        </option>

                        @foreach($kelurahans as $kelurahan)

                            <option
                                value="{{ $kelurahan->id }}"
                                data-kecamatan="{{ $kelurahan->kecamatan_id }}"
                                @selected(old('kelurahan_id') == $kelurahan->id)
                            >

                                {{ $kelurahan->nama }}

                            </option>

                        @endforeach

                    </select>


                    @error('kelurahan_id')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- NOMOR HP --}}

                <div class="col-md-6">

                    <label
                        for="no_hp"
                        class="form-label fw-semibold"
                    >

                        Nomor HP

                    </label>


                    <input
                        type="text"
                        name="no_hp"
                        id="no_hp"
                        class="form-control @error('no_hp') is-invalid @enderror"
                        value="{{ old('no_hp') }}"
                        maxlength="20"
                        inputmode="tel"
                        placeholder="Contoh: 081234567890"
                    >


                    @error('no_hp')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

            </div>

        </div>

    </div>



    {{-- ==========================================================
        DOKUMEN
    ========================================================== --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-folder me-2 text-success"></i>

                Dokumen dan Foto

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-4">


                {{-- FOTO Petugas --}}

                <div class="col-md-6">

                    <label
                        for="foto"
                        class="form-label fw-semibold"
                    >

                        Foto Petugas

                    </label>


                    <input
                        type="file"
                        name="foto"
                        id="foto"
                        class="form-control @error('foto') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp,image/*"
                    >


                    <div class="form-text">

                        Format: JPG, JPEG, PNG, WEBP.
                        Maksimal 2 MB.

                    </div>


                    @error('foto')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- FOTO KTP --}}

                <div class="col-md-6">

                    <label
                        for="foto_ktp"
                        class="form-label fw-semibold"
                    >

                        Foto KTP

                    </label>


                    <input
                        type="file"
                        name="foto_ktp"
                        id="foto_ktp"
                        class="form-control @error('foto_ktp') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp,image/*"
                    >


                    <div class="form-text">

                        Format: JPG, JPEG, PNG, WEBP.
                        Maksimal 2 MB.

                    </div>


                    @error('foto_ktp')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- DOKUMEN PENDUKUNG --}}

                <div class="col-md-6">

                    <label for="dokumen_pendukung" class="form-label fw-semibold">
                        Dokumen Pendukung
                    </label>

                    <input
                        type="file"
                        name="dokumen_pendukung"
                        id="dokumen_pendukung"
                        class="form-control @error('dokumen_pendukung') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp,.pdf,image/*,application/pdf"
                    >

                    <div class="form-text">
                        Format: JPG, JPEG, PNG, WEBP, PDF. Maksimal 5 MB.
                    </div>

                    @error('dokumen_pendukung')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>


                <div class="col-md-6">

                    <label
                        for="nomor_kartu"
                        class="form-label fw-semibold"
                    >

                        Nomor Kartu

                    </label>


                    <input
                        type="text"
                        name="nomor_kartu"
                        id="nomor_kartu"
                        class="form-control @error('nomor_kartu') is-invalid @enderror"
                        value="{{ old('nomor_kartu') }}"
                        placeholder="Masukkan nomor kartu Petugas"
                    >


                    @error('nomor_kartu')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

            </div>

        </div>

    </div>



    {{-- ==========================================================
        MASA BERLAKU
    ========================================================== --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-calendar-check me-2 text-success"></i>

                Masa Berlaku dan Keterangan

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-3">


                {{-- TANGGAL TERDAFTAR --}}

                <div class="col-md-6">

                    <label
                        for="tanggal_terdaftar"
                        class="form-label fw-semibold"
                    >

                        Tanggal Terdaftar

                    </label>


                    <input
                        type="date"
                        name="tanggal_terdaftar"
                        id="tanggal_terdaftar"
                        class="form-control @error('tanggal_terdaftar') is-invalid @enderror"
                        value="{{ old('tanggal_terdaftar') }}"
                    >


                    @error('tanggal_terdaftar')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- TANGGAL BERAKHIR --}}

                <div class="col-md-6">

                    <label
                        for="tanggal_berakhir"
                        class="form-label fw-semibold"
                    >

                        Tanggal Berakhir

                    </label>


                    <input
                        type="date"
                        name="tanggal_berakhir"
                        id="tanggal_berakhir"
                        class="form-control @error('tanggal_berakhir') is-invalid @enderror"
                        value="{{ old('tanggal_berakhir') }}"
                    >


                    @error('tanggal_berakhir')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- KETERANGAN --}}

                <div class="col-12">

                    <label
                        for="keterangan"
                        class="form-label fw-semibold"
                    >

                        Keterangan

                    </label>


                    <textarea
                        name="keterangan"
                        id="keterangan"
                        rows="4"
                        class="form-control @error('keterangan') is-invalid @enderror"
                        placeholder="Tambahkan keterangan jika diperlukan..."
                    >{{ old('keterangan') }}</textarea>


                    @error('keterangan')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>

            </div>

        </div>

    </div>



    {{-- ==========================================================
        BUTTON
    ========================================================== --}}

    <div class="card mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('admin.jukir.index') }}"
                    class="btn btn-light border"
                >

                    <i class="bi bi-x-circle me-1"></i>

                    Batal

                </a>


                <button
                    type="submit"
                    class="btn btn-success px-4"
                >

                    <i class="bi bi-save me-1"></i>

                    Simpan Data Petugas

                </button>

            </div>

        </div>

    </div>

</form>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const kecamatanSelect = document.getElementById('kecamatan_id');
    const kelurahanSelect = document.getElementById('kelurahan_id');

    const filterKelurahan = function () {

        const kecamatanId = kecamatanSelect.value;

        Array.from(kelurahanSelect.options).forEach(function (option) {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const optionKecamatanId =
                option.dataset.kecamatan;

            option.hidden =
                kecamatanId &&
                optionKecamatanId !== kecamatanId;

        });

        const selectedOption =
            kelurahanSelect.options[
                kelurahanSelect.selectedIndex
            ];

        if (
            selectedOption &&
            selectedOption.value &&
            kecamatanId &&
            selectedOption.dataset.kecamatan !== kecamatanId
        ) {

            kelurahanSelect.value = '';

        }

    };


    kecamatanSelect.addEventListener(
        'change',
        filterKelurahan
    );


    filterKelurahan();


    /*
    |--------------------------------------------------------------------------
    | NIK HANYA ANGKA
    |--------------------------------------------------------------------------
    */

    const nikInput = document.getElementById('nik');

    nikInput.addEventListener('input', function () {

        this.value =
            this.value.replace(/\D/g, '').slice(0, 16);

    });


    /*
    |--------------------------------------------------------------------------
    | NOMOR HP
    |--------------------------------------------------------------------------
    */

    const noHpInput = document.getElementById('no_hp');

    noHpInput.addEventListener('input', function () {

        this.value =
            this.value.replace(/[^\d+]/g, '');

    });

});

</script>

@endpush