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
            <a class="public-brand" href="{{ route('home') }}"><span class="brand-mark">SJ</span><span>SAPA JUKIR</span></a>
            <a class="secondary-btn" href="{{ route('home') }}">Kembali ke Beranda</a>
        </div>
    </header>
    <main class="complaint-main">
        <div class="complaint-backdrop" aria-hidden="true"></div>
        <div class="complaint-card">
            <div class="complaint-card-header"><h1>Form Aduan</h1><span aria-hidden="true">?</span></div>
            <div class="complaint-card-body">
                <p class="complaint-intro">Harap mengisi data diri beserta laporan keluhan. Kami senantiasa selalu menjaga privasi dan kerahasiaan data Anda.</p>
                @if(session('success'))<div class="complaint-success">{{ session('success') }}</div>@endif
                @if($errors->any())<div class="complaint-errors"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <label><span>Nama Lengkap</span><input name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap" required></label>
                    <label><span>NIK Pelapor</span><input name="nik" value="{{ old('nik') }}" placeholder="NIK Pelapor (16 digit)" inputmode="numeric" maxlength="16" required></label>
                    <label><span>Nomor Telepon/WA</span><input name="telepon" value="{{ old('telepon') }}" placeholder="Nomor Telepon/WA" required></label>
                    <label><span>Titik Parkir (Nama Toko/Kantor)</span><input name="titik_parkir" value="{{ old('titik_parkir', $titikParkir?->nama) }}" placeholder="Titik Parkir (Nama Toko/Kantor)"></label>
                    <label><span>Lokasi Parkir (Nama Jalan)</span><input name="lokasi_parkir" value="{{ old('lokasi_parkir', $titikParkir?->alamat) }}" placeholder="Lokasi Parkir (Nama Jalan)" required></label>
                    <label><span>Jenis Aduan</span><select name="jenis" required><option value="">Pilih Jenis Aduan</option>@foreach($jenisPengaduan as $value => $label)<option value="{{ $value }}" @selected(old('jenis') === $value)>{{ $label }}</option>@endforeach</select></label>
                    <label><span>Isi Detail Aduan</span><textarea name="detail" placeholder="Isi Detail Aduan" required>{{ old('detail') }}</textarea></label>
                    <label><span>Foto Aduan <small>(Opsional, JPG/PNG/WEBP maksimal 5 MB)</small></span><input name="foto" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"></label>
                    <button class="complaint-submit" type="submit">Submit</button>
                    <p class="complaint-note">Catatan: Wajib isikan nomor telepon Anda untuk keperluan konfirmasi dari pihak Dinas Perhubungan.</p>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
