@extends('layouts.admin')

@section('title', 'Aduan')
@section('page-title', 'Aduan Masyarakat')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div><h4 class="fw-bold mb-1">Aduan Masyarakat</h4><p class="text-muted mb-0">Pantau dan tindak lanjuti laporan publik.</p></div>
    <form method="GET" class="d-flex gap-2"><select name="status" class="form-select"><option value="">Semua Status</option><option value="baru" @selected($status === 'baru')>Baru</option><option value="diproses" @selected($status === 'diproses')>Diproses</option><option value="selesai" @selected($status === 'selesai')>Selesai</option><option value="ditolak" @selected($status === 'ditolak')>Ditolak</option></select><button class="btn btn-outline-primary">Filter</button></form>
</div>
<div class="card"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>No.</th><th class="text-start">Pelapor</th><th class="text-start">Jenis</th><th class="text-start">Lokasi</th><th>Foto Aduan</th><th>Status</th><th>Diterima</th><th class="text-end">Aksi</th></tr></thead><tbody>
@forelse($pengaduans as $pengaduan)
<tr class="{{ $pengaduan->dibaca_at ? '' : 'table-warning' }}"><td>{{ ($pengaduans->firstItem() ?? 1) + $loop->index }}</td><td class="text-start"><strong>{{ $pengaduan->nama }}</strong><div class="small text-muted">{{ $pengaduan->telepon }}</div></td><td class="text-start">{{ \App\Http\Controllers\PengaduanController::JENIS[$pengaduan->jenis] ?? $pengaduan->jenis }}</td><td class="text-start">{{ $pengaduan->lokasi_parkir }}</td><td>@if($pengaduan->foto)<a href="{{ route('admin.pengaduan.photo', $pengaduan) }}" target="_blank" rel="noopener noreferrer"><img src="{{ route('admin.pengaduan.photo', $pengaduan) }}" alt="Foto aduan {{ $pengaduan->nama }}" style="width:56px;height:56px;object-fit:cover;border-radius:6px;"></a>@else<span class="text-muted">-</span>@endif</td><td><span class="badge text-bg-{{ $pengaduan->status === 'baru' ? 'danger' : ($pengaduan->status === 'selesai' ? 'success' : 'warning') }}">{{ ucfirst($pengaduan->status) }}</span></td><td>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</td><td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.pengaduan.show', $pengaduan) }}">Lihat Detail</a></td></tr>
@empty
<tr><td colspan="8" class="text-center text-muted py-5">Belum ada aduan.</td></tr>
@endforelse
</tbody></table></div><div class="card-footer">{{ $pengaduans->links() }}</div></div>
@endsection
