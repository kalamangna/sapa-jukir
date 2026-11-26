<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-seo title="Form Aduan | SAPA JUKIR Sinjai" description="Sampaikan pengaduan Anda tentang layanan parkir dan retribusi di Kabupaten Sinjai." />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .complaint-field-error {
            display: block;
            margin-top: 4px;
            color: #b91c1c;
            font-size: 0.85rem;
        }
        .complaint-input-invalid {
            border-color: #dc2626 !important;
        }
        .dark-theme .complaint-field-error {
            color: #fca5a5;
        }
        .dark-theme .complaint-input-invalid {
            border-color: #f87171 !important;
        }
    </style>
</head>
<body class="public-site complaint-page">
    <header class="public-header">
        <div class="container public-nav">
            <a class="public-brand" href="{{ route('home') }}"><img src="{{ asset('images/logo-sapa-jukir.png') }}" alt="Logo SAPA JUKIR" style="height: 32px; width: auto; object-fit: contain;"><span>SAPA JUKIR</span></a>
            <a class="secondary-btn" href="{{ route('home') }}">Kembali ke Beranda</a>
        </div>
    </header>
    <main class="complaint-main">
        <div class="complaint-backdrop" aria-hidden="true"></div>
        <div class="complaint-card">
            <div class="complaint-card-header"><h1>Form Aduan</h1></div>
            <div class="complaint-card-body">
                <p class="complaint-intro">Isi data diri dan detail laporan keluhan Anda. Kerahasiaan data pelapor dijaga oleh petugas.</p>
                @if(session('success'))<div class="complaint-success" role="status">{{ session('success') }}</div>@endif
                @if($errors->any())<div class="complaint-errors" role="alert"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_token" value="{{ $formToken }}">
                    @error('form_token')<span class="complaint-field-error" style="margin-bottom:8px;">{{ $message }}</span>@enderror
                    <div style="position:absolute;left:-9999px;opacity:0;pointer-events:none;" aria-hidden="true">
                        <label for="website">Website</label>
                        <input id="website" name="website" type="text" value="" tabindex="-1" autocomplete="off">
                    </div>
                    <label>
                        <span>Nama Lengkap</span>
                        <input name="nama" value="{{ old('nama') }}" placeholder="Andi Pratama" class="@error('nama') complaint-input-invalid @enderror" @error('nama') aria-invalid="true" @enderror required>
                        @error('nama')<span class="complaint-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>NIK Pelapor</span>
                        <input name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" inputmode="numeric" maxlength="16" class="@error('nik') complaint-input-invalid @enderror" @error('nik') aria-invalid="true" @enderror required>
                        @error('nik')<span class="complaint-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Nomor Telepon</span>
                        <input name="telepon" value="{{ old('telepon') }}" placeholder="081234567890" class="@error('telepon') complaint-input-invalid @enderror" @error('telepon') aria-invalid="true" @enderror required>
                        @error('telepon')<span class="complaint-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Nama Titik Parkir</span>
                        <input name="titik_parkir" value="{{ old('titik_parkir', $titikParkir?->nama) }}" placeholder="Pasar Sentral Sinjai" class="@error('titik_parkir') complaint-input-invalid @enderror" @error('titik_parkir') aria-invalid="true" @enderror>
                        @error('titik_parkir')<span class="complaint-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Lokasi Parkir</span>
                        <input name="lokasi_parkir" value="{{ old('lokasi_parkir', $titikParkir?->alamat) }}" placeholder="Jl. Persatuan Raya" class="@error('lokasi_parkir') complaint-input-invalid @enderror" @error('lokasi_parkir') aria-invalid="true" @enderror required>
                        @error('lokasi_parkir')<span class="complaint-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Jenis Aduan</span>
                        <select name="jenis" class="@error('jenis') complaint-input-invalid @enderror" @error('jenis') aria-invalid="true" @enderror required>
                            <option value="">Pilih Jenis Aduan</option>
                            @foreach($jenisPengaduan as $value => $label)<option value="{{ $value }}" @selected(old('jenis') === $value)>{{ $label }}</option>@endforeach
                        </select>
                        @error('jenis')<span class="complaint-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Detail Aduan</span>
                        <textarea name="detail" placeholder="Jelaskan kronologi kejadian dan waktu peristiwa" class="@error('detail') complaint-input-invalid @enderror" @error('detail') aria-invalid="true" @enderror required>{{ old('detail') }}</textarea>
                        @error('detail')<span class="complaint-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Foto Bukti Aduan <small>Opsional. Format JPG, PNG, atau WEBP maksimal 5 MB.</small></span>
                        <input name="foto" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="@error('foto') complaint-input-invalid @enderror" @error('foto') aria-invalid="true" @enderror>
                        @error('foto')<span class="complaint-field-error">{{ $message }}</span>@enderror
                    </label>
                    <button class="complaint-submit" type="submit">Kirim Aduan</button>
                    <p class="complaint-note">Catatan: Wajib isikan nomor telepon aktif untuk keperluan konfirmasi dari pihak Dinas Perhubungan.</p>
                </form>
            </div>
        </div>
    </main>
    <script>
        const storedTheme = localStorage.getItem('public-theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const isDarkTheme = storedTheme ? storedTheme === 'dark' : prefersDark;
        document.documentElement.classList.toggle('dark-theme', isDarkTheme);
        document.body.classList.toggle('dark-theme', isDarkTheme);

        const complaintForm = document.querySelector('form[action="{{ route('pengaduan.store') }}"]');
        const complaintSubmitButton = complaintForm?.querySelector('.complaint-submit');

        complaintForm?.addEventListener('submit', () => {
            if (!complaintSubmitButton) return;
            complaintSubmitButton.disabled = true;
            complaintSubmitButton.textContent = 'Mengirim...';
        });
    </script>
</body>
</html>
