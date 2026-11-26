@extends('layouts.admin')

@section('title', 'Target Pendapatan')
@section('page-title', 'Target Pendapatan')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div><h4 class="mb-1 fw-bold">Target Pendapatan</h4><p class="text-muted mb-0">Kelola target berdasarkan sumber dan objek pendapatan.</p></div>
    <a href="{{ route('admin.target-pendapatan.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Tambah Target</a>
</div>
<div class="card">
    <div class="card-body border-bottom"><form method="GET" class="row g-2 align-items-end">
        <div class="col-md-2"><label for="tahun" class="form-label">Tahun</label><input id="tahun" name="tahun" type="number" min="2026" max="2100" value="{{ $tahun }}" class="form-control"></div>
        <div class="col-md-3"><label for="sumber_pemasukan_id" class="form-label">Sumber</label><select id="sumber_pemasukan_id" name="sumber_pemasukan_id" class="form-select"><option value="">Semua sumber</option>@foreach($sumberPemasukans as $sumber)<option value="{{ $sumber->id }}" @selected((string) $sumberPemasukanId === (string) $sumber->id)>{{ $sumber->nama }}</option>@endforeach</select></div>
        <div class="col-md-3"><label for="titik_parkir_id" class="form-label">Lokasi</label><select id="titik_parkir_id" name="titik_parkir_id" class="form-select"><option value="">Semua lokasi</option><option value="aggregate" @selected($titikParkirId === 'aggregate')>Target agregat sumber</option>@foreach($titikParkirs as $titik)<option value="{{ $titik->id }}" @selected((string) $titikParkirId === (string) $titik->id)>{{ $titik->nama }}</option>@endforeach</select></div>
        <div class="col-auto"><button class="btn btn-outline-primary">Filter</button></div>
    </form></div>
    <div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Periode</th><th>Sumber</th><th>Objek</th><th>Target</th><th>Catatan</th><th class="text-end">Aksi</th></tr></thead><tbody>
    @forelse($targets as $target)<tr><td>{{ $target->bulan }}/{{ $target->tahun }}</td><td>{{ $target->sumberPemasukan->nama }}</td><td>{{ $target->titikParkir?->nama ?? $target->objekPendapatan?->nama ?? 'Agregat sumber' }}</td><td>Rp {{ number_format($target->target, 0, ',', '.') }}</td><td>{{ $target->catatan ?: '-' }}</td><td class="text-end text-nowrap"><a href="{{ route('admin.target-pendapatan.edit', $target) }}" class="btn btn-sm btn-outline-warning" title="Ubah" aria-label="Ubah target {{ $target->sumberPemasukan->nama }}"><i class="bi bi-pencil"></i></a><form action="{{ route('admin.target-pendapatan.destroy', $target) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus target pendapatan ini? Perhitungan capaian periode terkait akan berubah.')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" title="Hapus" aria-label="Hapus target {{ $target->sumberPemasukan->nama }}"><i class="bi bi-trash"></i></button></form></td></tr>
    @empty<tr><td colspan="6" class="text-center text-muted py-5">Belum ada target untuk tahun {{ $tahun }}.</td></tr>@endforelse
    </tbody></table></div><div class="card-footer">{{ $targets->links() }}</div>
</div>
@endsection