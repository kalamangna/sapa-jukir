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
            <div class="complaint-card-header"><h1>Form Aduan</h1><span aria-hidden="true">?</span></div>
            <div class="complaint-card-body">
                <p class="complaint-intro">Isi data diri dan detail laporan keluhan Anda. Kerahasiaan data pelapor dijaga oleh petugas.</p>
                @if(session('success'))<div class="complaint-success">{{ session('success') }}</div>@endif
                @if($errors->any())<div class="complaint-errors"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_token" value="{{ $formToken }}">
                    @error('form_token')<span style="color:#b91c1c;font-size:0.85rem;margin-bottom:8px;display:block;">{{ $message }}</span>@enderror
                    <div style="position:absolute;left:-9999px;opacity:0;pointer-events:none;" aria-hidden="true">
                        <label for="website">Website</label>
                        <input id="website" name="website" type="text" value="" tabindex="-1" autocomplete="off">
                    </div>
                    <label>
                        <span>Nama Lengkap</span>
                        <input name="nama" value="{{ old('nama') }}" placeholder="Andi Pratama" @error('nama') aria-invalid="true" style="border-color:#b91c1c;" @enderror required>
                        @error('nama')<span style="color:#b91c1c;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>NIK Pelapor</span>
                        <input name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" inputmode="numeric" maxlength="16" @error('nik') aria-invalid="true" style="border-color:#b91c1c;" @enderror required>
                        @error('nik')<span style="color:#b91c1c;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Nomor Telepon</span>
                        <input name="telepon" value="{{ old('telepon') }}" placeholder="081234567890" @error('telepon') aria-invalid="true" style="border-color:#b91c1c;" @enderror required>
                        @error('telepon')<span style="color:#b91c1c;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Nama Titik Parkir</span>
                        <input name="titik_parkir" value="{{ old('titik_parkir', $titikParkir?->nama) }}" placeholder="Pasar Sentral Sinjai" @error('titik_parkir') aria-invalid="true" style="border-color:#b91c1c;" @enderror>
                        @error('titik_parkir')<span style="color:#b91c1c;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Lokasi Parkir</span>
                        <input name="lokasi_parkir" value="{{ old('lokasi_parkir', $titikParkir?->alamat) }}" placeholder="Jl. Persatuan Raya" @error('lokasi_parkir') aria-invalid="true" style="border-color:#b91c1c;" @enderror required>
                        @error('lokasi_parkir')<span style="color:#b91c1c;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Jenis Aduan</span>
                        <select name="jenis" @error('jenis') aria-invalid="true" style="border-color:#b91c1c;" @enderror required>
                            <option value="">Pilih Jenis Aduan</option>
                            @foreach($jenisPengaduan as $value => $label)<option value="{{ $value }}" @selected(old('jenis') === $value)>{{ $label }}</option>@endforeach
                        </select>
                        @error('jenis')<span style="color:#b91c1c;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Detail Aduan</span>
                        <textarea name="detail" placeholder="Jelaskan kronologi kejadian dan waktu peristiwa" @error('detail') aria-invalid="true" style="border-color:#b91c1c;" @enderror required>{{ old('detail') }}</textarea>
                        @error('detail')<span style="color:#b91c1c;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Foto Bukti Aduan <small>Opsional. Format JPG, PNG, atau WEBP maksimal 5 MB.</small></span>
                        <input name="foto" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" @error('foto') aria-invalid="true" style="border-color:#b91c1c;" @enderror>
                        @error('foto')<span style="color:#b91c1c;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                    </label>
                    <button class="complaint-submit" type="submit">Kirim Aduan</button>
                    <p class="complaint-note">Catatan: Wajib isikan nomor telepon aktif untuk keperluan konfirmasi dari pihak Dinas Perhubungan.</p>
                </form>
            </div>
        </div>
    </main>
    <script>
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
