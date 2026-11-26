@extends('layouts.admin')

@section('title', 'Detail Setoran')

@section('page-title', 'Detail Setoran')

@section('content')

<div class="container-fluid">

    {{-- ==========================================================
        HEADER
    =========================================================== --}}

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Detail Setoran
            </h4>

            <p class="text-muted mb-0">
                Informasi lengkap data setoran Petugas.
            </p>
        </div>

        <div class="d-flex gap-2 mt-3 mt-md-0">

            <a
                href="{{ route('admin.setoran.index') }}"
                class="btn btn-light border"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>

            {{-- EDIT HANYA JIKA BELUM VERIFIKASI --}}

            @if ($setoran->status === 'belum_verifikasi')

                <a
                    href="{{ route('admin.setoran.edit', $setoran->id) }}"
                    class="btn btn-primary"
                >
                    <i class="bi bi-pencil-square me-1"></i>
                    Edit
                </a>

            @endif

        </div>

    </div>


    {{-- ==========================================================
        INFORMASI UTAMA
    =========================================================== --}}

    <div class="row g-4">


        {{-- ==========================================================
            IDENTITAS SETORAN
        =========================================================== --}}

        <div class="col-12 col-lg-8">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-bottom p-4">

                    <h5 class="fw-bold mb-1">
                        Informasi Setoran
                    </h5>

                    <p class="text-muted mb-0 small">
                        Data transaksi setoran Petugas.
                    </p>

                </div>


                <div class="card-body p-4">

                    <div class="row g-4">

                        <div class="col-12">
                            <div class="text-muted small mb-1">Sumber Pendapatan</div>
                            <div class="fw-semibold">{{ $setoran->sumberPemasukan?->nama ?? $setoran->titikParkir?->jenisParkir?->nama ?? '-' }}</div>
                        </div>


                        {{-- Petugas --}}

                        <div class="col-12 col-md-6">

                            <div class="text-muted small mb-1">
                                Petugas
                            </div>

                            <div class="fw-semibold">

                                @if ($setoran->jukir)

                                    {{ $setoran->jukir->nama }}

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </div>

                            @if ($setoran->jukir)

                                <div class="text-muted small mt-1">

                                    Kode:
                                    {{ $setoran->jukir->kode_jukir }}

                                </div>

                            @endif

                        </div>


                        {{-- TITIK / OBJEK PENDAPATAN --}}

                        <div class="col-12 col-md-6">

                            <div class="text-muted small mb-1">
                                Titik/Objek Pendapatan
                            </div>

                            <div class="fw-semibold">

                                @if ($setoran->titikParkir)

                                    {{ $setoran->titikParkir->nama }}

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </div>

                            @if ($setoran->titikParkir)

                                <div class="text-muted small mt-1">

                                    Kode:
                                    {{ $setoran->titikParkir->kode_titik }}

                                </div>

                            @endif

                        </div>


                        {{-- TANGGAL --}}

                        <div class="col-12 col-md-6">

                            <div class="text-muted small mb-1">
                                Tanggal Setoran
                            </div>

                            <div class="fw-semibold">

                                {{ $setoran->tanggal?->translatedFormat('d F Y') ?? '-' }}

                            </div>

                        </div>


                        {{-- STATUS --}}

                        <div class="col-12 col-md-6">

                            <div class="text-muted small mb-1">
                                Status
                            </div>

                            <div>

                                @if ($setoran->status === 'belum_verifikasi')

                                    <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2">

                                        <i class="bi bi-clock me-1"></i>

                                        Belum Verifikasi

                                    </span>

                                @elseif ($setoran->status === 'terverifikasi')

                                    <span class="badge bg-success-subtle text-success-emphasis px-3 py-2">

                                        <i class="bi bi-check-circle me-1"></i>

                                        Terverifikasi

                                    </span>

                                @elseif ($setoran->status === 'ditolak')

                                    <span class="badge bg-danger-subtle text-danger-emphasis px-3 py-2">

                                        <i class="bi bi-x-circle me-1"></i>

                                        Ditolak

                                    </span>

                                @else

                                    <span class="badge bg-secondary-subtle text-secondary-emphasis px-3 py-2">

                                        {{ $setoran->status ?? '-' }}

                                    </span>

                                @endif

                            </div>

                        </div>


                    </div>


                    <hr class="my-4">


                    {{-- ==================================================
                        NILAI SETORAN
                    =================================================== --}}

                    <div class="row g-3">


                        {{-- PENDAPATAN BRUTO --}}

                        <div class="col-12 col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <div class="text-muted small mb-2">
                                    Pendapatan Bruto
                                </div>

                                <div class="fw-bold fs-5">

                                    Rp
                                    {{ number_format((float) $setoran->pendapatan_bruto, 0, ',', '.') }}

                                </div>

                            </div>

                        </div>


                        {{-- JUMLAH SETORAN --}}

                        <div class="col-12 col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <div class="text-muted small mb-2">
                                    Jumlah Setoran
                                </div>

                                <div class="fw-bold fs-5">

                                    Rp
                                    {{ number_format((float) $setoran->jumlah_setoran, 0, ',', '.') }}

                                </div>

                            </div>

                        </div>


                        {{-- SELISIH --}}

                        <div class="col-12 col-md-4">

                            <div class="border rounded-3 p-3 h-100">

                                <div class="text-muted small mb-2">
                                    Selisih
                                </div>

                                <div
                                    class="fw-bold fs-5
                                    @if ((float) $setoran->selisih > 0)
                                        text-danger
                                    @elseif ((float) $setoran->selisih < 0)
                                        text-warning
                                    @else
                                        text-success
                                    @endif
                                    "
                                >

                                    Rp
                                    {{ number_format((float) $setoran->selisih, 0, ',', '.') }}

                                </div>

                            </div>

                        </div>


                    </div>

                    <hr class="my-4">

                    <div>
                        <div class="fw-semibold mb-3">Rincian Karcis Terpakai</div>
                        @forelse($setoran->karcisUsages->groupBy('karcis_allocation_id') as $usages)
                            @php($allocation = $usages->first()->allocation)
                            <div class="border rounded-3 p-3 mb-2">
                                <div class="d-flex justify-content-between gap-3">
                                    <div class="fw-semibold">
                                        {{ $allocation?->jenis_karcis ?? 'Jenis karcis' }}
                                        <span class="text-muted fw-normal">— {{ $allocation?->sumberPemasukan?->nama ?? '-' }}</span>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary-emphasis">{{ $usages->count() }} karcis</span>
                                </div>
                                <div class="small text-muted mt-2">
                                    Seri:
                                    {{ $usages->sortBy('nomor_seri')->map(fn ($usage) => $allocation?->formatNomor($usage->nomor_seri) ?? $usage->nomor_seri)->implode(', ') }}
                                </div>
                                <div class="small mt-1">
                                    Nilai bruto:
                                    <span class="fw-semibold">Rp {{ number_format($usages->count() * (int) ($allocation?->nilai_per_karcis ?? 0), 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-muted small">Tidak ada rincian nomor karcis untuk setoran ini.</div>
                        @endforelse
                    </div>

                    {{-- ==================================================
                        KETERANGAN
                    =================================================== --}}

                    @if ($setoran->keterangan)

                        <hr class="my-4">

                        <div>

                            <div class="text-muted small mb-2">
                                Keterangan
                            </div>

                            <div class="bg-light rounded-3 p-3">

                                {!! nl2br(e($setoran->keterangan)) !!}

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- ==========================================================
            INFORMASI VERIFIKASI
        =========================================================== --}}

        <div class="col-12 col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-bottom p-4">

                    <h5 class="fw-bold mb-1">
                        Informasi Verifikasi
                    </h5>

                    <p class="text-muted mb-0 small">
                        Riwayat dan proses verifikasi data setoran.
                    </p>

                </div>


                <div class="card-body p-4">


                    {{-- ==================================================
                        BELUM VERIFIKASI
                    =================================================== --}}

                    @if ($setoran->status === 'belum_verifikasi')

                        <div class="text-center py-3">

                            <div
                                class="rounded-circle bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:70px;height:70px;"
                            >

                                <i class="bi bi-clock-history fs-2"></i>

                            </div>


                            <h6 class="fw-bold mb-2">
                                Belum Diverifikasi
                            </h6>


                            <p class="text-muted small mb-4">
                                Data setoran ini menunggu pemeriksaan
                                dan verifikasi.
                            </p>


                            {{-- ==================================================
                                TOMBOL VERIFIKASI
                            =================================================== --}}

                            <form
                                action="{{ route('admin.setoran.verifikasi', $setoran->id) }}"
                                method="POST"
                                class="mb-2"
                            >

                                @csrf
                                @method('PUT')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="terverifikasi"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-success w-100"
                                    onclick="return confirm('Apakah Anda yakin ingin memverifikasi setoran ini?')"
                                >

                                    <i class="bi bi-check-circle me-1"></i>

                                    Verifikasi Setoran

                                </button>

                            </form>


                            {{-- ==================================================
                                TOMBOL TOLAK
                            =================================================== --}}

                            <button
                                type="button"
                                class="btn btn-outline-danger w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#modalTolakSetoran"
                            >

                                <i class="bi bi-x-circle me-1"></i>

                                Tolak Setoran

                            </button>

                        </div>


                    {{-- ==================================================
                        SUDAH DIPROSES
                    =================================================== --}}

                    @else

                        <div class="text-center py-3">


                            {{-- TERVERIFIKASI --}}

                            @if ($setoran->status === 'terverifikasi')

                                <div
                                    class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width:70px;height:70px;"
                                >

                                    <i class="bi bi-check-circle fs-2"></i>

                                </div>

                                <h6 class="fw-bold text-success mb-2">
                                    Terverifikasi
                                </h6>


                            {{-- DITOLAK --}}

                            @elseif ($setoran->status === 'ditolak')

                                <div
                                    class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width:70px;height:70px;"
                                >

                                    <i class="bi bi-x-circle fs-2"></i>

                                </div>

                                <h6 class="fw-bold text-danger mb-2">
                                    Ditolak
                                </h6>


                            {{-- STATUS LAIN --}}

                            @else

                                <div
                                    class="rounded-circle bg-secondary-subtle text-secondary d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width:70px;height:70px;"
                                >

                                    <i class="bi bi-info-circle fs-2"></i>

                                </div>

                                <h6 class="fw-bold mb-2">
                                    {{ $setoran->status ?? '-' }}
                                </h6>

                            @endif

                        </div>


                        <hr>


                        {{-- ==================================================
                            WAKTU VERIFIKASI
                        =================================================== --}}

                        <div class="mb-3">

                            <div class="text-muted small mb-1">
                                Diverifikasi Pada
                            </div>

                            <div class="fw-semibold">

                                {{ $setoran->diverifikasi_at?->translatedFormat('d F Y, H:i') ?? '-' }}

                            </div>

                        </div>


                        {{-- ==================================================
                            VERIFIKATOR
                        =================================================== --}}

                        <div class="mb-3">

                            <div class="text-muted small mb-1">
                                Diverifikasi Oleh
                            </div>

                            <div class="fw-semibold">

                                @if ($setoran->diverifikasiOleh)

                                    {{ $setoran->diverifikasiOleh->name }}

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- ==================================================
                            KETERANGAN / ALASAN
                        =================================================== --}}

                        @if ($setoran->keterangan)

                            <div>

                                <div class="text-muted small mb-1">
                                    Keterangan
                                </div>

                                <div class="bg-light rounded-3 p-3 small">

                                    {!! nl2br(e($setoran->keterangan)) !!}

                                </div>

                            </div>

                        @endif

                    @endif

                </div>

            </div>

        </div>


    </div>


    {{-- ==========================================================
        INFORMASI SISTEM
    =========================================================== --}}

    <div class="card border-0 shadow-sm mt-4">

        <div class="card-body p-4">

            <div class="row g-4">


                {{-- DIBUAT --}}

                <div class="col-12 col-md-6">

                    <div class="text-muted small mb-1">
                        Dibuat Pada
                    </div>

                    <div class="fw-semibold">

                        {{ $setoran->created_at?->translatedFormat('d F Y, H:i') ?? '-' }}

                    </div>

                </div>


                {{-- DIPERBARUI --}}

                <div class="col-12 col-md-6">

                    <div class="text-muted small mb-1">
                        Terakhir Diperbarui
                    </div>

                    <div class="fw-semibold">

                        {{ $setoran->updated_at?->translatedFormat('d F Y, H:i') ?? '-' }}

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>


{{-- ==========================================================
    MODAL TOLAK SETORAN
=========================================================== --}}

<div
    class="modal fade"
    id="modalTolakSetoran"
    tabindex="-1"
    aria-labelledby="modalTolakSetoranLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5
                    class="modal-title fw-bold"
                    id="modalTolakSetoranLabel"
                >
                    Tolak Setoran
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form
                action="{{ route('admin.setoran.verifikasi', $setoran->id) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                <input
                    type="hidden"
                    name="status"
                    value="ditolak"
                >


                <div class="modal-body">

                    <div class="alert alert-danger">

                        <i class="bi bi-exclamation-triangle me-1"></i>

                        Setoran akan ditandai sebagai
                        <strong>ditolak</strong>.

                    </div>


                    <div>

                        <label
                            for="keterangan_penolakan"
                            class="form-label fw-semibold"
                        >
                            Alasan Penolakan
                        </label>

                        <textarea
                            name="keterangan"
                            id="keterangan_penolakan"
                            class="form-control"
                            rows="4"
                            placeholder="Masukkan alasan penolakan..."
                            required
                        ></textarea>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >

                        <i class="bi bi-x-circle me-1"></i>

                        Tolak Setoran

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection