@extends('layouts.admin')

@section('title', 'Pengaturan Halaman Publik')
@section('page-title', 'SEO & Pengaturan Halaman Publik')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-1">Pengaturan Halaman Publik</h4>
    <p class="text-muted mb-0">Atur konten utama halaman depan, foto hero, jam pelayanan, lokasi, kontak WhatsApp, Instagram, dan email.</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show auto-dismiss-alert" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-lg-4">
                    <label for="hero_image" class="form-label fw-semibold">Foto Hero</label>
                    @if($settings?->hero_image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $settings->hero_image) }}" alt="Hero image" class="img-fluid rounded border" style="max-height: 220px; object-fit: cover;">
                        </div>
                    @endif
                    <input id="hero_image" name="hero_image" type="file" accept=".jpg,.jpeg,.png,.webp,image/*" class="form-control @error('hero_image') is-invalid @enderror">
                    <div class="form-text">Format JPG, PNG, WEBP. Maksimal 2 MB.</div>
                    @error('hero_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-8">
                    <div class="mb-3">
                        <label for="hero_title" class="form-label fw-semibold">Judul Hero</label>
                        <input id="hero_title" name="hero_title" value="{{ old('hero_title', $settings?->hero_title ?? 'Selamat Datang di SAPA JUKIR') }}" class="form-control @error('hero_title') is-invalid @enderror" placeholder="Contoh: Selamat Datang di SAPA JUKIR">
                        @error('hero_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="hero_description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea id="hero_description" name="hero_description" rows="5" class="form-control @error('hero_description') is-invalid @enderror" placeholder="Masukkan deskripsi halaman publik">{{ old('hero_description', $settings?->hero_description ?? 'SAPA JUKIR adalah aplikasi yang bertujuan untuk membantu proses pencatatan dan monitoring kegiatan pengelolaan perparkiran di Kabupaten Sinjai.') }}</textarea>
                        @error('hero_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="service_hours" class="form-label fw-semibold">Waktu Pelayanan</label>
                    <input id="service_hours" name="service_hours" value="{{ old('service_hours', $settings?->service_hours ?? '08.00 – 16.00 WITA') }}" class="form-control @error('service_hours') is-invalid @enderror" placeholder="08.00 – 16.00 WITA">
                    @error('service_hours')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="location_name" class="form-label fw-semibold">Lokasi</label>
                    <input id="location_name" name="location_name" value="{{ old('location_name', $settings?->location_name ?? 'Jl. Bulu Pattuku, Kel. Bongki, Kec. Sinjai Utara, Kab. Sinjai') }}" class="form-control @error('location_name') is-invalid @enderror" placeholder="Jl. Bulu Pattuku, Kel. Bongki, Kec. Sinjai Utara, Kab. Sinjai">
                    @error('location_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="location_url" class="form-label fw-semibold">Link Lokasi (Google Maps)</label>
                    <input id="location_url" name="location_url" value="{{ old('location_url', $settings?->location_url ?? 'https://maps.google.com/?q=Dinas+Perhubungan+Kabupaten+Sinjai') }}" class="form-control @error('location_url') is-invalid @enderror" placeholder="https://maps.google.com/?q=...">
                    @error('location_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="whatsapp_number" class="form-label fw-semibold">Nomor WhatsApp</label>
                    <input id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $settings?->whatsapp_number ?? '089 990 843 43') }}" class="form-control @error('whatsapp_number') is-invalid @enderror" placeholder="089 990 843 43">
                    @error('whatsapp_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="whatsapp_url" class="form-label fw-semibold">Link WhatsApp</label>
                    <input id="whatsapp_url" name="whatsapp_url" value="{{ old('whatsapp_url', $settings?->whatsapp_url ?? 'https://wa.me/628999084343') }}" class="form-control @error('whatsapp_url') is-invalid @enderror" placeholder="https://wa.me/628999084343">
                    @error('whatsapp_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="instagram" class="form-label fw-semibold">Instagram</label>
                    <input id="instagram" name="instagram" value="{{ old('instagram', $settings?->instagram ?? '@dishub_sinjai') }}" class="form-control @error('instagram') is-invalid @enderror" placeholder="@dishub_sinjai">
                    @error('instagram')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $settings?->email ?? 'dishub@sinjai.go.id') }}" class="form-control @error('email') is-invalid @enderror" placeholder="dishub@sinjai.go.id">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer bg-white">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-lg me-1"></i>
                Simpan Pengaturan
            </button>
        </div>
    </div>
</form>
@endsection
