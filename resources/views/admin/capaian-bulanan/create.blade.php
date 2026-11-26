@extends('layouts.admin')

@section('title', 'Tambah Capaian')
@section('page-title', 'Tambah Capaian Bulanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div><h4 class="fw-bold mb-1">Tambah Capaian Bulanan</h4><p class="text-muted mb-0">Data ini akan menjadi override manual pada halaman publik.</p></div><a href="{{ route('admin.capaian-bulanan.index') }}" class="btn btn-outline-secondary">Kembali</a></div>
<form method="POST" action="{{ route('admin.capaian-bulanan.store') }}">@csrf @include('admin.capaian-bulanan.form', ['capaian' => null])</form>
@endsection
