@extends('layouts.admin')
@section('title', 'Edit Unit Usaha')
@section('page-title', 'Edit Unit Usaha')
@section('content')<div class="d-flex justify-content-between align-items-center mb-4"><h4 class="fw-bold">Edit Unit Usaha</h4><a href="{{ route('admin.unit-usaha.index') }}" class="btn btn-outline-secondary">Kembali</a></div><form method="POST" action="{{ route('admin.unit-usaha.update', $unit) }}">@csrf @method('PUT') @include('admin.unit-usaha.form', ['unit' => $unit])</form>@endsection