@extends('layouts.admin')

@section('title', 'Edit Target Pendapatan')
@section('page-title', 'Edit Target Pendapatan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div><h4 class="fw-bold mb-1">Edit Target Pendapatan</h4><p class="text-muted mb-0">Perbarui target untuk sumber dan periode yang dipilih.</p></div><a href="{{ route('admin.target-pendapatan.index', ['tahun' => $target->tahun]) }}" class="btn btn-outline-secondary">Kembali</a></div>
<form method="POST" action="{{ route('admin.target-pendapatan.update', $target) }}">@csrf @method('PUT') @include('admin.target-pendapatan.form', ['target' => $target])</form>
@endsection