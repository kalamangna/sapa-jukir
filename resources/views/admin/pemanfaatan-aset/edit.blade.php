@extends('layouts.admin')
@section('title', 'Edit Pemanfaatan Aset')
@section('page-title', 'Edit Pemanfaatan Aset')
@section('content')<div class="d-flex justify-content-between align-items-center mb-4"><h4 class="fw-bold">Edit Pemanfaatan Aset</h4><a href="{{ route('admin.pemanfaatan-aset.index') }}" class="btn btn-outline-secondary">Kembali</a></div><form method="POST" action="{{ route('admin.pemanfaatan-aset.update', $pemanfaatan) }}">@csrf @method('PUT') @include('admin.pemanfaatan-aset.form', ['pemanfaatan' => $pemanfaatan])</form>@endsection