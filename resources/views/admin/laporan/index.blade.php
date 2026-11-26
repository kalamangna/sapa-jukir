@extends('layouts.admin')

@section('title', 'Laporan')

@section('page-title', 'Laporan')

@section('content')

<div class="mb-4">

    <h4 class="fw-bold mb-1">
        Laporan SAPA JUKIR
    </h4>

    <p class="text-muted mb-0">
        Pilih jenis laporan yang ingin ditampilkan.
    </p>

</div>


{{-- ==========================================================
    GRID LAPORAN
=========================================================== --}}

<div class="row g-4">

    <div class="col-12 col-md-6">
        <div class="card h-100 border-danger"><div class="card-body p-4"><div class="d-flex align-items-start gap-3"><div class="rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center flex-shrink-0" style="width:60px;height:60px;"><i class="bi bi-exclamation-diamond fs-3"></i></div><div class="flex-grow-1"><h5 class="fw-bold mb-2">Laporan Tunggakan</h5><p class="text-muted mb-3">Pantau tagihan terbit, pembayaran, saldo tunggakan, dan tagihan terlambat.</p><a href="{{ route('admin.laporan.tunggakan') }}" class="btn btn-danger"><i class="bi bi-exclamation-diamond me-1"></i>Buka Laporan Tunggakan</a></div></div></div></div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card h-100 border-success"><div class="card-body p-4"><div class="d-flex align-items-start gap-3"><div class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0" style="width:60px;height:60px;"><i class="bi bi-graph-up-arrow fs-3"></i></div><div class="flex-grow-1"><h5 class="fw-bold mb-2">Laporan Capaian Realisasi</h5><p class="text-muted mb-3">Bandingkan target, realisasi, capaian, dan selisih berdasarkan sumber serta lokasi pendapatan.</p><a href="{{ route('admin.laporan.capaian-realisasi') }}" class="btn btn-success"><i class="bi bi-graph-up-arrow me-1"></i>Buka Laporan Capaian Realisasi</a></div></div></div></div>
    </div>


    {{-- ==========================================================
        LAPORAN Petugas
    =========================================================== --}}

    <div class="col-12 col-md-6">

        <div class="card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-start gap-3">

                    <div
                        class="rounded-3 bg-success-subtle text-success
                               d-flex align-items-center justify-content-center
                               flex-shrink-0"
                        style="width:60px;height:60px;"
                    >

                        <i class="bi bi-person-badge fs-3"></i>

                    </div>


                    <div class="flex-grow-1">

                        <h5 class="fw-bold mb-2">
                            Laporan Data Petugas
                        </h5>

                        <p class="text-muted mb-3">
                            Menampilkan data petugas berdasarkan
                            jenis petugas dan status.
                        </p>


                        <a
                            href="{{ route('admin.laporan.jukir.cetak') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-success"
                        >

                            <i class="bi bi-file-earmark-text me-1"></i>

                            Buka Laporan Petugas

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
        LAPORAN TITIK PARKIR
    =========================================================== --}}

    <div class="col-12 col-md-6">

        <div class="card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-start gap-3">

                    <div
                        class="rounded-3 bg-primary-subtle text-primary
                               d-flex align-items-center justify-content-center
                               flex-shrink-0"
                        style="width:60px;height:60px;"
                    >

                        <i class="bi bi-geo-alt fs-3"></i>

                    </div>


                    <div class="flex-grow-1">

                        <h5 class="fw-bold mb-2">
                            Laporan Objek Pendapatan
                        </h5>

                        <p class="text-muted mb-3">
                            Menampilkan data objek pendapatan berdasarkan
                            kategori dan status.
                        </p>


                        <a
                            href="{{ route('admin.laporan.titik-parkir') }}"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-geo-alt me-1"></i>

                            Buka Laporan Objek Pendapatan

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
        LAPORAN PENEMPATAN Petugas
    =========================================================== --}}

    <div class="col-12 col-md-6">

        <div class="card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-start gap-3">

                    <div
                        class="rounded-3 bg-warning-subtle text-warning
                               d-flex align-items-center justify-content-center
                               flex-shrink-0"
                        style="width:60px;height:60px;"
                    >

                        <i class="bi bi-person-lines-fill fs-3"></i>

                    </div>


                    <div class="flex-grow-1">

                        <h5 class="fw-bold mb-2">
                            Laporan Penempatan Petugas
                        </h5>

                        <p class="text-muted mb-3">
                            Menampilkan data penempatan petugas
                            pada setiap objek pendapatan berdasarkan status.
                        </p>


                        <a
                            href="{{ route('admin.laporan.penempatan-jukir') }}"
                            class="btn btn-warning"
                        >

                            <i class="bi bi-person-lines-fill me-1"></i>

                            Buka Laporan Penempatan

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
        LAPORAN TARIF
    =========================================================== --}}

    <div class="col-12 col-md-6">

        <div class="card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-start gap-3">

                    <div
                        class="rounded-3 bg-info-subtle text-info
                               d-flex align-items-center justify-content-center
                               flex-shrink-0"
                        style="width:60px;height:60px;"
                    >

                        <i class="bi bi-cash-stack fs-3"></i>

                    </div>


                    <div class="flex-grow-1">

                        <h5 class="fw-bold mb-2">
                            Laporan Tarif
                        </h5>

                        <p class="text-muted mb-3">
                            Menampilkan data tarif parkir berdasarkan
                            jenis parkir, jenis kendaraan, dan status tarif.
                        </p>


                        <a
                            href="{{ route('admin.laporan.tarif') }}"
                            class="btn btn-info text-white"
                        >

                            <i class="bi bi-cash-stack me-1"></i>

                            Buka Laporan Tarif

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
        LAPORAN SETORAN
    =========================================================== --}}

    <div class="col-12 col-md-6">

        <div class="card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-start gap-3">

                    <div
                        class="rounded-3 bg-danger-subtle text-danger
                               d-flex align-items-center justify-content-center
                               flex-shrink-0"
                        style="width:60px;height:60px;"
                    >

                        <i class="bi bi-bar-chart-line fs-3"></i>

                    </div>


                    <div class="flex-grow-1">

                        <h5 class="fw-bold mb-2">
                            Laporan Setoran
                        </h5>

                        <p class="text-muted mb-3">
                            Menampilkan rekap setoran petugas,
                            pendapatan bruto, jumlah setoran,
                            selisih, dan status verifikasi.
                        </p>


                        <a
                            href="{{ route('admin.laporan.setoran') }}"
                            class="btn btn-danger"
                        >

                            <i class="bi bi-bar-chart-line me-1"></i>

                            Buka Laporan Setoran

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


</div>

@endsection