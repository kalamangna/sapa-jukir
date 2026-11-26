@extends('layouts.admin')

@php
    $dashboardRoleTitle = auth()->check() && auth()->user()->role === 'pimpinan'
        ? 'Dashboard Pimpinan'
        : 'Dashboard';
@endphp

@section('title', $dashboardRoleTitle)

@section('page-title', $dashboardRoleTitle)

@section('content')

{{-- ==========================================================
    HEADER
========================================================== --}}

<div class="mb-4">

    <h4 class="mb-1 fw-bold">
        {{ auth()->check() && auth()->user()->role === 'pimpinan' ? 'Dashboard Pimpinan SAPA JUKIR' : 'Dashboard SAPA JUKIR' }}
    </h4>

    <p class="text-muted mb-0">
        {{ auth()->check() && auth()->user()->role === 'pimpinan'
            ? 'Ringkasan data dan kondisi pengelolaan pendapatan dan operasional Kabupaten Sinjai.'
            : 'Ringkasan data dan kondisi pengelolaan petugas Kabupaten Sinjai.'
        }}
    </p>

</div>


{{-- ==========================================================
    STATISTIK UTAMA
========================================================== --}}

<div class="row g-4 mb-4">


    {{-- TOTAL Petugas --}}

    <div class="col-xl-4 col-md-6">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start gap-3">

                    <div class="flex-grow-1 text-start">

                        <small class="text-muted fw-semibold">
                            TOTAL PETUGAS
                        </small>

                        <div class="fs-3 fw-bold mb-1 mt-2">
                            {{ number_format($totalJukir) }}
                        </div>

                        <small class="text-success">
                            {{ number_format($jukirAktif) }} petugas aktif
                        </small>

                    </div>

                    <div
                        class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:52px;height:52px;"
                    >

                        <i
                            class="bi bi-person-badge"
                            style="font-size:24px;"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- OBJEK PENDAPATAN --}}

    <div class="col-xl-4 col-md-6">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start gap-3">

                    <div class="flex-grow-1 text-start">

                        <small class="text-muted fw-semibold">
                            OBJEK PENDAPATAN
                        </small>

                        <div class="fs-3 fw-bold mb-1 mt-2">
                            {{ number_format($totalTitikParkir) }}
                        </div>

                        <small class="text-success">
                            {{ number_format($titikParkirAktif) }} objek aktif
                        </small>

                    </div>

                    <div
                        class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:52px;height:52px;"
                    >

                        <i
                            class="bi bi-geo-alt"
                            style="font-size:24px;"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- PENEMPATAN --}}

    <div class="col-xl-4 col-md-6">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start gap-3">

                    <div class="flex-grow-1 text-start">

                        <small class="text-muted fw-semibold">
                            PENEMPATAN AKTIF
                        </small>

                        <div class="fs-3 fw-bold mb-1 mt-2">
                            {{ number_format($penempatanAktif) }}
                        </div>

                        <small class="text-muted">
                            {{ number_format($totalPenempatan) }} total penempatan
                        </small>

                    </div>

                    <div
                        class="rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:52px;height:52px;"
                    >

                        <i
                            class="bi bi-pin-map"
                            style="font-size:24px;"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


</div>

<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6"><div class="card h-100"><div class="card-body text-start"><small class="text-muted fw-semibold">TARGET TAHUNAN</small><div class="fs-4 fw-bold mb-1 mt-2">Rp {{ number_format($targetTahunanDashboard, 0, ',', '.') }}</div><small class="text-muted">Target pendapatan {{ $tahunDashboard }}</small></div></div></div>
    <div class="col-xl-4 col-md-6"><div class="card h-100"><div class="card-body text-start"><small class="text-muted fw-semibold">REALISASI TAHUNAN</small><div class="fs-4 fw-bold mb-1 mt-2">Rp {{ number_format($realisasiTahunanDashboard, 0, ',', '.') }}</div><small class="text-muted">Setoran terverifikasi {{ $tahunDashboard }}</small></div></div></div>
    <div class="col-xl-4 col-md-6"><div class="card h-100"><div class="card-body text-start"><small class="text-muted fw-semibold">CAPAIAN TAHUNAN</small><div class="fs-4 fw-bold mb-1 mt-2">{{ number_format($persentaseCapaianTahunanDashboard, 2, ',', '.') }}%</div><small class="{{ $potensiBelumTergaliTahunanDashboard > 0 ? 'text-warning' : 'text-success' }}">Potensi belum tergali: Rp {{ number_format($potensiBelumTergaliTahunanDashboard, 0, ',', '.') }}</small></div></div></div>
