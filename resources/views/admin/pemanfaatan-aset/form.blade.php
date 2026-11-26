<div class="card">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="area_aset_id" class="form-label fw-semibold">Area aset</label>
                <select id="area_aset_id" name="area_aset_id" class="form-select @error('area_aset_id') is-invalid @enderror" required>
                    <option value="">Pilih area</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" @selected(old('area_aset_id', $pemanfaatan?->area_aset_id) == $area->id)>{{ $area->asetDaerah->nama_aset }} - {{ $area->nama_area }}</option>
                    @endforeach
                </select>
                @error('area_aset_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="pihak_pemanfaat" class="form-label fw-semibold">Pihak pemanfaat</label>
                <input id="pihak_pemanfaat" name="pihak_pemanfaat" value="{{ old('pihak_pemanfaat', $pemanfaatan?->pihak_pemanfaat) }}" class="form-control @error('pihak_pemanfaat') is-invalid @enderror" required>
                @error('pihak_pemanfaat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="jenis_kegiatan" class="form-label fw-semibold">Jenis kegiatan</label>
                <input id="jenis_kegiatan" name="jenis_kegiatan" value="{{ old('jenis_kegiatan', $pemanfaatan?->jenis_kegiatan) }}" class="form-control @error('jenis_kegiatan') is-invalid @enderror" required>
                @error('jenis_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3">
                <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal mulai</label>
                <input id="tanggal_mulai" type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $pemanfaatan?->tanggal_mulai?->format('Y-m-d')) }}" class="form-control @error('tanggal_mulai') is-invalid @enderror" required>
                @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3">
                <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal selesai</label>
                <input id="tanggal_selesai" type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $pemanfaatan?->tanggal_selesai?->format('Y-m-d')) }}" class="form-control @error('tanggal_selesai') is-invalid @enderror" required>
                @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="tarif_sewa" class="form-label fw-semibold">Tarif sewa</label>
                <input id="tarif_sewa" type="number" step="0.01" min="0" name="tarif_sewa" value="{{ old('tarif_sewa', $pemanfaatan?->tarif_sewa) }}" class="form-control @error('tarif_sewa') is-invalid @enderror">
                @error('tarif_sewa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="nilai_sewa" class="form-label fw-semibold">Nilai sewa</label>
                <input id="nilai_sewa" type="number" step="0.01" min="0" name="nilai_sewa" value="{{ old('nilai_sewa', $pemanfaatan?->nilai_sewa) }}" class="form-control @error('nilai_sewa') is-invalid @enderror" required>
                @error('nilai_sewa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                    @foreach(['direncanakan'=>'Direncanakan','aktif'=>'Aktif','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $pemanfaatan?->status ?? 'direncanakan') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan', $pemanfaatan?->keterangan) }}</textarea>
                @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Simpan Pemanfaatan</button>
            <a href="{{ route('admin.pemanfaatan-aset.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </div>
</div>