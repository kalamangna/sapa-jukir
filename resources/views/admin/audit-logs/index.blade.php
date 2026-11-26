@extends('layouts.admin')

@section('title', 'Audit Trail')
@section('page-title', 'Audit Trail')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Audit Trail</h4>
        <p class="text-muted mb-0">Riwayat perubahan transaksi dan peringatan capaian.</p>
    </div>
    <form method="GET" class="d-flex flex-wrap gap-2">
        <select name="action" class="form-select w-auto" aria-label="Filter aksi">
            <option value="">Semua aksi</option>
            @foreach(['created' => 'Dibuat', 'updated' => 'Diubah', 'deleted' => 'Dihapus'] as $value => $label)
                <option value="{{ $value }}" @selected($action === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select name="type" class="form-select w-auto" aria-label="Filter objek">
            <option value="">Semua objek</option>
            @foreach($types as $item)
                <option value="{{ $item }}" @selected($type === $item)>{{ class_basename($item) }}</option>
            @endforeach
        </select>
        <select name="user_id" class="form-select w-auto" aria-label="Filter pengguna">
            <option value="">Semua pengguna</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected((string) $userId === (string) $user->id)>{{ $user->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary"><i class="bi bi-filter me-1"></i>Filter</button>
        @if(filled($action) || filled($type) || filled($userId))
            <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-secondary">Reset</a>
        @endif
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Waktu</th><th class="text-start">Pengguna</th><th>Aksi</th><th class="text-start">Objek</th><th class="text-start">Perubahan</th><th>Alamat IP</th></tr></thead>
            <tbody>
            @forelse($logs as $log)
                @php
                    $actionLabel = ['created' => 'Dibuat', 'updated' => 'Diubah', 'deleted' => 'Dihapus'][$log->action] ?? ucfirst($log->action);
                @endphp
                <tr>
                    <td class="text-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-start">{{ $log->user?->name ?? 'Sistem' }}</td>
                    <td><span class="badge text-bg-{{ $log->action === 'deleted' ? 'danger' : ($log->action === 'updated' ? 'warning' : 'success') }}">{{ $actionLabel }}</span></td>
                    <td class="text-start">{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</td>
                    <td class="text-start small" style="max-width: 380px; word-break: break-word;"><div><strong>Lama:</strong> {{ $log->old_values ? json_encode($log->old_values, JSON_UNESCAPED_UNICODE) : '-' }}</div><div><strong>Baru:</strong> {{ $log->new_values ? json_encode($log->new_values, JSON_UNESCAPED_UNICODE) : '-' }}</div></td>
                    <td>{{ $log->ip_address ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Belum ada audit trail.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $logs->links() }}</div>
</div>
@endsection