</div>


<div class="card mb-4">
    <div class="card-header bg-white border-bottom py-3"><h6 class="mb-1 fw-bold"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>Tren Pendapatan {{ $tahunDashboard }}</h6><small class="text-muted">Perbandingan target, realisasi terverifikasi, dan capaian per bulan.</small></div>
    <div class="card-body"><div style="height: 320px;"><canvas id="trenPendapatanDashboardChart" aria-label="Grafik tren pendapatan tahunan"></canvas></div></div>
</div>

{{-- ==========================================================
    TARGET DAN CAPAIAN BULAN BERJALAN
========================================================== --}}

<div class="mb-3">
    @php($namaBulanDashboard = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'])
    <h5 class="fw-bold mb-1">Target dan Capaian Pendapatan</h5>
    <p class="text-muted mb-0">Periode {{ $namaBulanDashboard[now()->month] }} {{ now()->year }} berdasarkan target dan setoran terverifikasi.</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4"><div class="card h-100"><div class="card-body text-start"><small class="text-muted fw-semibold">TARGET BULAN BERJALAN</small><div class="fs-4 fw-bold mb-1 mt-2">Rp {{ number_format($targetBulanIni, 0, ',', '.') }}</div><small class="text-muted">Target dari sumber dan lokasi pendapatan</small></div></div></div>
    <div class="col-lg-4"><div class="card h-100"><div class="card-body text-start"><small class="text-muted fw-semibold">REALISASI TERVERIFIKASI</small><div class="fs-4 fw-bold mb-1 mt-2">Rp {{ number_format($realisasiBulanIni, 0, ',', '.') }}</div><small class="text-muted">Setoran terverifikasi bulan berjalan</small></div></div></div>
    <div class="col-lg-4"><div class="card h-100"><div class="card-body text-start"><small class="text-muted fw-semibold">CAPAIAN BULAN BERJALAN</small><div class="fs-4 fw-bold mb-1 mt-2">{{ number_format($persentaseCapaianBulanIni, 2, ',', '.') }}%</div><small class="{{ $persentaseCapaianBulanIni >= 80 ? 'text-success' : 'text-danger' }}">{{ $persentaseCapaianBulanIni >= 80 ? 'Capaian mendekati target' : 'Perlu perhatian' }}</small></div></div></div>
</div>

{{-- ==========================================================
    MONITORING PENDAPATAN
========================================================== --}}

<div class="mb-3">

    <h5 class="fw-bold mb-1">
        Monitoring Pendapatan
    </h5>

    <p class="text-muted mb-0">
        Ringkasan seluruh penerimaan dari semua sumber pendapatan.
    </p>

</div>


<div class="row g-4 mb-4">


    {{-- TOTAL SETORAN --}}

    <div class="col-xl-3 col-md-6">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start gap-3">

                    <div class="flex-grow-1 text-start">

                        <small class="text-muted fw-semibold">
                            TOTAL TRANSAKSI PENDAPATAN
                        </small>

                        <div class="fs-3 fw-bold mb-1 mt-2">
                            {{ number_format($totalSetoran) }}
                        </div>

                        <small class="text-muted">
                            Seluruh sumber pendapatan
                        </small>

                    </div>

                    <div
                        class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:52px;height:52px;"
                    >

                        <i
                            class="bi bi-receipt"
                            style="font-size:24px;"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- PENDAPATAN BRUTO --}}

    <div class="col-xl-3 col-md-6">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start gap-3">

                    <div class="flex-grow-1 text-start">

                        <small class="text-muted fw-semibold">
                            PENDAPATAN BRUTO
                        </small>

                        <div class="fs-4 fw-bold mb-1 mt-2">

                            Rp {{ number_format($totalPendapatanBruto, 0, ',', '.') }}

                        </div>

                        <small class="text-muted">
                            Total pendapatan tercatat
                        </small>

                    </div>

                    <div
                        class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:52px;height:52px;"
                    >

                        <i
                            class="bi bi-cash-coin"
                            style="font-size:24px;"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- TOTAL SETORAN MASUK --}}

    <div class="col-xl-3 col-md-6">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start gap-3">

                    <div class="flex-grow-1 text-start">

                        <small class="text-muted fw-semibold">
                            TOTAL PENERIMAAN
                        </small>

                        <div class="fs-4 fw-bold mb-1 mt-2">

                            Rp {{ number_format($totalJumlahSetoran, 0, ',', '.') }}

                        </div>

                        <small class="text-muted">
                            Total penerimaan yang masuk
                        </small>

                    </div>

                    <div
                        class="rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:52px;height:52px;"
                    >

                        <i
                            class="bi bi-wallet2"
                            style="font-size:24px;"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- TOTAL SELISIH --}}

    <div class="col-xl-3 col-md-6">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start gap-3">

                    <div class="flex-grow-1 text-start">

                        <small class="text-muted fw-semibold">
                            TOTAL SELISIH
                        </small>

                        <div class="fs-4 fw-bold mb-1 mt-2">

                            Rp {{ number_format($totalSelisih, 0, ',', '.') }}

                        </div>

                        <small class="text-muted">
                            Bruto dikurangi setoran
                        </small>

                    </div>

                    <div
                        class="rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:52px;height:52px;"
                    >

                        <i
                            class="bi bi-arrow-left-right"
                            style="font-size:24px;"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ==========================================================
    STATUS VERIFIKASI SETORAN
