@extends('layouts.admin')

@section('title', 'Tambah Gallery')
@section('page-title', 'Tambah Gallery')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h4 class="mb-1 fw-bold">Tambah Dokumentasi</h4><p class="text-muted mb-0">Tambahkan foto kegiatan untuk halaman publik.</p></div>
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.gallery.form', ['gallery' => null])
</form>
@endsection
