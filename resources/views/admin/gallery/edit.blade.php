@extends('layouts.admin')

@section('title', 'Edit Gallery')
@section('page-title', 'Edit Gallery')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h4 class="mb-1 fw-bold">Edit Dokumentasi</h4><p class="text-muted mb-0">Perbarui dokumentasi yang tampil pada halaman publik.</p></div>
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.gallery.form', ['gallery' => $gallery])
</form>
@endsection
