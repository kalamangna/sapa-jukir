@extends('layouts.admin')

@section('title', 'Edit Capaian')
@section('page-title', 'Edit Capaian Bulanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div><h4 class="fw-bold mb-1">Edit Capaian Bulanan</h4><p class="text-muted mb-0">Perbarui nilai manual yang tampil pada halaman publik.</p></div><a href="{{ route('admin.capaian-bulanan.index', ['tahun' => $capaian->tahun]) }}" class="btn btn-outline-secondary">Kembali</a></div>
<form method="POST" action="{{ route('admin.capaian-bulanan.update', $capaian) }}">@csrf @method('PUT') @include('admin.capaian-bulanan.form', ['capaian' => $capaian])</form>
@endsection
