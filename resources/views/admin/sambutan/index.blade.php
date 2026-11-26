@extends('layouts.admin')

@section('title', 'Halaman Sambutan')
@section('page-title', 'Halaman Sambutan')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-1">Halaman Sambutan</h4>
    <p class="text-muted mb-0">Atur warna background, foto publik, dan tampilkan pada halaman publik.</p>
</div>

<form action="{{ $sambutan ? route('admin.sambutan.update', $sambutan) : route('admin.sambutan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($sambutan) @method('PUT') @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-lg-5">
            <div class="row g-4">
                <div class="col-12">
                    <div class="border rounded-4 p-3 bg-light-subtle">
                        <label for="foto_kadis" class="form-label fw-semibold">Foto halaman sambutan publik</label>
                        <div class="d-flex justify-content-center mb-3">
                            @if($sambutan?->foto_kadis || $sambutan?->foto)
                                <img src="{{ asset('storage/' . ($sambutan->foto_kadis ?? $sambutan->foto)) }}" alt="Foto sambutan publik" class="img-fluid border border-3 border-white shadow-sm" style="display:block; width:100%; max-width:none; height:auto; max-height:520px; object-fit:contain; background:#fff; border-radius:18px;">
                            @else
                                <div class="d-flex align-items-center justify-content-center text-muted bg-white border border-2 border-dashed" style="width:100%; height:420px; border-radius:18px;">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            @endif
                        </div>
                        <input id="foto_kadis" name="foto_kadis" type="file" accept=".jpg,.jpeg,.png,.webp,image/*" class="form-control @error('foto_kadis') is-invalid @enderror" onchange="this.form.submit()">
                        <div class="form-text mt-2">Format JPG, PNG, WEBP. Maksimal 2 MB.</div>
                        @error('foto_kadis')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="border rounded-4 p-3 bg-light-subtle">
                        <label for="background_color" class="form-label fw-semibold">Warna Background</label>
                        <input id="background_color" name="background_color" type="color" value="{{ old('background_color', $sambutan?->background_color ?: '#3d2df5') }}" class="form-control form-control-color mb-2 @error('background_color') is-invalid @enderror" title="Pilih warna background sambutan" style="max-width: 88px; height: 48px;">
                        @error('background_color')<div class="invalid-feedback d-block mb-2">{{ $message }}</div>@enderror

                        <div class="form-check">
                            <input id="is_active" name="is_active" value="1" type="checkbox" class="form-check-input" @checked(old('is_active', $sambutan?->is_active ?? true))>
                            <label for="is_active" class="form-check-label">Tampilkan pada halaman publik</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-white border-0 px-4 px-lg-5 py-3">
            <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Simpan Pengaturan</button>
        </div>
    </div>
</form>
@endsection
