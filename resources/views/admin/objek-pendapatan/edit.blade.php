@extends('layouts.admin')
@section('title', 'Edit Objek Pendapatan')
@section('page-title', 'Edit Objek Pendapatan')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Edit Objek Pendapatan</h4>
        <p class="text-muted mb-0">Perbarui data objek pendapatan dan detail operasionalnya.</p>
    </div>
    <a href="{{ route('admin.objek-pendapatan.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>
<form method="POST" action="{{ route('admin.objek-pendapatan.update', $objek) }}">
    @csrf
    @method('PUT')
    @include('admin.objek-pendapatan.form')
</form>
@endsection