========================================================== --}}

<div class="card mb-4">

    <div class="card-header bg-white border-bottom py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h6 class="mb-1 fw-bold">
                    <i class="bi bi-shield-check me-2 text-primary"></i>
                    Status Verifikasi Setoran
                </h6>

                <small class="text-muted">
                    Kondisi verifikasi seluruh transaksi setoran.
                </small>

            </div>

            @if(in_array(auth()->user()->role, ['admin', 'pimpinan'], true))
                <a
                    href="{{ route('admin.laporan.setoran') }}"
                    class="btn btn-sm btn-outline-primary"
                >

                    <i class="bi bi-bar-chart-line me-1"></i>

                    Lihat Laporan

                </a>
            @endif

        </div>

    </div>


    <div class="card-body">

        <div class="row g-4">


            {{-- BELUM VERIFIKASI --}}

            <div class="col-md-4">

                <div class="d-flex align-items-center gap-3">

                    <div
                        class="rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:48px;height:48px;"
                    >

                        <i class="bi bi-hourglass-split fs-5"></i>

                    </div>

                    <div>

                        <div class="text-muted small">
                            Belum Verifikasi
                        </div>

                        <div class="fs-4 fw-bold">
                            {{ number_format($setoranBelumVerifikasi) }}
                        </div>

                    </div>

                </div>

            </div>


            {{-- TERVERIFIKASI --}}

            <div class="col-md-4">

                <div class="d-flex align-items-center gap-3">

                    <div
                        class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:48px;height:48px;"
                    >

                        <i class="bi bi-check-circle fs-5"></i>

                    </div>

                    <div>

                        <div class="text-muted small">
                            Terverifikasi
                        </div>

                        <div class="fs-4 fw-bold">
                            {{ number_format($setoranTerverifikasi) }}
                        </div>

                    </div>

                </div>

            </div>


            {{-- DITOLAK --}}

            <div class="col-md-4">

                <div class="d-flex align-items-center gap-3">

                    <div
                        class="rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:48px;height:48px;"
                    >

                        <i class="bi bi-x-circle fs-5"></i>

                    </div>

                    <div>

                        <div class="text-muted small">
                            Ditolak
                        </div>

                        <div class="fs-4 fw-bold">
                            {{ number_format($setoranDitolak) }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ==========================================================
    CAPAIAN TARGET HARIAN PETUGAS
========================================================== --}}

