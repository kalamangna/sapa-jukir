@extends('layouts.admin')
@section('title', 'Tambah Sumber Pendapatan')
@section('page-title', 'Tambah Sumber Pendapatan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h4 class="fw-bold">Tambah Jenis Sumber Pemasukan</h4><a href="{{ route('admin.sumber-pemasukan.index') }}" class="btn btn-outline-secondary">Kembali</a></div>
<form method="POST" action="{{ route('admin.sumber-pemasukan.store') }}">@csrf @include('admin.sumber-pemasukan.form', ['sumberPemasukan' => null])</form>
@endsection