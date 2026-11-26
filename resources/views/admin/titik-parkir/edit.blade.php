@extends('layouts.admin')

@section('title', 'Edit Titik/Objek Pendapatan')

@section('page-title', 'Edit Titik/Objek Pendapatan')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>


        <h4 class="mb-1 fw-bold">
            Edit Titik/Objek Pendapatan
        </h4>

        <p class="text-muted mb-0">
            Perbarui data titik atau objek pendapatan yang sudah ada.
        </p>

    </div>


    <div class="d-flex gap-2">

        <a
            href="{{ route('admin.titik-parkir.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Kembali

        </a>


        <a
            href="{{ route('admin.titik-parkir.show', $titikParkir) }}"
            class="btn btn-outline-primary"
        >

            <i class="bi bi-eye me-1"></i>

            Detail

        </a>

    </div>

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
    action="{{ route('admin.titik-parkir.update', $titikParkir) }}"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf

    @method('PUT')


    {{-- ======================================================
        INFORMASI UTAMA
    ======================================================= --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-geo-alt me-2 text-success"></i>

                Informasi Titik/Objek Pendapatan
        <div class="card-body">

            <div class="row g-4">


                {{-- KODE TITIK --}}

                <div class="col-md-6">

                    <label
                        for="kode_titik"
                        class="form-label fw-semibold"
                    >

                        Kode Titik/Objek

                    </label>


                    <input
                        type="text"
                        id="kode_titik"
                        name="kode_titik"
                        class="form-control @error('kode_titik') is-invalid @enderror"
                        value="{{ old('kode_titik', $titikParkir->kode_titik) }}"
                        placeholder="Contoh: TP-001"
                        maxlength="50"
                        required
                        autofocus
                    >


                    @error('kode_titik')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="form-text">
                        Kode titik harus unik.
                    </div>

                </div>



                {{-- NAMA --}}

                <div class="col-md-6">

                    <label
                        for="nama"
                        class="form-label fw-semibold"
                    >

                        Nama Titik/Objek Pendapatan

                        <span class="text-danger">*</span>

                    </label>


                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $titikParkir->nama) }}"
                        placeholder="Contoh: Parkir Pasar Sentral atau Pelataran Terminal"
                        maxlength="255"
                        required
                    >


                    @error('nama')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- ALAMAT --}}

                <div class="col-12">

                    <label
                        for="alamat"
                        class="form-label fw-semibold"
                    >

                        Alamat

                        <span class="text-danger">*</span>

                    </label>


                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="3"
                        class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Masukkan alamat lengkap titik/objek pendapatan..."
                        required
                    >{{ old('alamat', $titikParkir->alamat) }}</textarea>


                    @error('alamat')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- JENIS RETRIBUSI --}}

                <div class="col-md-6" id="jenis-parkir-wrapper">

                    <label
                        for="jenis_parkir_id"
                        class="form-label fw-semibold"
                    >

                        Jenis Retribusi

                    </label>


                    <select
                        id="jenis_parkir_id"
                        name="jenis_parkir_id"
                        class="form-select @error('jenis_parkir_id') is-invalid @enderror"
                    >

                        <option value="">
                            -- Pilih Jenis Retribusi --
                        </option>


                        @foreach($jenisParkirs as $jenisParkir)

                            <option
                                value="{{ $jenisParkir->id }}"
                                @selected(
                                    old(
                                        'jenis_parkir_id',
                                        $titikParkir->jenis_parkir_id
                                    ) == $jenisParkir->id
                                )
                            >

                                {{ $jenisParkir->nama }}
                                ({{ $jenisParkir->kode }})

                            </option>

                        @endforeach

                    </select>


                    @error('jenis_parkir_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                    <div class="form-text">Wajib diisi hanya untuk sumber pendapatan berbasis parkir.</div>

                </div>

                {{-- SUMBER PEMASUKAN --}}

                <div class="col-md-6">
                    <label for="sumber_pemasukan_id" class="form-label fw-semibold">Sumber Pendapatan <span class="text-danger">*</span></label>
                    <select id="sumber_pemasukan_id" name="sumber_pemasukan_id" class="form-select @error('sumber_pemasukan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Sumber Pendapatan --</option>
                        @foreach($sumberPemasukans as $sumberPemasukan)
                            <option
                                value="{{ $sumberPemasukan->id }}"
                                data-objek-type="{{ in_array($sumberPemasukan->kode, ['R-TKU', 'R-JASA-USAHA'], true) ? 'usaha' : 'parkir' }}"
                                @selected(old('sumber_pemasukan_id', $titikParkir->sumber_pemasukan_id) == $sumberPemasukan->id)
                            >
                                {{ $sumberPemasukan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('sumber_pemasukan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                            value="aktif"
                            @selected(
                                old('status', $titikParkir->status) === 'aktif'
                            )
                        >
                            Aktif
                        </option>


                        <option
                            value="nonaktif"
                            @selected(
                                old('status', $titikParkir->status) === 'nonaktif'
                            )
                        >
                            Nonaktif
                        </option>


                        <option
                            value="sementara"
                            @selected(
                                old('status', $titikParkir->status) === 'sementara'
                            )
                        >
                            Sementara
                        </option>


                        <option
                            value="bermasalah"
                            @selected(
                                old('status', $titikParkir->status) === 'bermasalah'
                            )
                        >
                            Bermasalah
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
        WILAYAH
    ======================================================= --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-map me-2 text-success"></i>

                Wilayah

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-4">


                {{-- KECAMATAN --}}

                <div class="col-md-6">

                    <label
                        for="kecamatan_id"
                        class="form-label fw-semibold"
                    >

                        Kecamatan

                        <span class="text-danger">*</span>

                    </label>


                    <select
                        id="kecamatan_id"
                        name="kecamatan_id"
                        class="form-select @error('kecamatan_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            -- Pilih Kecamatan --
                        </option>


                        @foreach($kecamatans as $kecamatan)

                            <option
                                value="{{ $kecamatan->id }}"
                                @selected(
                                    old(
                                        'kecamatan_id',
                                        $titikParkir->kecamatan_id
                                    ) == $kecamatan->id
                                )
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

                        Kelurahan / Desa

                        <span class="text-danger">*</span>

                    </label>


                    <select
                        id="kelurahan_id"
                        name="kelurahan_id"
                        class="form-select @error('kelurahan_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            -- Pilih Kelurahan / Desa --
                        </option>


                        @foreach($kelurahans as $kelurahan)

                            <option
                                value="{{ $kelurahan->id }}"
                                @selected(
                                    old(
                                        'kelurahan_id',
                                        $titikParkir->kelurahan_id
                                    ) == $kelurahan->id
                                )
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

            </div>

        </div>

    </div>



    {{-- ======================================================
        KOORDINAT
    ======================================================= --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-crosshair me-2 text-success"></i>

                Koordinat Lokasi

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-4">


                {{-- LATITUDE --}}

                <div class="col-md-6">

                    <label
                        for="latitude"
                        class="form-label fw-semibold"
                    >

                        Latitude

                    </label>


                    <input
                        type="number"
                        id="latitude"
                        name="latitude"
                        class="form-control @error('latitude') is-invalid @enderror"
                        value="{{ old('latitude', $titikParkir->latitude) }}"
                        placeholder="Contoh: -5.1245678"
                        step="any"
                    >


                    @error('latitude')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="form-text">

                        Nilai antara -90 sampai 90.

                    </div>

                </div>



                {{-- LONGITUDE --}}

                <div class="col-md-6">

                    <label
                        for="longitude"
                        class="form-label fw-semibold"
                    >

                        Longitude

                    </label>


                    <input
                        type="number"
                        id="longitude"
                        name="longitude"
                        class="form-control @error('longitude') is-invalid @enderror"
                        value="{{ old('longitude', $titikParkir->longitude) }}"
                        placeholder="Contoh: 120.2534567"
                        step="any"
                    >


                    @error('longitude')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="form-text">

                        Nilai antara -180 sampai 180.

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ======================================================
        KAPASITAS & POTENSI
    ======================================================= --}}

    <div class="card mb-4" id="capacity-card">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold" id="capacity-card-title">

                <i class="bi bi-bar-chart me-2 text-success"></i>

                Kapasitas & Potensi

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-4" id="business-capacity-fields" data-object-type="usaha" style="display: none;">

                <div class="col-md-6">

                    <label
                        for="jumlah_unit"
                        class="form-label fw-semibold"
                    >

                        Jumlah Unit

                    </label>

                    <input
                        type="number"
                        id="jumlah_unit"
                        name="jumlah_unit"
                        class="form-control @error('jumlah_unit') is-invalid @enderror"
                        value="{{ old('jumlah_unit', $titikParkir->jumlah_unit ?? 0) }}"
                        min="0"
                    >

                    @error('jumlah_unit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="form-text">
                        Jumlah kios, unit, atau ruang usaha yang tersedia.
                    </div>

                </div>

                <div class="col-md-6">

                    <label
                        for="luas_m2"
                        class="form-label fw-semibold"
                    >

                        Luas (m²)

                    </label>

                    <input
                        type="number"
                        id="luas_m2"
                        name="luas_m2"
                        class="form-control @error('luas_m2') is-invalid @enderror"
                        value="{{ old('luas_m2', $titikParkir->luas_m2 ?? 0) }}"
                        min="0"
                        step="0.01"
                    >

                    @error('luas_m2')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="form-text">
                        Luas area usaha dalam meter persegi.
                    </div>

                </div>

            </div>

            <div class="row g-4" id="parking-capacity-fields" data-object-type="parkir" style="display: flex;">

                {{-- KAPASITAS MOTOR --}}

                <div class="col-md-6">

                    <label
                        for="kapasitas_motor"
                        class="form-label fw-semibold"
                    >

                        Kapasitas Motor

                    </label>


                    <input
                        type="number"
                        id="kapasitas_motor"
                        name="kapasitas_motor"
                        class="form-control @error('kapasitas_motor') is-invalid @enderror"
                        value="{{ old('kapasitas_motor', $titikParkir->kapasitas_motor ?? 0) }}"
                        min="0"
                    >


                    @error('kapasitas_motor')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="form-text">
                        Perkiraan jumlah kendaraan motor.
                    </div>

                </div>



                {{-- KAPASITAS MOBIL --}}

                <div class="col-md-6">

                    <label
                        for="kapasitas_mobil_kecil"
                        class="form-label fw-semibold"
                    >

                        Kapasitas Mobil

                    </label>


                    <input
                        type="number"
                        id="kapasitas_mobil_kecil"
                        name="kapasitas_mobil_kecil"
                        class="form-control @error('kapasitas_mobil') is-invalid @enderror"
                        value="{{ old('kapasitas_mobil_kecil', $titikParkir->kapasitas_mobil_kecil ?? $titikParkir->kapasitas_mobil ?? 0) }}"
                        min="0"
                    >


                    @error('kapasitas_mobil_kecil')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="form-text">
                        Perkiraan jumlah kendaraan mobil.
                    </div>

                </div>

                <div class="col-md-4"><label for="kapasitas_mobil_besar" class="form-label fw-semibold">Kapasitas mobil besar</label><input type="number" id="kapasitas_mobil_besar" name="kapasitas_mobil_besar" min="0" value="{{ old('kapasitas_mobil_besar', $titikParkir->kapasitas_mobil_besar ?? 0) }}" class="form-control">@error('kapasitas_mobil_besar')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div>
                <div class="col-md-4"><label for="kapasitas_total" class="form-label fw-semibold">Kapasitas total</label><input type="number" id="kapasitas_total" name="kapasitas_total" min="0" value="{{ old('kapasitas_total', $titikParkir->kapasitas_total ?? 0) }}" class="form-control">@error('kapasitas_total')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div>



                {{-- POTENSI HARIAN --}}

                <div class="col-md-6">

                    <label
                        for="potensi_harian"
                        class="form-label fw-semibold"
                    >

                        Potensi Harian

                    </label>


                    <div class="input-group">

                        <span class="input-group-text">
                            Rp
                        </span>


                        <input
                            type="number"
                            id="potensi_harian"
                            name="potensi_harian"
                            class="form-control @error('potensi_harian') is-invalid @enderror"
                            value="{{ old('potensi_harian', $titikParkir->potensi_harian ?? 0) }}"
                            min="0"
                            step="0.01"
                        >

                    </div>


                    @error('potensi_harian')

                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- POTENSI BULANAN --}}

                <div class="col-md-6">

                    <label
                        for="potensi_bulanan"
                        class="form-label fw-semibold"
                    >

                        Potensi Bulanan

                    </label>


                    <div class="input-group">

                        <span class="input-group-text">
                            Rp
                        </span>


                        <input
                            type="number"
                            id="potensi_bulanan"
                            name="potensi_bulanan"
                            class="form-control @error('potensi_bulanan') is-invalid @enderror"
                            value="{{ old('potensi_bulanan', $titikParkir->potensi_bulanan ?? 0) }}"
                            min="0"
                            step="0.01"
                        >

                    </div>


                    @error('potensi_bulanan')

                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- JUMLAH KOORDINATOR --}}

                <div class="col-md-6">

                    <label
                        for="jumlah_koordinator"
                        class="form-label fw-semibold"
                    >

                        Jumlah Koordinator/Regu
                        <span class="badge bg-info ms-2">Baru</span>

                    </label>


                    <select
                        id="jumlah_koordinator"
                        name="jumlah_koordinator"
                        class="form-select @error('jumlah_koordinator') is-invalid @enderror"
                        required
                    >

                        <option value="">-- Pilih Jumlah Koordinator --</option>

                        <option value="1" {{ old('jumlah_koordinator', $titikParkir->jumlah_koordinator ?? 1) == 1 ? 'selected' : '' }}>
                            1 Regu (1 Koordinator)
                        </option>

                        <option value="2" {{ old('jumlah_koordinator', $titikParkir->jumlah_koordinator ?? 1) == 2 ? 'selected' : '' }}>
                            2 Regu (2 Koordinator) - untuk lokasi padat
                        </option>

                    </select>


                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-info-circle me-1"></i>
                        Untuk lokasi dengan target tinggi, pilih 2 regu. Target harian tetap sama.
                    </small>


                    @error('jumlah_koordinator')

                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sourceSelect = document.getElementById('sumber_pemasukan_id');
            const jenisParkirWrapper = document.getElementById('jenis-parkir-wrapper');
            const jenisParkirField = document.getElementById('jenis_parkir_id');
            const titleEl = document.getElementById('capacity-card-title');
            const businessFields = document.getElementById('business-capacity-fields');
            const parkingFields = document.getElementById('parking-capacity-fields');
            const capacityCard = document.getElementById('capacity-card');
            const parkingInputs = [
                document.getElementById('kapasitas_motor'),
                document.getElementById('kapasitas_mobil_kecil'),
                document.getElementById('kapasitas_mobil_besar'),
                document.getElementById('kapasitas_total'),
                document.getElementById('potensi_harian'),
                document.getElementById('potensi_bulanan'),
            ].filter(Boolean);
            const businessInputs = [
                document.getElementById('jumlah_unit'),
                document.getElementById('luas_m2'),
            ].filter(Boolean);

            function clearFields(list) {
                list.forEach(function (input) {
                    input.value = '';
                });
            }

            function applyCapacityMode() {
                const selected = sourceSelect.selectedOptions[0];
                const type = selected && selected.dataset.objekType ? selected.dataset.objekType : 'parkir';

                if (type === 'usaha') {
                    clearFields(parkingInputs);
                    if (jenisParkirField) {
                        jenisParkirField.value = '';
                        jenisParkirField.disabled = true;
                    }
                    if (jenisParkirWrapper) {
                        jenisParkirWrapper.style.display = 'none';
                    }
                    capacityCard.style.display = 'block';
                    businessFields.style.display = 'flex';
                    parkingFields.style.display = 'none';
                    titleEl.innerHTML = '<i class="bi bi-building me-2 text-success"></i> Kios / Pelataran / Tempat Usaha';
                } else {
                    clearFields(businessInputs);
                    if (jenisParkirField) {
                        jenisParkirField.disabled = false;
                    }
                    if (jenisParkirWrapper) {
                        jenisParkirWrapper.style.display = 'block';
                    }
                    capacityCard.style.display = 'block';
                    businessFields.style.display = 'none';
                    parkingFields.style.display = 'flex';
                    titleEl.innerHTML = '<i class="bi bi-bar-chart me-2 text-success"></i> Kapasitas Parkir & Potensi';
                }
            }

            sourceSelect.addEventListener('change', applyCapacityMode);
            applyCapacityMode();
        });
    </script>


    {{-- ======================================================
        KAPASITAS & PENGELOLA
    ======================================================= --}}

    <div class="card mb-4">
        <div class="card-header bg-white border-bottom py-3"><h6 class="mb-0 fw-bold"><i class="bi bi-p-square me-2 text-success"></i>Penanggung Jawab Lokasi</h6></div>
        <div class="card-body"><div class="row g-4"><div class="col-md-6"><label for="nama_pengelola" class="form-label fw-semibold">Nama penanggung jawab</label><input id="nama_pengelola" name="nama_pengelola" value="{{ old('nama_pengelola', $titikParkir->nama_pengelola) }}" class="form-control"></div><div class="col-md-6"><label for="telepon_pengelola" class="form-label fw-semibold">Nomor telepon (opsional)</label><input id="telepon_pengelola" name="telepon_pengelola" value="{{ old('telepon_pengelola', $titikParkir->telepon_pengelola) }}" class="form-control"></div></div></div>
    </div>

    {{-- ======================================================
        FOTO & KETERANGAN
    ======================================================= --}}

    <div class="card mb-4">

        <div class="card-header bg-white border-bottom py-3">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-image me-2 text-success"></i>

                Dokumentasi

            </h6>

        </div>


        <div class="card-body">

            <div class="row g-4">


                {{-- FOTO LAMA --}}

                @if($titikParkir->foto)

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Foto Saat Ini
                        </label>

                        <div>

                            <img
                                src="{{ asset('storage/' . $titikParkir->foto) }}"
                                alt="{{ $titikParkir->nama }}"
                                class="img-fluid rounded border"
                                style="
                                    max-width:250px;
                                    max-height:180px;
                                    object-fit:cover;
                                "
                            >

                        </div>

                    </div>

                @endif



                {{-- FOTO BARU --}}

                <div class="col-md-6">

                    <label
                        for="foto"
                        class="form-label fw-semibold"
                    >

                        Ganti Foto

                    </label>


                    <input
                        type="file"
                        id="foto"
                        name="foto"
                        class="form-control @error('foto') is-invalid @enderror"
                        accept="image/*"
                    >


                    @error('foto')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="form-text">

                        Kosongkan jika tidak ingin mengganti foto.
                        Maksimal 2 MB.

                    </div>

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
                        id="keterangan"
                        name="keterangan"
                        rows="4"
                        class="form-control @error('keterangan') is-invalid @enderror"
                        placeholder="Tambahkan keterangan jika diperlukan..."
                    >{{ old('keterangan', $titikParkir->keterangan) }}</textarea>


                    @error('keterangan')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

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

                    Pastikan data yang diperbarui sudah benar.

                </div>


                <div class="d-flex gap-2">

                    <a
                        href="{{ route('admin.titik-parkir.index') }}"
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