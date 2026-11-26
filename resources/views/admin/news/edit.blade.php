@extends('layouts.admin')

@section('title', 'Ubah Berita')
@section('page-title', 'Ubah Berita')

@section('content')
<form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.news.form')
</form>
@endsection
