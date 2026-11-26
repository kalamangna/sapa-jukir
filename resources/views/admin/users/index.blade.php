@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('content')
<div class="mb-4"><h4 class="fw-bold mb-1">Manajemen Pengguna</h4><p class="text-muted mb-0">Satu akun untuk setiap role.</p></div>
<div class="card"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Nama</th><th>Username</th><th>Role</th><th>Status</th><th class="text-end">Aksi</th></tr></thead><tbody>@foreach($users as $user)<tr><td class="fw-semibold">{{ $user->name }} @if($user->is(auth()->user()))<span class="badge text-bg-info">Anda</span>@endif</td><td>{{ $user->username }}</td><td>{{ ucfirst($user->role) }}</td><td><span class="badge {{ $user->isActive() ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $user->isActive() ? 'Aktif' : 'Tidak aktif' }}</span></td><td class="text-end"><a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning" aria-label="Ubah {{ $user->name }}"><i class="bi bi-pencil"></i></a></td></tr>@endforeach</tbody></table></div></div>
@endsection
