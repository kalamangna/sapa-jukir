@extends('layouts.admin')
@section('title', 'Tambah Unit Usaha')
@section('page-title', 'Tambah Unit Usaha')
@section('content')<div class="d-flex justify-content-between align-items-center mb-4"><h4 class="fw-bold">Tambah Unit Usaha</h4><a href="{{ route('admin.unit-usaha.index') }}" class="btn btn-outline-secondary">Kembali</a></div><form method="POST" action="{{ route('admin.unit-usaha.store') }}">@csrf @include('admin.unit-usaha.form', ['unit' => null])</form>@endsection