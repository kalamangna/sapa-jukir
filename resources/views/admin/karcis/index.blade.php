@extends('layouts.admin')

@section('title', 'Penyerahan Karcis')
@section('page-title', 'Penyerahan Karcis')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-1">Penyerahan Seri Karcis</h4>
    <p class="text-muted mb-0">Catat rentang seri dan nilai karcis saat diserahkan kepada penerima. Nomor yang sudah diserahkan tidak dapat dipakai ulang untuk batch baru.</p>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="card mb-4">
    <div class="card-header fw-bold">Catat Penyerahan Karcis</div>
    <form method="POST" action="{{ route('admin.karcis.store') }}">
        @csrf
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold" for="sumber_pemasukan_id">Sumber Pemasukan</label>
                    <select class="form-select" name="sumber_pemasukan_id" id="sumber_pemasukan_id" required>
                        <option value="">Pilih sumber pemasukan</option>
                        @foreach($sources as $source)
                            <option value="{{ $source->id }}" @selected(old('sumber_pemasukan_id') == $source->id)>{{ $source->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" for="jukir_id">Jukir (opsional)</label>
                    <select class="form-select" name="jukir_id" id="jukir_id">
                        <option value="">Tidak ditautkan ke jukir tertentu</option>
                        @foreach($jukirs as $jukir)
                            <option value="{{ $jukir->id }}" @selected(old('jukir_id') == $jukir->id)>{{ $jukir->kode_jukir }} - {{ $jukir->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" for="penerima">Nama Penerima</label>
                    <input class="form-control" name="penerima" id="penerima" value="{{ old('penerima') }}" maxlength="150" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" for="jenis_karcis">Jenis/Nominal Karcis</label>
                    <input class="form-control" name="jenis_karcis" id="jenis_karcis" value="{{ old('jenis_karcis') }}" maxlength="100" placeholder="Contoh: Motor, Mobil kecil, atau Karcis Retribusi" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" for="tanggal_penyerahan">Tanggal Penyerahan</label>
                    <input class="form-control" type="date" name="tanggal_penyerahan" id="tanggal_penyerahan" value="{{ old('tanggal_penyerahan', today()->toDateString()) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="seri_prefix">Awalan Seri (opsional)</label>
                    <input class="form-control text-uppercase" name="seri_prefix" id="seri_prefix" value="{{ old('seri_prefix') }}" placeholder="Contoh: A-" maxlength="30">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="nomor_awal">Nomor Awal</label>
                    <input class="form-control" inputmode="numeric" name="nomor_awal" id="nomor_awal" value="{{ old('nomor_awal') }}" placeholder="Contoh: 0001" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="nomor_akhir">Nomor Akhir</label>
                    <input class="form-control" inputmode="numeric" name="nomor_akhir" id="nomor_akhir" value="{{ old('nomor_akhir') }}" placeholder="Contoh: 0500" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" for="nilai_per_karcis">Nilai per Karcis (Rp)</label>
                    <input class="form-control" type="number" name="nilai_per_karcis" id="nilai_per_karcis" value="{{ old('nilai_per_karcis') }}" min="1" step="1" required>
                    <div class="form-text">Nilai ini menjadi dasar hitung bruto pada setoran dari seri karcis ini.</div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end"><button class="btn btn-primary" type="submit"><i class="bi bi-ticket-perforated me-1"></i>Simpan Penyerahan</button></div>
    </form>
</div>

<div class="card">
    <div class="card-header fw-bold">Riwayat Penyerahan dan Sisa Karcis</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Tanggal</th><th>Sumber</th><th>Penerima</th><th>Rentang Seri</th><th>Nilai/Karcis</th><th>Terpakai</th><th>Sisa</th></tr></thead>
            <tbody>
                @forelse($allocations as $allocation)
                    @php($total = $allocation->nomor_akhir - $allocation->nomor_awal + 1)
                    <tr>
                        <td>{{ $allocation->tanggal_penyerahan->format('d/m/Y') }}</td>
                        <td>{{ $allocation->sumberPemasukan->nama }}</td>
                        <td>{{ $allocation->penerima }}@if($allocation->jukir)<div class="small text-muted">{{ $allocation->jukir->nama }}</div>@endif</td>
                        <td>{{ $allocation->formatNomor($allocation->nomor_awal) }}–{{ $allocation->formatNomor($allocation->nomor_akhir) }}</td>
                        <td>Rp {{ number_format($allocation->nilai_per_karcis, 0, ',', '.') }}</td>
                        <td>{{ $allocation->usages_count }} / {{ $total }}</td>
                        <td>{{ $allocation->jumlah_tersedia }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">Belum ada penyerahan seri karcis.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($allocations->hasPages())<div class="card-footer">{{ $allocations->links() }}</div>@endif
</div>
@endsection
