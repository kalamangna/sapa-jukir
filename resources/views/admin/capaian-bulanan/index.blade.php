@extends('layouts.admin')

@section('title', 'Capaian Bulanan')
@section('page-title', 'Capaian Bulanan')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div><h4 class="mb-1 fw-bold">Capaian Bulanan</h4><p class="text-muted mb-0">Input manual target dan realisasi dari Januari 2026.</p></div>
    <a href="{{ route('admin.capaian-bulanan.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Tambah Capaian</a>
</div>
<div class="card">
    <div class="card-body border-bottom"><form method="GET" class="row g-2 align-items-center"><div class="col-auto"><label for="tahun" class="col-form-label fw-semibold">Tahun</label></div><div class="col-auto"><input id="tahun" name="tahun" type="number" min="2026" max="2100" value="{{ $tahun }}" class="form-control"></div><div class="col-auto"><button class="btn btn-outline-primary">Tampilkan</button></div></form></div>
    <div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Bulan</th><th>Target</th><th>Realisasi</th><th>Capaian</th><th>Catatan</th><th class="text-end">Aksi</th></tr></thead><tbody>
    @forelse($capaian as $item)
        <tr><td><strong>{{ [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'][$item->bulan] }}</strong></td><td>Rp {{ number_format($item->target, 0, ',', '.') }}</td><td>Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td><td>{{ $item->target > 0 ? number_format(min(100, ($item->realisasi / $item->target) * 100), 2, ',', '.') : '0,00' }}%</td><td>{{ $item->catatan ?: '-' }}</td><td class="text-end text-nowrap"><a href="{{ route('admin.capaian-bulanan.edit', $item) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a><form action="{{ route('admin.capaian-bulanan.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus capaian ini? Bulan tersebut kembali menggunakan data otomatis.')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td></tr>
    @empty
        <tr><td colspan="6" class="text-center text-muted py-5">Belum ada capaian manual untuk tahun {{ $tahun }}. Halaman publik masih menggunakan data otomatis.</td></tr>
    @endforelse
    </tbody></table></div>
</div>
@endsection
