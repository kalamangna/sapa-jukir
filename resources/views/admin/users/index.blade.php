@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4"><div><h4 class="fw-bold mb-1">Manajemen Pengguna</h4><p class="text-muted mb-0">Kelola akun dan hak akses aplikasi.</p></div><a href="{{ route('admin.users.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Tambah Pengguna</a></div>
<div class="card"><div class="card-body border-bottom"><form method="GET" class="d-flex gap-2"><input name="search" value="{{ $search }}" class="form-control" placeholder="Andi Pratama atau operator1" aria-label="Cari pengguna"><button class="btn btn-outline-primary">Filter</button>@if(filled($search))<a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Reset</a>@endif</form></div>
<div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th class="text-start">Nama</th><th class="text-start">Username</th><th>Role</th><th>Status</th><th class="text-end">Aksi</th></tr></thead><tbody>
@forelse($users as $user)
<tr><td class="text-start fw-semibold">{{ $user->name }} @if($user->is(auth()->user()))<span class="badge text-bg-info">Anda</span>@endif</td><td class="text-start">{{ $user->username }}</td><td>{{ ucfirst($user->role) }}</td><td><span class="badge {{ $user->isActive() ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $user->isActive() ? 'Aktif' : 'Tidak aktif' }}</span></td>
<td class="text-end text-nowrap"><a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning" aria-label="Ubah {{ $user->name }}"><i class="bi bi-pencil"></i></a>
<form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Hapus pengguna ini? Akun tidak bisa login lagi.')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" aria-label="Hapus {{ $user->name }}" @disabled($user->is(auth()->user()))><i class="bi bi-trash"></i></button></form></td></tr>
@empty
<tr><td colspan="5" class="text-center text-muted py-5">Belum ada pengguna.</td></tr>
@endforelse
</tbody></table></div><div class="card-footer">{{ $users->links() }}</div></div>
@endsection
