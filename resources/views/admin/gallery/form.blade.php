<div class="card mb-4">
    <div class="card-header bg-white border-bottom py-3"><h6 class="mb-0 fw-bold"><i class="bi bi-images me-2 text-success"></i>Informasi Dokumentasi</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label for="judul" class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                <input id="judul" name="judul" value="{{ old('judul', $gallery?->judul) }}" class="form-control @error('judul') is-invalid @enderror" required>
                @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="kategori" class="form-label fw-semibold">Kategori</label>
                <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriOptions as $kategoriOption)
                        <option value="{{ $kategoriOption }}" @selected(old('kategori', $gallery?->kategori) === $kategoriOption)>{{ $kategoriOption }}</option>
                    @endforeach
                </select>
                @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="tanggal_kegiatan" class="form-label fw-semibold">Tanggal Kegiatan</label>
                <input id="tanggal_kegiatan" name="tanggal_kegiatan" type="date" value="{{ old('tanggal_kegiatan', $gallery?->tanggal_kegiatan?->format('Y-m-d')) }}" class="form-control @error('tanggal_kegiatan') is-invalid @enderror">
                @error('tanggal_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                <input id="urutan" name="urutan" type="number" min="0" value="{{ old('urutan', $gallery?->urutan ?? 0) }}" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input id="is_active" name="is_active" value="1" type="checkbox" class="form-check-input" @checked(old('is_active', $gallery?->is_active ?? true))>
                    <label for="is_active" class="form-check-label">Tampilkan di halaman publik</label>
                </div>
            </div>
            <div class="col-12">
                <label for="gambar" class="form-label fw-semibold">Foto Dokumentasi <span class="text-danger">{{ $gallery ? '' : '*' }}</span></label>
                <div class="gallery-upload-fields" data-gallery-upload-fields data-existing-count="{{ $gallery ? $galleryImages->count() : 0 }}">
                    @for($photoSlot = 1; $photoSlot <= 3; $photoSlot++)
                        <label class="gallery-upload-field" for="gambar-{{ $photoSlot }}">
                            <div class="gallery-slot-preview" data-gallery-preview-slot style="display:grid;place-items:center;width:100%;height:100px;">
                                @if($gallery && $galleryImages->get($photoSlot - 1))
                                    <img src="{{ asset('storage/' . $galleryImages->get($photoSlot - 1)) }}" alt="{{ $gallery->judul }}" style="display:block;width:150px;height:100px;max-width:150px;object-fit:cover;">
                                @endif
                            </div>
                            <span>Foto {{ $photoSlot }}</span>
                            <input id="gambar-{{ $photoSlot }}" name="gambar[]" type="file" accept=".jpg,.jpeg,.png,.webp,image/*" class="form-control @error('gambar') is-invalid @enderror" {{ $gallery ? '' : ($photoSlot === 1 ? 'required' : '') }} data-gallery-upload>
                        </label>
                    @endfor
                </div>
                <div class="form-text">{{ $gallery ? 'Tambahkan foto baru jika diperlukan. ' : 'Pilih maksimal 3 foto untuk satu kegiatan. ' }}Maksimal total 3 foto per kegiatan. JPG, JPEG, PNG, atau WEBP. Maksimal 4 MB per foto.</div>
                @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $gallery?->deskripsi) }}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-2"><button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Simpan Dokumentasi</button><a href="{{ route('admin.gallery.index') }}" class="btn btn-light">Batal</a></div>

<script>
    const galleryUploads = [...document.querySelectorAll('[data-gallery-upload]')];
    const galleryUploadFields = document.querySelector('[data-gallery-upload-fields]');

    galleryUploads.forEach((galleryUpload) => galleryUpload.addEventListener('change', () => {
        const existingCount = Number(galleryUploadFields?.dataset.existingCount || 0);
        const selectedFiles = galleryUploads.flatMap((input) => [...input.files]);
        const remainingSlots = Math.max(0, 3 - existingCount);

        if (selectedFiles.length > remainingSlots) {
            alert(`Maksimal total 3 foto per kegiatan. Anda masih dapat memilih ${remainingSlots} foto.`);
            galleryUpload.value = '';
            return;
        }

        galleryUploads.forEach((input) => {
            const preview = input.closest('.gallery-upload-field')?.querySelector('[data-gallery-preview-slot]');
            if (!preview || !input.files[0]) return;
            const img = document.createElement('img');
            img.src = URL.createObjectURL(input.files[0]);
            img.alt = 'Preview ' + input.files[0].name;
            img.style.cssText = 'display:block;width:150px;height:100px;max-width:150px;object-fit:cover;';
            preview.replaceChildren(img);
        });
    }));
</script>
