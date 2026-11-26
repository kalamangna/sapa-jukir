@extends('layouts.admin')
@section('title', 'Tambah Objek Pendapatan')
@section('page-title', 'Tambah Objek Pendapatan')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Tambah Objek Pendapatan</h4>
        <p class="text-muted mb-0">Tambahkan data objek pendapatan sesuai kategori sumber pendapatan.</p>
    </div>
    <a href="{{ route('admin.objek-pendapatan.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>
<form method="POST" action="{{ route('admin.objek-pendapatan.store') }}">
    @csrf
    @include('admin.objek-pendapatan.form', ['objek' => null, 'tipe' => $tipe ?? null])
</form>
@endsection