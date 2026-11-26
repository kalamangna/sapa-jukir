@extends('layouts.admin')
@section('title', 'Edit Sumber Pendapatan')
@section('page-title', 'Edit Sumber Pendapatan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h4 class="fw-bold">Edit Jenis Sumber Pemasukan</h4><a href="{{ route('admin.sumber-pemasukan.index') }}" class="btn btn-outline-secondary">Kembali</a></div>
<form method="POST" action="{{ route('admin.sumber-pemasukan.update', $sumberPemasukan) }}">@csrf @method('PUT') @include('admin.sumber-pemasukan.form')</form>
@endsection