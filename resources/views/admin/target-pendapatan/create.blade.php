@extends('layouts.admin')

@section('title', 'Tambah Target Pendapatan')
@section('page-title', 'Tambah Target Pendapatan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div><h4 class="fw-bold mb-1">Tambah Target Pendapatan</h4><p class="text-muted mb-0">Target dapat ditetapkan untuk sumber umum atau lokasi tertentu.</p></div><a href="{{ route('admin.target-pendapatan.index') }}" class="btn btn-outline-secondary">Kembali</a></div>
<form method="POST" action="{{ route('admin.target-pendapatan.store') }}">@csrf @include('admin.target-pendapatan.form', ['target' => null])</form>
@endsection