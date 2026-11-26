@extends('layouts.admin')
@section('title', 'Catat Okupansi Parkir')
@section('page-title', 'Catat Okupansi Parkir')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Catat Okupansi Parkir Khusus</h4>
    <a href="{{ route('admin.okupansi-parkir.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
<form method="POST" action="{{ route('admin.okupansi-parkir.store') }}">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="titik_parkir_id" class="form-label fw-semibold">Titik parkir khusus</label>
                    <select id="titik_parkir_id" name="titik_parkir_id" class="form-select @error('titik_parkir_id') is-invalid @enderror" required>
                        <option value="">Pilih titik</option>
                        @foreach($titikParkirs as $titik)
                            <option value="{{ $titik->id }}" @selected(old('titik_parkir_id') == $titik->id)>{{ $titik->nama }} · kapasitas {{ $titik->kapasitas_total ?? '-' }}</option>
                        @endforeach
                    </select>
                    @error('titik_parkir_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="tanggal" class="form-label fw-semibold">Tanggal</label>
                    <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" class="form-control @error('tanggal') is-invalid @enderror" required>
                    @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="jumlah_motor" class="form-label fw-semibold">Jumlah motor</label>
                    <input id="jumlah_motor" type="number" name="jumlah_motor" value="{{ old('jumlah_motor', 0) }}" min="0" class="form-control @error('jumlah_motor') is-invalid @enderror" required>
                    @error('jumlah_motor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="jumlah_mobil" class="form-label fw-semibold">Jumlah mobil</label>
                    <input id="jumlah_mobil" type="number" name="jumlah_mobil" value="{{ old('jumlah_mobil', 0) }}" min="0" class="form-control @error('jumlah_mobil') is-invalid @enderror" required>
                    @error('jumlah_mobil')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="catatan" class="form-label fw-semibold">Catatan</label>
                    <textarea id="catatan" name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan') }}</textarea>
                    @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Simpan Okupansi</button>
            </div>
        </div>
    </div>
</form>
@endsection