@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')
@section('content')<div class="d-flex justify-content-between align-items-center mb-4"><h4 class="fw-bold">Tambah Pengguna</h4><a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Kembali</a></div><form method="POST" action="{{ route('admin.users.store') }}">@csrf @include('admin.users.form', ['user' => null])</form>@endsection