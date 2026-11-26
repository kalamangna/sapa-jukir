@extends('layouts.admin')

@section('title', 'Edit Tarif')

@section('page-title', 'Edit Tarif')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>
        <h4 class="mb-1 fw-bold">
            Edit Tarif Retribusi
        </h4>

        <p class="text-muted mb-0">
            Perbarui data tarif retribusi.
        </p>
    </div>

    <div class="d-flex gap-2">

        <a
            href="{{ route('admin.tarif.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>

        <a
            href="{{ route('admin.tarif.show', $tarif) }}"
            class="btn btn-outline-primary"
        >
            <i class="bi bi-eye me-1"></i>
            Detail
        </a>

    </div>

</div>


{{-- ==========================================================
    FORM
========================================================== --}}

<form
    action="{{ route('admin.tarif.update', $tarif) }}"
    method="POST"
>

    @csrf

    @method('PUT')


    {{-- ======================================================
        INFORMASI TARIF
    ======================================================= --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-cash-stack me-2 text-success"></i>

                Informasi Tarif

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-4">


                {{-- JENIS RETRIBUSI --}}

                <div class="col-md-6">

                    <label
                        for="jenis_parkir_id"
                        class="form-label fw-semibold"
                    >

                        Jenis Retribusi

                        <span class="text-danger">*</span>

                    </label>


                    <select
                        id="jenis_parkir_id"
                        name="jenis_parkir_id"
                        class="form-select @error('jenis_parkir_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Pilih jenis retribusi
                        </option>


                        @foreach($jenisParkirs as $jenisParkir)

                            <option
                                value="{{ $jenisParkir->id }}"
                                @selected(
                                    old(
                                        'jenis_parkir_id',
                                        $tarif->jenis_parkir_id
                                    ) == $jenisParkir->id
                                )
                            >

                                {{ $jenisParkir->nama }}

                                @if($jenisParkir->kode)
                                    ({{ $jenisParkir->kode }})
                                @endif

                            </option>

                        @endforeach

                    </select>


                    @error('jenis_parkir_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- JENIS KENDARAAN --}}

                <div class="col-md-6">

                    <label
                        for="jenis_kendaraan"
                        class="form-label fw-semibold"
                    >

                        Jenis Kendaraan

                        <span class="text-danger">*</span>

                    </label>


                    <select
                        id="jenis_kendaraan"
                        name="jenis_kendaraan"
                        class="form-select @error('jenis_kendaraan') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Pilih jenis kendaraan
                        </option>


                        <option
                            value="motor"
                            @selected(
                                old(
                                    'jenis_kendaraan',
                                    $tarif->jenis_kendaraan
                                ) === 'motor'
                            )
                        >
                            Motor
                        </option>


                        <option value="mobil_kecil" @selected(old('jenis_kendaraan', $tarif->jenis_kendaraan) === 'mobil_kecil')>Mobil kecil</option>
                        <option value="mobil_besar" @selected(old('jenis_kendaraan', $tarif->jenis_kendaraan) === 'mobil_besar')>Mobil besar</option>


                        <option
                            value="lainnya"
                            @selected(
                                old(
                                    'jenis_kendaraan',
                                    $tarif->jenis_kendaraan
                                ) === 'lainnya'
                            )
                        >
                            Lainnya
                        </option>

                    </select>


                    @error('jenis_kendaraan')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- NOMINAL --}}

                <div class="col-md-6">

                    <label
                        for="nominal"
                        class="form-label fw-semibold"
                    >

                        Nominal Tarif

                        <span class="text-danger">*</span>

                    </label>


                    <div class="input-group">

                        <span class="input-group-text">
                            Rp
                        </span>


                        <input
                            type="number"
                            id="nominal"
                            name="nominal"
                            class="form-control @error('nominal') is-invalid @enderror"
                            value="{{ old('nominal', $tarif->nominal) }}"
                            min="0"
                            step="0.01"
                            required
                        >

                    </div>


                    @error('nominal')

                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="form-text">
                        Masukkan nominal tarif dalam Rupiah.
                    </div>

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
                        id="status"
                        name="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >

                        <option
                            value="1"
                            @selected(
                                old('status', $tarif->status) == true
                            )
                        >
                            Aktif
                        </option>


                        <option
                            value="0"
                            @selected(
                                old('status', $tarif->status) == false
                            )
                        >
                            Nonaktif
                        </option>

                    </select>


                    @error('status')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

        </div>

    </div>



    {{-- ======================================================
        MASA BERLAKU
    ======================================================= --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-calendar-range me-2 text-success"></i>

                Masa Berlaku Tarif

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-4">


                {{-- BERLAKU MULAI --}}

                <div class="col-md-6">

                    <label
                        for="berlaku_mulai"
                        class="form-label fw-semibold"
                    >

                        Berlaku Mulai

                    </label>


                    <input
                        type="date"
                        id="berlaku_mulai"
                        name="berlaku_mulai"
                        class="form-control @error('berlaku_mulai') is-invalid @enderror"
                        value="{{ old(
                            'berlaku_mulai',
                            $tarif->berlaku_mulai?->format('Y-m-d')
                        ) }}"
                    >


                    @error('berlaku_mulai')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- BERLAKU SAMPAI --}}

                <div class="col-md-6">

                    <label
                        for="berlaku_sampai"
                        class="form-label fw-semibold"
                    >

                        Berlaku Sampai

                    </label>


                    <input
                        type="date"
                        id="berlaku_sampai"
                        name="berlaku_sampai"
                        class="form-control @error('berlaku_sampai') is-invalid @enderror"
                        value="{{ old(
                            'berlaku_sampai',
                            $tarif->berlaku_sampai?->format('Y-m-d')
                        ) }}"
                    >


                    @error('berlaku_sampai')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="form-text">
                        Kosongkan jika tarif tidak memiliki batas akhir.
                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ======================================================
        KETERANGAN
    ======================================================= --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-chat-left-text me-2 text-success"></i>

                Keterangan

            </h6>

        </div>


        <div class="card-body">

            <label
                for="keterangan"
                class="form-label fw-semibold"
            >

                Keterangan

            </label>


            <textarea
                id="keterangan"
                name="keterangan"
                rows="4"
                class="form-control @error('keterangan') is-invalid @enderror"
                placeholder="Contoh: Tarif berlaku harian"
            >{{ old('keterangan', $tarif->keterangan) }}</textarea>


            @error('keterangan')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

    </div>



    {{-- ======================================================
        FOOTER
    ======================================================= --}}

    <div class="card">

        <div class="card-footer bg-white border-top">

            <div class="d-flex justify-content-between align-items-center">

                <div class="text-muted small">

                    <i class="bi bi-info-circle me-1"></i>

                    Pastikan perubahan data tarif sudah benar.

                </div>


                <div class="d-flex gap-2">

                    <a
                        href="{{ route('admin.tarif.index') }}"
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

                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </div>

    </div>

</form>

@endsection