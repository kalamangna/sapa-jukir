@extends('layouts.admin')

@section('title', 'Edit Penempatan Petugas')

@section('page-title', 'Edit Penempatan Petugas')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

<div>

    <h4 class="mb-1 fw-bold">
        Edit Penempatan Petugas
    </h4>

    <p class="text-muted mb-0">
        Perbarui data penempatan Petugas.
    </p>

</div>

<a
    href="{{ route('admin.penempatan-jukir.index') }}"
    class="btn btn-outline-secondary"
>

    <i class="bi bi-arrow-left me-1"></i>

    Kembali

</a>

</div>

<div class="card">

<div class="card-header bg-white border-bottom py-3">

    <h6 class="mb-0 fw-bold">

        <i class="bi bi-pencil-square me-2 text-warning"></i>

        Form Edit Penempatan Petugas

    </h6>

</div>


<div class="card-body">

    <form
        action="{{ route('admin.penempatan-jukir.update', $penempatanJukir) }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        {{-- Petugas --}}

        <div class="mb-3">

            <label
                for="jukir_id"
                class="form-label fw-semibold"
            >

                Petugas

                <span class="text-danger">*</span>

            </label>


            <select
                name="jukir_id"
                id="jukir_id"
                class="form-select @error('jukir_id') is-invalid @enderror"
                required
            >

                <option value="">
                    Pilih petugas
                </option>

                @foreach($jukirs as $jukir)

                    <option
                        value="{{ $jukir->id }}"
                        @selected(old('jukir_id', $penempatanJukir->jukir_id) == $jukir->id)
                    >

                        {{ $jukir->kode_jukir }}
                        -
                        {{ $jukir->nama }}

                    </option>

                @endforeach

            </select>


            @error('jukir_id')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- TITIK PARKIR --}}

        <div class="mb-3">

            <label
                for="titik_parkir_id"
                class="form-label fw-semibold"
            >

                Titik Parkir

                <span class="text-danger">*</span>

            </label>


            <select
                name="titik_parkir_id"
                id="titik_parkir_id"
                class="form-select @error('titik_parkir_id') is-invalid @enderror"
                required
            >

                <option value="">
                    Pilih titik parkir
                </option>

                @foreach($titikParkirs as $titik)

                    <option
                        value="{{ $titik->id }}"
                        @selected(old('titik_parkir_id', $penempatanJukir->titik_parkir_id) == $titik->id)
                    >

                        {{ $titik->kode_titik }}
                        -
                        {{ $titik->nama }}

                    </option>

                @endforeach

            </select>


            @error('titik_parkir_id')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

        {{-- PERAN --}}

        <div class="mb-3">
            <label for="role" class="form-label fw-semibold">
                Peran
                <span class="text-danger">*</span>
            </label>

            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="">Pilih peran</option>
                <option value="koordinator" @selected(old('role', $penempatanJukir->role ?? 'anggota') === 'koordinator')>Koordinator</option>
                <option value="anggota" @selected(old('role', $penempatanJukir->role ?? 'anggota') === 'anggota')>Anggota</option>
            </select>

            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row g-3">


            {{-- TANGGAL MULAI --}}

            <div class="col-md-6">

                <label
                    for="tanggal_mulai"
                    class="form-label fw-semibold"
                >

                    Tanggal Mulai

                    <span class="text-danger">*</span>

                </label>


                <input
                    type="date"
                    name="tanggal_mulai"
                    id="tanggal_mulai"
                    class="form-control @error('tanggal_mulai') is-invalid @enderror"
                    value="{{ old('tanggal_mulai', $penempatanJukir->tanggal_mulai?->format('Y-m-d')) }}"
                    required
                >


                @error('tanggal_mulai')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- TANGGAL SELESAI --}}

            <div class="col-md-6">

                <label
                    for="tanggal_selesai"
                    class="form-label fw-semibold"
                >

                    Tanggal Selesai

                </label>


                <input
                    type="date"
                    name="tanggal_selesai"
                    id="tanggal_selesai"
                    class="form-control @error('tanggal_selesai') is-invalid @enderror"
                    value="{{ old('tanggal_selesai', $penempatanJukir->tanggal_selesai?->format('Y-m-d')) }}"
                >


                <small class="text-muted">
                    Kosongkan jika penempatan masih berlangsung.
                </small>


                @error('tanggal_selesai')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>

        </div>


        <div class="row g-3 mt-1">
            <div class="col-md-6">
                <label for="target_per_hari" class="form-label fw-semibold">Target Per Hari</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="target_per_hari"
                    id="target_per_hari"
                    class="form-control @error('target_per_hari') is-invalid @enderror"
                    value="{{ old('target_per_hari', $penempatanJukir->target_per_hari) }}"
                    placeholder="0"
                >
                @error('target_per_hari')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="waktu_kerja" class="form-label fw-semibold">Waktu Kerja</label>
                <input
                    type="text"
                    name="waktu_kerja"
                    id="waktu_kerja"
                    class="form-control @error('waktu_kerja') is-invalid @enderror"
                    value="{{ old('waktu_kerja', $penempatanJukir->waktu_kerja) }}"
                    placeholder="06.30 - 16.00 Wita"
                >
                @error('waktu_kerja')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- STATUS --}}

        <div class="mb-3 mt-3">

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

                <option
                    value="aktif"
                    @selected(old('status', $penempatanJukir->status) === 'aktif')
                >
                    Aktif
                </option>

                <option
                    value="selesai"
                    @selected(old('status', $penempatanJukir->status) === 'selesai')
                >
                    Selesai
                </option>

                <option
                    value="dibatalkan"
                    @selected(old('status', $penempatanJukir->status) === 'dibatalkan')
                >
                    Dibatalkan
                </option>

            </select>


            @error('status')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- SURAT PENUGASAN --}}

        <div class="mb-3">

            <label
                for="surat_penugasan"
                class="form-label fw-semibold"
            >

                Surat Penugasan

            </label>


            <input
                type="text"
                name="surat_penugasan"
                id="surat_penugasan"
                class="form-control @error('surat_penugasan') is-invalid @enderror"
                value="{{ old('surat_penugasan', $penempatanJukir->surat_penugasan) }}"
                maxlength="255"
                placeholder="Nomor surat penugasan"
            >


            @error('surat_penugasan')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- KETERANGAN --}}

        <div class="mb-4">

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
                placeholder="Keterangan tambahan penempatan"
            >{{ old('keterangan', $penempatanJukir->keterangan) }}</textarea>


            @error('keterangan')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- ACTION --}}

        <div class="d-flex justify-content-end gap-2">

            <a
                href="{{ route('admin.penempatan-jukir.index') }}"
                class="btn btn-outline-secondary"
            >

                Batal

            </a>


            <button
                type="submit"
                class="btn btn-success"
            >

                <i class="bi bi-check-circle me-1"></i>

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>

</div>

@endsection