<div class="card mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h6 class="mb-1 fw-bold"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Capaian Target Harian Petugas</h6>
                <small class="text-muted">Perbandingan target titik dan objek pendapatan serta penerimaan untuk tanggal {{ \Carbon\Carbon::parse($tanggalFilter)->format('d/m/Y') }}.</small>
            </div>
            <div class="d-flex flex-wrap gap-3 small">
                <span class="text-success"><i class="bi bi-circle-fill me-1"></i>Tercapai: {{ $jumlahPetugasTercapai }}</span>
                <span class="text-danger"><i class="bi bi-circle-fill me-1"></i>Belum tercapai: {{ $jumlahPetugasBelumTercapai }}</span>
                <span class="text-secondary"><i class="bi bi-circle-fill me-1"></i>Tanpa target: {{ $jumlahPetugasTanpaTarget }}</span>
            </div>
        </div>
        <div class="pt-3 mt-3 border-top">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex gap-2 align-items-end flex-wrap">
                <div class="flex-grow-1" style="min-width: 250px;">
                    <label for="tanggalFilter" class="form-label fw-semibold mb-2">Filter Tanggal</label>
                    <input 
                        type="date" 
                        id="tanggalFilter" 
                        name="tanggal" 
                        class="form-control" 
                        value="{{ $tanggalFilter }}"
                        max="{{ now()->toDateString() }}"
                    >
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        @if($petugasCapaianHarian->count())
            <div style="height: min(420px, max(260px, {{ $petugasCapaianHarian->count() * 44 }}px));">
                <canvas id="petugasCapaianHarianChart" aria-label="Chart capaian target harian petugas"></canvas>
            </div>

            @if($petugasCapaianHarian->where('status', 'belum_tercapai')->count())
                <div class="mt-4">
                    <h6 class="fw-bold mb-3">Petugas Belum Mencapai Target</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr><th class="text-start">Petugas</th><th class="text-start">Titik Bertugas</th><th class="text-end">Target</th><th class="text-end">Realisasi</th><th class="text-end">Kekurangan</th></tr>
                            </thead>
                            <tbody>
                                @foreach($petugasCapaianHarian->where('status', 'belum_tercapai') as $item)
                                    <tr>
                                        <td class="text-start fw-semibold">{{ $item['nama'] }}</td>
                                        <td class="text-start">{{ $item['titik']->join(', ') ?: '-' }}</td>
                                        <td class="text-end">Rp {{ number_format($item['target'], 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($item['realisasi'], 0, ',', '.') }}</td>
                                        <td class="text-end text-danger fw-semibold">Rp {{ number_format(max(0, $item['target'] - $item['realisasi']), 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @else
            <div class="text-center text-muted py-5">Belum ada petugas aktif untuk ditampilkan.</div>
        @endif
    </div>
</div>

{{-- ==========================================================
    PERINGATAN DAN RANKING PENDAPATAN
========================================================== --}}

<div class="row g-4 mb-4">
    <div class="col-lg-5">
        <div class="card h-100 border-warning">
            <div class="card-header bg-white border-bottom py-3"><h6 class="mb-1 fw-bold"><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Peringatan Capaian</h6><small class="text-muted">Sumber dengan capaian di bawah 80% bulan berjalan.</small></div>
            <div class="card-body p-0"><div class="list-group list-group-flush">
                @forelse($peringatanPendapatan as $item)
                    <div class="list-group-item d-flex justify-content-between align-items-center gap-3"><span class="fw-semibold">{{ $item->nama }}</span><span class="text-danger fw-semibold">{{ number_format($item->persentase_capaian_bulan_ini, 2, ',', '.') }}%</span></div>
                @empty
                    <div class="text-center text-muted py-4">Belum ada sumber yang perlu diperingatkan.</div>
                @endforelse
            </div></div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-white border-bottom py-3"><h6 class="mb-1 fw-bold"><i class="bi bi-trophy me-2 text-primary"></i>Ranking Kinerja Sumber</h6><small class="text-muted">Urutan capaian target bulan berjalan.</small></div>
            <div class="table-responsive"><table class="table table-sm table-hover align-middle mb-0"><thead class="table-light"><tr><th>#</th><th class="text-start">Sumber Pendapatan</th><th class="text-end">Realisasi</th><th class="text-end">Capaian</th></tr></thead><tbody>
                @forelse($rankingPendapatan as $peringkat => $item)
                    <tr><td>{{ $peringkat + 1 }}</td><td class="text-start fw-semibold">{{ $item->nama }}</td><td class="text-end">Rp {{ number_format($item->realisasi_bulan_ini, 0, ',', '.') }}</td><td class="text-end">{{ number_format($item->persentase_capaian_bulan_ini, 2, ',', '.') }}%</td></tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada target untuk membuat ranking.</td></tr>
                @endforelse
            </tbody></table></div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-5">
        <div class="card h-100 border-danger">
            <div class="card-header bg-white border-bottom py-3"><h6 class="mb-1 fw-bold"><i class="bi bi-geo-alt me-2 text-danger"></i>Lokasi Perlu Perhatian</h6><small class="text-muted">Lokasi dengan capaian di bawah 80%.</small></div>
            <div class="card-body p-0"><div class="list-group list-group-flush">
                @forelse($peringatanLokasi as $lokasi)
                    <div class="list-group-item d-flex justify-content-between align-items-center gap-3"><span class="fw-semibold">{{ $lokasi['nama'] }}</span><span class="text-danger fw-semibold">{{ number_format($lokasi['persentase'], 2, ',', '.') }}%</span></div>
                @empty
                    <div class="text-center text-muted py-4">Belum ada lokasi yang perlu perhatian.</div>
                @endforelse
            </div></div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-white border-bottom py-3"><h6 class="mb-1 fw-bold"><i class="bi bi-pin-map me-2 text-primary"></i>Ranking Kinerja Lokasi</h6><small class="text-muted">Lokasi dengan target per objek pada bulan berjalan.</small></div>
            <div class="table-responsive"><table class="table table-sm table-hover align-middle mb-0"><thead class="table-light"><tr><th>#</th><th class="text-start">Lokasi</th><th class="text-end">Target</th><th class="text-end">Realisasi</th><th class="text-end">Capaian</th></tr></thead><tbody>
                @forelse($rankingLokasi as $peringkat => $lokasi)
                    <tr><td>{{ $peringkat + 1 }}</td><td class="text-start fw-semibold">{{ $lokasi['nama'] }}</td><td class="text-end">Rp {{ number_format($lokasi['target'], 0, ',', '.') }}</td><td class="text-end">Rp {{ number_format($lokasi['realisasi'], 0, ',', '.') }}</td><td class="text-end">{{ number_format($lokasi['persentase'], 2, ',', '.') }}%</td></tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada target per lokasi.</td></tr>
                @endforelse
            </tbody></table></div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-white border-bottom py-3"><h6 class="mb-1 fw-bold"><i class="bi bi-person-check me-2 text-primary"></i>Ranking Kinerja Petugas</h6><small class="text-muted">Capaian petugas berdasarkan penempatan aktif dan target lokasi.</small></div>
    <div class="table-responsive"><table class="table table-sm table-hover align-middle mb-0"><thead class="table-light"><tr><th>#</th><th class="text-start">Petugas</th><th class="text-end">Target</th><th class="text-end">Realisasi</th><th class="text-end">Capaian</th></tr></thead><tbody>
        @forelse($rankingPetugas as $peringkat => $petugas)
            <tr><td>{{ $peringkat + 1 }}</td><td class="text-start fw-semibold">{{ $petugas['nama'] }}</td><td class="text-end">Rp {{ number_format($petugas['target'], 0, ',', '.') }}</td><td class="text-end">Rp {{ number_format($petugas['realisasi'], 0, ',', '.') }}</td><td class="text-end">{{ number_format($petugas['persentase'], 2, ',', '.') }}%</td></tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada target lokasi dengan petugas aktif.</td></tr>
        @endforelse
    </tbody></table></div>
</div>

{{-- ==========================================================
    PENDAPATAN PER SUMBER
========================================================== --}}

<div class="card mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Pendapatan per Sumber</h6>
    </div>
    <div class="table-responsive dashboard-source-table-wrap">
        <table class="table table-hover align-middle mb-0 dashboard-source-table">
            <thead class="table-light">
                <tr><th class="text-center">Sumber Pendapatan</th><th class="text-center">Target Bulan Ini</th><th class="text-center">Realisasi</th><th class="text-center">Capaian</th><th class="text-center">Total Penerimaan<br><small>Semua Waktu</small></th><th class="text-center">Selisih<br><small>Semua Waktu</small></th></tr>
            </thead>
            <tbody>
                @forelse($pendapatanPerSumber as $item)
                    <tr><td class="fw-semibold text-center">{{ $item->nama }}</td><td class="text-center">Rp {{ number_format($item->target_bulan_ini, 0, ',', '.') }}</td><td class="text-center">Rp {{ number_format($item->realisasi_bulan_ini, 0, ',', '.') }}</td><td class="text-center">{{ number_format($item->persentase_capaian_bulan_ini, 2, ',', '.') }}%</td><td class="text-center">Rp {{ number_format($item->total_jumlah_setoran ?? 0, 0, ',', '.') }}</td><td class="text-center">Rp {{ number_format($item->total_selisih ?? 0, 0, ',', '.') }}</td></tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada kategori pendapatan aktif.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ==========================================================
    SETORAN TERBARU
========================================================== --}}

<div class="card mb-4">

    <div class="card-header bg-white border-bottom py-3">

        <div class="d-flex justify-content-between align-items-center">

            <h6 class="mb-0 fw-bold">

                <i class="bi bi-receipt-cutoff me-2 text-primary"></i>

                Setoran Terbaru

            </h6>

            <a
                href="{{ auth()->user()->role === 'pimpinan' ? route('admin.laporan.setoran') : route('admin.setoran.index') }}"
                class="btn btn-sm btn-outline-primary"
            >

                {{ auth()->user()->role === 'pimpinan' ? 'Lihat Laporan' : 'Lihat Semua Setoran' }}

            </a>

        </div>

    </div>


    <div class="card-body p-0">

        @if($setoranTerbaru->count())

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>
                                Tanggal
                            </th>

                            <th class="text-start">
                                Petugas
                            </th>

                            <th class="text-start">
                                Objek Pendapatan
                            </th>

                            <th class="text-start">
                                Kategori
                            </th>

                            <th class="text-end">
                                Pendapatan<br>Bruto
                            </th>

                            <th class="text-end">
                                Setoran
                            </th>

                            <th class="text-end">
                                Selisih
                            </th>

                            <th class="text-center">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($setoranTerbaru as $setoran)

                            <tr>

                                {{-- TANGGAL --}}

                                <td>

                                    <div class="fw-semibold">

                                        {{ $setoran->tanggal?->format('d/m/Y') ?? '-' }}

                                    </div>

                                </td>


                                {{-- Petugas --}}

                                <td class="text-start">

                                    @if($setoran->jukir)

                                        <div class="fw-semibold">
                                            {{ $setoran->jukir->nama }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $setoran->jukir->kode_jukir }}
                                        </small>

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- TITIK PARKIR --}}

                                <td class="text-start">

                                    @if($setoran->titikParkir)

                                        <div class="fw-semibold">
                                            {{ $setoran->titikParkir->nama }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $setoran->titikParkir->kode_titik }}
                                        </small>

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- BRUTO --}}

                                <td class="text-start">
                                    {{ $setoran->sumberPemasukan?->nama ?? $setoran->titikParkir?->jenisParkir?->nama ?? '-' }}
                                </td>

                                {{-- BRUTO --}}

                                <td class="text-end">

                                    Rp
                                    {{ number_format($setoran->pendapatan_bruto, 0, ',', '.') }}

                                </td>


                                {{-- SETORAN --}}

                                <td class="text-end fw-semibold">

                                    Rp
                                    {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}

                                </td>


                                {{-- SELISIH --}}

                                <td class="text-end">

                                    Rp
                                    {{ number_format($setoran->selisih, 0, ',', '.') }}

                                </td>


                                {{-- STATUS --}}

                                <td class="text-center">

                                    @if($setoran->status === 'terverifikasi')

                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Terverifikasi
                                        </span>

                                    @elseif($setoran->status === 'belum_verifikasi')

                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-hourglass-split me-1"></i>
                                            Belum Verifikasi
                                        </span>

                                    @elseif($setoran->status === 'ditolak')

                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ ucfirst(str_replace('_', ' ', $setoran->status)) }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-5">

                <i
                    class="bi bi-receipt text-muted"
                    style="font-size:40px;"
                ></i>

                <p class="text-muted mb-0 mt-2">
                    Belum ada data setoran.
                </p>

                @if(in_array(auth()->user()->role, ['admin', 'operator'], true))
                    <a
                        href="{{ route('admin.setoran.create') }}"
                        class="btn btn-primary btn-sm mt-3"
                    >

                        <i class="bi bi-plus-lg me-1"></i>

                        Tambah Setoran

                    </a>
                @endif

            </div>

        @endif

    </div>

