@extends('layouts.admin')
@section('title', 'Tambah Pemanfaatan Aset')
@section('page-title', 'Tambah Pemanfaatan Aset')
@section('content')<div class="d-flex justify-content-between align-items-center mb-4"><h4 class="fw-bold">Tambah Pemanfaatan Aset</h4><a href="{{ route('admin.pemanfaatan-aset.index') }}" class="btn btn-outline-secondary">Kembali</a></div><form method="POST" action="{{ route('admin.pemanfaatan-aset.store') }}">@csrf @include('admin.pemanfaatan-aset.form', ['pemanfaatan' => null])</form>@endsection