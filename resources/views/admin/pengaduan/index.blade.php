@extends('layouts.admin')

@section('title', 'Aduan')
@section('page-title', 'Aduan Masyarakat')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div><h4 class="fw-bold mb-1">Aduan Masyarakat</h4><p class="text-muted mb-0">Pantau dan tindak lanjuti laporan publik.</p></div>
    <form method="GET" class="d-flex gap-2"><select name="status" class="form-select"><option value="">Semua Status</option><option value="baru" @selected($status === 'baru')>Baru</option><option value="diproses" @selected($status === 'diproses')>Diproses</option><option value="selesai" @selected($status === 'selesai')>Selesai</option><option value="ditolak" @selected($status === 'ditolak')>Ditolak</option></select><button class="btn btn-outline-primary">Filter</button></form>
</div>
<div class="card"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>No.</th><th>Pelapor</th><th>Jenis</th><th>Lokasi</th><th>Foto Aduan</th><th>Status</th><th>Diterima</th><th></th></tr></thead><tbody>
@forelse($pengaduans as $pengaduan)
<tr class="{{ $pengaduan->dibaca_at ? '' : 'table-warning' }}"><td>{{ ($pengaduans->firstItem() ?? 1) + $loop->index }}</td><td><strong>{{ $pengaduan->nama }}</strong><div class="small text-muted">{{ $pengaduan->telepon }}</div></td><td>{{ \App\Http\Controllers\PengaduanController::JENIS[$pengaduan->jenis] ?? $pengaduan->jenis }}</td><td>{{ $pengaduan->lokasi_parkir }}</td><td>@if($pengaduan->foto)<a href="{{ asset('storage/' . $pengaduan->foto) }}" target="_blank" rel="noopener"><img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto aduan {{ $pengaduan->nama }}" style="width:56px;height:56px;object-fit:cover;border-radius:6px;"></a>@else<span class="text-muted">-</span>@endif</td><td><span class="badge text-bg-{{ $pengaduan->status === 'baru' ? 'danger' : ($pengaduan->status === 'selesai' ? 'success' : 'warning') }}">{{ ucfirst($pengaduan->status) }}</span></td><td>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</td><td><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.pengaduan.show', $pengaduan) }}">Detail</a></td></tr>
@empty
<tr><td colspan="8" class="text-center text-muted py-5">Belum ada aduan.</td></tr>
@endforelse
</tbody></table></div><div class="card-footer">{{ $pengaduans->links() }}</div></div>
@endsection
