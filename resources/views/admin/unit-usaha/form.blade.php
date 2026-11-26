<div class="card">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="objek_pendapatan_id" class="form-label fw-semibold">Objek Pendapatan</label>
                <select id="objek_pendapatan_id" name="objek_pendapatan_id" class="form-select @error('objek_pendapatan_id') is-invalid @enderror" required>
                    <option value="">Pilih objek</option>
                    @foreach($objeks as $objek)
                        <option value="{{ $objek->id }}" @selected(old('objek_pendapatan_id', $unit?->objek_pendapatan_id) == $objek->id)>{{ $objek->nama }} · {{ $objek->tipe }}</option>
                    @endforeach
                </select>
                @error('objek_pendapatan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3">
                <label for="kode_unit" class="form-label fw-semibold">Kode Unit</label>
                <input id="kode_unit" name="kode_unit" value="{{ old('kode_unit', $unit?->kode_unit) }}" class="form-control @error('kode_unit') is-invalid @enderror" required>
                @error('kode_unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3">
                <label for="nama_unit" class="form-label fw-semibold">Nama Unit</label>
                <input id="nama_unit" name="nama_unit" value="{{ old('nama_unit', $unit?->nama_unit) }}" class="form-control @error('nama_unit') is-invalid @enderror" required>
                @error('nama_unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="jenis_unit" class="form-label fw-semibold">Jenis Unit</label>
                <input id="jenis_unit" name="jenis_unit" value="{{ old('jenis_unit', $unit?->jenis_unit) }}" class="form-control @error('jenis_unit') is-invalid @enderror" placeholder="Kios, lapak, ruang">
                @error('jenis_unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="penyewa_nama" class="form-label fw-semibold">Nama Penyewa</label>
                <input id="penyewa_nama" name="penyewa_nama" value="{{ old('penyewa_nama', $unit?->penyewa_nama) }}" class="form-control @error('penyewa_nama') is-invalid @enderror">
                @error('penyewa_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="penyewa_identitas" class="form-label fw-semibold">Identitas Penyewa</label>
                <input id="penyewa_identitas" name="penyewa_identitas" value="{{ old('penyewa_identitas', $unit?->penyewa_identitas) }}" class="form-control @error('penyewa_identitas') is-invalid @enderror">
                @error('penyewa_identitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="luas_m2" class="form-label fw-semibold">Luas m²</label>
                <input id="luas_m2" type="number" step="0.01" min="0" name="luas_m2" value="{{ old('luas_m2', $unit?->luas_m2) }}" class="form-control @error('luas_m2') is-invalid @enderror">
                @error('luas_m2')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="tarif_sewa" class="form-label fw-semibold">Tarif Sewa</label>
                <input id="tarif_sewa" type="number" step="0.01" min="0" name="tarif_sewa" value="{{ old('tarif_sewa', $unit?->tarif_sewa) }}" class="form-control @error('tarif_sewa') is-invalid @enderror">
                @error('tarif_sewa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                    @foreach(['aktif'=>'Aktif','kosong'=>'Kosong','nonaktif'=>'Nonaktif'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $unit?->status ?? 'kosong') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="kontrak_mulai" class="form-label fw-semibold">Kontrak Mulai</label>
                <input id="kontrak_mulai" type="date" name="kontrak_mulai" value="{{ old('kontrak_mulai', $unit?->kontrak_mulai?->format('Y-m-d')) }}" class="form-control @error('kontrak_mulai') is-invalid @enderror">
                @error('kontrak_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="kontrak_selesai" class="form-label fw-semibold">Kontrak Selesai</label>
                <input id="kontrak_selesai" type="date" name="kontrak_selesai" value="{{ old('kontrak_selesai', $unit?->kontrak_selesai?->format('Y-m-d')) }}" class="form-control @error('kontrak_selesai') is-invalid @enderror">
                @error('kontrak_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Simpan Unit Usaha</button>
            <a href="{{ route('admin.unit-usaha.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </div>
</div>