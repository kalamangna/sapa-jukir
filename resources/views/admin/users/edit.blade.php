@extends('layouts.admin')
@section('title', 'Ubah Pengguna')
@section('page-title', 'Ubah Pengguna')
@section('content')<div class="d-flex justify-content-between align-items-center mb-4"><h4 class="fw-bold">Ubah Pengguna</h4><a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Kembali</a></div><form method="POST" action="{{ route('admin.users.update', $user) }}">@csrf @method('PUT') @include('admin.users.form')</form>@endsection