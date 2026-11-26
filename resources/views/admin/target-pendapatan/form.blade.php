<div class="card mb-4"><div class="card-header bg-white fw-bold">Data Target</div><div class="card-body"><div class="row g-3">
    <div class="col-md-6"><label for="sumber_pemasukan_id" class="form-label fw-semibold">Sumber Pendapatan</label><select id="sumber_pemasukan_id" name="sumber_pemasukan_id" class="form-select @error('sumber_pemasukan_id') is-invalid @enderror" required><option value="">Pilih sumber</option>@foreach($sumberPemasukans as $sumber)<option value="{{ $sumber->id }}" @selected(old('sumber_pemasukan_id', $target?->sumber_pemasukan_id) == $sumber->id)>{{ $sumber->kode }} - {{ $sumber->nama }}</option>@endforeach</select>@error('sumber_pemasukan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6"><label for="titik_parkir_id" class="form-label fw-semibold">Lokasi Sumber Pendapatan</label><select id="titik_parkir_id" name="titik_parkir_id" class="form-select @error('titik_parkir_id') is-invalid @enderror"><option value="">Pilih lokasi sumber pendapatan</option>@foreach($titikParkirs as $titik)<option value="{{ $titik->id }}" @selected(old('titik_parkir_id', $target?->titik_parkir_id) == $titik->id)>{{ $titik->nama }}</option>@endforeach</select>@error('titik_parkir_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    @if($target)
    <div class="col-md-6"><label for="objek_pendapatan_id" class="form-label fw-semibold">Objek Usaha / Aset / Pajak</label><select id="objek_pendapatan_id" name="objek_pendapatan_id" class="form-select @error('objek_pendapatan_id') is-invalid @enderror"><option value="">Target agregat sumber</option>@foreach($objekPendapatans as $objek)<option value="{{ $objek->id }}" @selected(old('objek_pendapatan_id', $target?->objek_pendapatan_id) == $objek->id)>{{ $objek->kode }} - {{ $objek->nama }}</option>@endforeach</select>@error('objek_pendapatan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    @endif
    <div class="col-md-4"><label for="tahun" class="form-label fw-semibold">Tahun</label><input id="tahun" name="tahun" type="number" min="2026" max="2100" value="{{ old('tahun', $target?->tahun ?? now()->year) }}" class="form-control @error('tahun') is-invalid @enderror" required>@error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-4"><label for="bulan" class="form-label fw-semibold">Bulan</label><select id="bulan" name="bulan" class="form-select @error('bulan') is-invalid @enderror" required><option value="">Pilih bulan</option>@foreach($bulan as $nomor => $nama)<option value="{{ $nomor }}" @selected(old('bulan', $target?->bulan) == $nomor)>{{ $nama }}</option>@endforeach</select>@error('bulan')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-4"><label for="target_display" class="form-label fw-semibold">Nilai Target</label><input id="target_display" type="text" inputmode="numeric" autocomplete="off" value="{{ number_format((float) old('target', $target?->target ?? 0), 0, ',', '.') }}" class="form-control @error('target') is-invalid @enderror" required><input id="target" name="target" type="hidden" value="{{ old('target', $target?->target ?? 0) }}">@error('target')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-12"><label for="catatan" class="form-label fw-semibold">Catatan</label><textarea id="catatan" name="catatan" rows="3" class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $target?->catatan) }}</textarea>@error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
</div></div></div><button class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Simpan Target</button> <a href="{{ route('admin.target-pendapatan.index') }}" class="btn btn-light">Batal</a>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const targetDisplay = document.getElementById('target_display');
    const target = document.getElementById('target');

    targetDisplay.addEventListener('input', function () {
        const digits = targetDisplay.value.replace(/\D/g, '');
        target.value = digits;
        targetDisplay.value = digits ? Number(digits).toLocaleString('id-ID') : '';
    });
});
</script>
@endpush