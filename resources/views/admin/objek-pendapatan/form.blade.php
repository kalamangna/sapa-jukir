<div class="card mb-4">
    <div class="card-body p-0">
        <div class="p-4 border-bottom bg-light-subtle">
            <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi umum</h6>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold" for="sumber_pemasukan_id">Kategori Sumber Pendapatan</label>
                    <select id="sumber_pemasukan_id" name="sumber_pemasukan_id" class="form-select @error('sumber_pemasukan_id') is-invalid @enderror" required>
                        <option value="">Pilih kategori sumber pendapatan</option>
                        @foreach($sumberPemasukans as $sumber)
                            <option value="{{ $sumber->id }}" @selected(old('sumber_pemasukan_id', $objek?->sumber_pemasukan_id) == $sumber->id)>{{ $sumber->kode }} - {{ $sumber->nama }}</option>
                        @endforeach
                    </select>
                    @error('sumber_pemasukan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" for="kode">Kode</label>
                    <input id="kode" name="kode" value="{{ old('kode', $objek?->kode) }}" class="form-control @error('kode') is-invalid @enderror" required>
                    @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" for="tipe">Jenis Objek</label>
                    <select id="tipe" name="tipe" class="form-select @error('tipe') is-invalid @enderror" required>
                        @foreach(['tempat_usaha'=>'Tempat usaha','aset_daerah'=>'Aset daerah','parkir_khusus'=>'Parkir khusus'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('tipe', $objek?->tipe ?? ($tipe ?? null)) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="p-4 border-top bg-light-subtle">
            <h6 class="mb-0 fw-bold"><i class="bi bi-geo-alt me-2 text-success"></i>Detail objek</h6>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold" for="nama">Nama objek</label>
                    <input id="nama" name="nama" value="{{ old('nama', $objek?->nama) }}" class="form-control @error('nama') is-invalid @enderror" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" for="alamat">Alamat</label>
                    <input id="alamat" name="alamat" value="{{ old('alamat', $objek?->alamat) }}" class="form-control @error('alamat') is-invalid @enderror">
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="nama_pengelola">Penanggung jawab</label>
                    <input id="nama_pengelola" name="nama_pengelola" value="{{ old('nama_pengelola', $objek?->nama_pengelola) }}" class="form-control @error('nama_pengelola') is-invalid @enderror">
                    @error('nama_pengelola')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="nomor_identitas">Identitas</label>
                    <input id="nomor_identitas" name="nomor_identitas" value="{{ old('nomor_identitas', $objek?->nomor_identitas) }}" class="form-control @error('nomor_identitas') is-invalid @enderror">
                    @error('nomor_identitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="jenis_usaha">Kategori Usaha</label>
                    <input id="jenis_usaha" name="jenis_usaha" value="{{ old('jenis_usaha', $objek?->jenis_usaha) }}" class="form-control @error('jenis_usaha') is-invalid @enderror" placeholder="Contoh: kios, los, lapak, tempat usaha">
                    @error('jenis_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="p-4 border-top bg-light-subtle">
            <h6 class="mb-0 fw-bold"><i class="bi bi-building me-2 text-warning"></i>Data Usaha dan Aset</h6>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="jenis_aset">Jenis aset</label>
                    <input id="jenis_aset" name="jenis_aset" value="{{ old('jenis_aset', $objek?->jenis_aset) }}" class="form-control @error('jenis_aset') is-invalid @enderror">
                    @error('jenis_aset')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="nomor_aset">Nomor aset</label>
                    <input id="nomor_aset" name="nomor_aset" value="{{ old('nomor_aset', $objek?->nomor_aset) }}" class="form-control @error('nomor_aset') is-invalid @enderror">
                    @error('nomor_aset')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="luas_m2">Luas m²</label>
                    <input id="luas_m2" name="luas_m2" type="number" min="0" step="0.01" value="{{ old('luas_m2', $objek?->luas_m2) }}" class="form-control @error('luas_m2') is-invalid @enderror">
                    @error('luas_m2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="tarif_sewa">Tarif sewa</label>
                    <input id="tarif_sewa" name="tarif_sewa" type="number" min="0" step="0.01" value="{{ old('tarif_sewa', $objek?->tarif_sewa) }}" class="form-control @error('tarif_sewa') is-invalid @enderror">
                    @error('tarif_sewa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="nomor_kontrak">Nomor kontrak</label>
                    <input id="nomor_kontrak" name="nomor_kontrak" value="{{ old('nomor_kontrak', $objek?->nomor_kontrak) }}" class="form-control @error('nomor_kontrak') is-invalid @enderror">
                    @error('nomor_kontrak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="kontrak_mulai">Kontrak mulai</label>
                    <input id="kontrak_mulai" name="kontrak_mulai" type="date" value="{{ old('kontrak_mulai', $objek?->kontrak_mulai?->format('Y-m-d')) }}" class="form-control @error('kontrak_mulai') is-invalid @enderror">
                    @error('kontrak_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="kontrak_selesai">Kontrak selesai</label>
                    <input id="kontrak_selesai" name="kontrak_selesai" type="date" value="{{ old('kontrak_selesai', $objek?->kontrak_selesai?->format('Y-m-d')) }}" class="form-control @error('kontrak_selesai') is-invalid @enderror">
                    @error('kontrak_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="p-4 border-top bg-light-subtle">
            <h6 class="mb-0 fw-bold"><i class="bi bi-graph-up-arrow me-2 text-danger"></i>Potensi dan Status</h6>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="potensi_bulanan">Potensi bulanan</label>
                    <input id="potensi_bulanan" name="potensi_bulanan" type="number" min="0" step="0.01" value="{{ old('potensi_bulanan', $objek?->potensi_bulanan ?? 0) }}" class="form-control @error('potensi_bulanan') is-invalid @enderror">
                    @error('potensi_bulanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="potensi_harian">Potensi harian</label>
                    <input id="potensi_harian" name="potensi_harian" type="number" min="0" step="0.01" value="{{ old('potensi_harian', $objek?->potensi_harian ?? 0) }}" class="form-control @error('potensi_harian') is-invalid @enderror">
                    @error('potensi_harian')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" for="status">Status</label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="aktif" @selected(old('status', $objek?->status ?? 'aktif') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status', $objek?->status) === 'nonaktif')>Tidak aktif</option>
                        <option value="bermasalah" @selected(old('status', $objek?->status) === 'bermasalah')>Bermasalah</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-footer bg-white border-top">
    <div class="d-flex justify-content-end align-items-center gap-2">
        <a href="{{ route('admin.objek-pendapatan.index') }}" class="btn btn-light border">Batal</a>
        <button class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Simpan Objek</button>
    </div>
</div>
