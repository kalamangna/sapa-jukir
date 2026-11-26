<div class="card mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-newspaper me-2 text-success"></i>Informasi Berita</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label for="judul" class="form-label fw-semibold">Judul Berita <span class="text-danger">*</span></label>
                <input id="judul" name="judul" value="{{ old('judul', $news->judul) }}" class="form-control @error('judul') is-invalid @enderror" required maxlength="255">
                @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="kategori" class="form-label fw-semibold">Kategori</label>
                <input id="kategori" name="kategori" value="{{ old('kategori', $news->kategori) }}" class="form-control @error('kategori') is-invalid @enderror" maxlength="100" placeholder="Contoh: Kegiatan">
                @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="ringkasan" class="form-label fw-semibold">Ringkasan</label>
                <textarea id="ringkasan" name="ringkasan" rows="2" maxlength="500" class="form-control @error('ringkasan') is-invalid @enderror" placeholder="Ringkasan singkat yang tampil pada kartu berita">{{ old('ringkasan', $news->ringkasan) }}</textarea>
                @error('ringkasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="published_at" class="form-label fw-semibold">Tanggal Publikasi</label>
                <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $news->published_at?->format('Y-m-d\TH:i')) }}" class="form-control @error('published_at') is-invalid @enderror">
                @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">Jadwalkan publikasi dengan tanggal mendatang, atau kosongkan untuk menerbitkan sekarang.</div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="form-check">
                    <input id="is_published" name="is_published" value="1" type="checkbox" class="form-check-input" @checked(old('is_published', $news->is_published))>
                    <label for="is_published" class="form-check-label fw-semibold">Terbitkan berita di halaman publik</label>
                </div>
            </div>
            <div class="col-12">
                <label for="gambar" class="form-label fw-semibold">Gambar Utama <span class="text-danger">{{ $news->exists ? '' : '*' }}</span></label>
                @if($news->exists)
                    <img src="{{ asset('storage/' . $news->gambar) }}" alt="{{ $news->judul }}" width="240" height="150" class="rounded object-fit-cover mb-2">
                @endif
                <input id="gambar" name="gambar" type="file" accept=".jpg,.jpeg,.png,.webp,image/*" class="form-control @error('gambar') is-invalid @enderror" {{ $news->exists ? '' : 'required' }}>
                @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">JPG, JPEG, PNG, atau WEBP. Maksimal 4 MB.</div>
            </div>
            <div class="col-12">
                <label for="konten" class="form-label fw-semibold">Isi Berita <span class="text-danger">*</span></label>
                <textarea id="konten" name="konten" rows="14" class="form-control @error('konten') is-invalid @enderror" required>{{ old('konten', $news->konten) }}</textarea>
                @error('konten')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Simpan Berita</button>
    <a href="{{ route('admin.news.index') }}" class="btn btn-light">Batal</a>
</div>