</div>


@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        const getChartTheme = () => {
            const isDark = document.body.classList.contains('dark-theme');
            return {
                text: isDark ? '#cbd5e1' : '#475569',
                grid: isDark ? 'rgba(148, 163, 184, 0.16)' : 'rgba(15, 23, 42, 0.08)',
            };
        };

        const initialTheme = getChartTheme();
        const petugasCapaianHarian = @json($petugasCapaianHarian);
        const petugasCapaianCanvas = document.getElementById('petugasCapaianHarianChart');
        let petugasChart = null;

        if (petugasCapaianCanvas) {
            petugasChart = new Chart(petugasCapaianCanvas, {
                type: 'bar',
                data: {
                    labels: petugasCapaianHarian.map((item) => item.nama),
                    datasets: [
                        {
                            label: 'Target harian',
                            data: petugasCapaianHarian.map((item) => item.target),
                            backgroundColor: '#cbd5e1',
                            borderColor: '#94a3b8',
                            borderWidth: 1,
                        },
                        {
                            label: 'Realisasi hari ini',
                            data: petugasCapaianHarian.map((item) => item.realisasi),
                            backgroundColor: petugasCapaianHarian.map((item) => ({
                                tercapai: '#198754',
                                belum_tercapai: '#dc3545',
                                tanpa_target: '#6c757d',
                            }[item.status])),
                            borderWidth: 0,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        x: { ticks: { color: initialTheme.text }, grid: { color: initialTheme.grid } },
                        y: {
                            beginAtZero: true,
                            ticks: { color: initialTheme.text, callback: (value) => 'Rp ' + Number(value).toLocaleString('id-ID') },
                            grid: { color: initialTheme.grid },
                        },
                    },
                    plugins: {
                        legend: { labels: { color: initialTheme.text } },
                        tooltip: {
                            callbacks: {
                                title: (items) => {
                                    const item = petugasCapaianHarian[items[0].dataIndex];
                                    return item.nama + ' | Titik: ' + (item.titik.join(', ') || '-');
                                },
                                label: (context) => context.dataset.label + ': Rp ' + Number(context.raw).toLocaleString('id-ID'),
                            },
                        },
                    },
                },
            });
        }

        const trenPendapatanDashboard = @json($trenPendapatanDashboard);
        const trenPendapatanCanvas = document.getElementById('trenPendapatanDashboardChart');
        let trenChart = null;

        if (trenPendapatanCanvas) {
            trenChart = new Chart(trenPendapatanCanvas, {
                type: 'line',
                data: {
                    labels: trenPendapatanDashboard.map((item) => item.bulan),
                    datasets: [
                        { label: 'Target', data: trenPendapatanDashboard.map((item) => item.target), borderColor: '#0d6efd', backgroundColor: 'rgba(13, 110, 253, 0.12)', tension: 0.25, fill: false },
                        { label: 'Realisasi terverifikasi', data: trenPendapatanDashboard.map((item) => item.realisasi), borderColor: '#198754', backgroundColor: 'rgba(25, 135, 84, 0.12)', tension: 0.25, fill: false },
                        { label: 'Capaian', data: trenPendapatanDashboard.map((item) => item.capaian), borderColor: '#fd7e14', backgroundColor: 'rgba(253, 126, 20, 0.12)', yAxisID: 'yCapaian', tension: 0.25, fill: false },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        x: { ticks: { color: initialTheme.text }, grid: { color: initialTheme.grid } },
                        y: {
                            beginAtZero: true,
                            ticks: { color: initialTheme.text, callback: (value) => 'Rp ' + Number(value).toLocaleString('id-ID') },
                            grid: { color: initialTheme.grid },
                        },
                        yCapaian: {
                            beginAtZero: true,
                            suggestedMax: 100,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: { color: initialTheme.text, callback: (value) => value + '%' },
                        },
                    },
                    plugins: {
                        legend: { labels: { color: initialTheme.text } },
                        tooltip: { callbacks: { label: (context) => context.dataset.label + ': ' + (context.dataset.yAxisID === 'yCapaian' ? Number(context.raw).toLocaleString('id-ID') + '%' : 'Rp ' + Number(context.raw).toLocaleString('id-ID')) } },
                    },
                },
            });
        }

        document.querySelector('.admin-theme-toggle')?.addEventListener('click', () => {
            requestAnimationFrame(() => {
                const theme = getChartTheme();
                [petugasChart, trenChart].forEach((chart) => {
                    if (!chart) return;
                    if (chart.options.scales?.x?.ticks) chart.options.scales.x.ticks.color = theme.text;
                    if (chart.options.scales?.x?.grid) chart.options.scales.x.grid.color = theme.grid;
                    if (chart.options.scales?.y?.ticks) chart.options.scales.y.ticks.color = theme.text;
                    if (chart.options.scales?.y?.grid) chart.options.scales.y.grid.color = theme.grid;
                    if (chart.options.scales?.yCapaian?.ticks) chart.options.scales.yCapaian.ticks.color = theme.text;
                    if (chart.options.plugins?.legend?.labels) chart.options.plugins.legend.labels.color = theme.text;
                    chart.update('none');
                });
            });
        });
    </script>
@endpush