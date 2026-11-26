@extends('layouts.admin')

@section('title', 'Buat Tagihan')
@section('page-title', 'Buat Tagihan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Buat Tagihan</h4>
        <p class="text-muted mb-0">Terbitkan tagihan baru untuk sumber dan objek pendapatan.</p>
    </div>
    <a href="{{ route('admin.tagihan.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.tagihan.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="sumber_pemasukan_id" class="form-label fw-semibold">Sumber Pendapatan</label>
                    <select id="sumber_pemasukan_id" name="sumber_pemasukan_id" class="form-select @error('sumber_pemasukan_id') is-invalid @enderror" required>
                        <option value="">Pilih sumber</option>
                        @foreach($sumberPemasukans as $sumber)
                            <option value="{{ $sumber->id }}" @selected(old('sumber_pemasukan_id') == $sumber->id)>{{ $sumber->nama }}</option>
                        @endforeach
                    </select>
                    @error('sumber_pemasukan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="objek_pendapatan_id" class="form-label fw-semibold">Objek Pendapatan</label>
                    <select id="objek_pendapatan_id" name="objek_pendapatan_id" class="form-select @error('objek_pendapatan_id') is-invalid @enderror">
                        <option value="">Tanpa objek spesifik</option>
                        @foreach($objekPendapatans as $objek)
                            <option value="{{ $objek->id }}" @selected(old('objek_pendapatan_id') == $objek->id)>{{ $objek->nama }} · {{ $objek->sumberPemasukan->nama }}</option>
                        @endforeach
                    </select>
                    @error('objek_pendapatan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="nomor_tagihan" class="form-label fw-semibold">Nomor Tagihan</label>
                    <input id="nomor_tagihan" name="nomor_tagihan" value="{{ old('nomor_tagihan') }}" class="form-control @error('nomor_tagihan') is-invalid @enderror" placeholder="TGH-2026-001">
                    <div class="form-text">Kosongkan untuk nomor otomatis.</div>
                    @error('nomor_tagihan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="pihak_tertagih" class="form-label fw-semibold">Pihak Tertagih</label>
                    <input id="pihak_tertagih" name="pihak_tertagih" value="{{ old('pihak_tertagih') }}" class="form-control @error('pihak_tertagih') is-invalid @enderror">
                    @error('pihak_tertagih')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="uraian" class="form-label fw-semibold">Uraian</label>
                    <input id="uraian" name="uraian" value="{{ old('uraian') }}" class="form-control @error('uraian') is-invalid @enderror" required>
                    @error('uraian')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label for="tanggal_terbit" class="form-label fw-semibold">Tanggal Terbit</label>
                    <input id="tanggal_terbit" type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', now()->format('Y-m-d')) }}" class="form-control @error('tanggal_terbit') is-invalid @enderror" required>
                    @error('tanggal_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label for="tanggal_jatuh_tempo" class="form-label fw-semibold">Jatuh Tempo</label>
                    <input id="tanggal_jatuh_tempo" type="date" name="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo') }}" class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror" required>
                    @error('tanggal_jatuh_tempo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="nilai_tagihan" class="form-label fw-semibold">Nilai Tagihan</label>
                    <input id="nilai_tagihan" type="number" name="nilai_tagihan" value="{{ old('nilai_tagihan') }}" min="0.01" step="0.01" class="form-control @error('nilai_tagihan') is-invalid @enderror" required>
                    @error('nilai_tagihan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="catatan" class="form-label fw-semibold">Catatan</label>
                    <textarea id="catatan" name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan') }}</textarea>
                    @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Simpan Tagihan</button>
                <a href="{{ route('admin.tagihan.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection