<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titikParkir->nama }} | SAPA JUKIR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --detail-ink: #172033; --detail-muted: #697386; --detail-line: #dce2ea; --detail-accent: #087f5b; }
        body { margin: 0; color: var(--detail-ink); background: #fff; font-family: 'DM Sans', sans-serif; }
        .public-header { z-index: 1000; }
        .location-page .leaflet-pane,
        .location-page .leaflet-control { z-index: 400; }
        .location-page { width: min(960px, calc(100% - 32px)); margin: 42px auto 64px; }
        .location-back { display: inline-block; margin-bottom: 24px; color: var(--detail-accent); font-size: .9rem; font-weight: 700; }
        .location-top { display: grid; grid-template-columns: minmax(0, 1fr) minmax(320px, 1fr); gap: 38px; align-items: start; }
        .location-summary { text-align: center; }
        .location-photo { width: 100%; max-width: 420px; height: 260px; margin: 0 auto 18px; border-radius: 4px; object-fit: cover; background: #edf2f5; }
        .location-photo-fallback { display: grid; place-items: center; color: #78a095; font-size: 3rem; }
        .location-summary h1 { margin: 0 0 6px; font-size: clamp(1.35rem, 2.5vw, 1.85rem); text-transform: uppercase; }
        .location-address { margin: 0; color: var(--detail-muted); font-size: .88rem; font-style: italic; }
        .location-map { width: 100%; height: 420px; border: 1px solid #e2e7ed; }
        .location-map-note { margin: 8px 0 0; text-align: right; font-size: .74rem; color: var(--detail-muted); }
        .location-table { width: 100%; margin-top: 28px; border-collapse: collapse; table-layout: fixed; font-size: .88rem; }
        .location-table th, .location-table td { padding: 12px 8px; border-bottom: 1px solid var(--detail-line); text-align: left; vertical-align: middle; }
        .location-table thead th { color: #2c3748; font-weight: 500; }
        .location-table tbody td:nth-child(1) { text-align: left; padding-top: 8px; padding-bottom: 8px; }
        .location-table tbody td:nth-child(2) { text-align: left; }
        .location-table tbody td:nth-child(3) { text-align: left; }
        .location-table tbody td:nth-child(4) { text-align: left; }
        .location-table thead th:nth-child(1), .location-table tbody td:nth-child(1) { width: 80px; }
        .location-table thead th:nth-child(2), .location-table tbody td:nth-child(2) { width: 32%; }
        .location-table thead th:nth-child(3), .location-table tbody td:nth-child(3) { width: 22%; }
        .location-table thead th:nth-child(4), .location-table tbody td:nth-child(4) { width: 20%; }
        .location-value { font-weight: 600; }
        .status-badge { display: inline-block; padding: 2px 7px; color: #fff; background: var(--detail-accent); font-size: .78rem; font-weight: 700; }
        .location-section { margin-top: 42px; padding: 22px 30px 14px; background: #f8fafb; }
        .location-section h2 { margin: 0 0 16px; font-size: 1.05rem; }
        .officer-grid { display: grid; grid-template-columns: 160px minmax(0, 1fr); gap: 28px; align-items: start; }
        .officer-photo { width: 118px; height: 142px; object-fit: cover; border: 2px solid #c7dfe8; background: #e8f0f2; }
        .officer-photo-fallback { display: grid; place-items: center; color: #73949c; font-size: 2.5rem; }
        .staff-photo { width: 70px; height: 70px; object-fit: cover; border-radius: 50%; border: 2px solid #dfe8ee; background: #eef4f6; display: block; margin: 0 auto; transform: translateY(2px); }
        .staff-photo-fallback { display: grid; place-items: center; width: 70px; height: 70px; border-radius: 50%; background: #e7f0f2; color: #6c8690; font-size: 1.2rem; border: 2px solid #dfe8ee; margin: 0 auto; transform: translateY(2px); }
        .target-time-group { display: flex; flex-direction: column; gap: 2px; line-height: 1.35; }
        .target-time-label { font-weight: 700; }
        .empty-note { color: var(--detail-muted); font-size: .9rem; }
        @media (max-width: 700px) {
            .location-page { width: min(100% - 24px, 560px); margin-top: 24px; }
            .location-top { grid-template-columns: 1fr; gap: 24px; }
            .location-map { height: 260px; }
            .location-section { padding: 18px 14px 10px; }
            .officer-grid { grid-template-columns: 1fr; gap: 12px; }
        }
    </style>
</head>
<body>
    <header class="public-header">
        <div class="container public-nav">
            <a class="public-brand" href="{{ route('home') }}">
                <span class="brand-mark">SI</span>
                <span>SAPA JUKIR</span>
            </a>

            <button class="nav-toggle" type="button" aria-label="Buka menu" aria-expanded="false">&#9776;</button>

            <nav class="nav-links" aria-label="Navigasi utama">
                <a href="{{ route('home') }}#top">Beranda</a>
                <a href="{{ route('home') }}#features">Fitur Utama</a>
                <a href="{{ route('home') }}#achievement">Pencapaian</a>
                <a href="{{ route('home') }}#area">Area Pendapatan</a>
                <a href="{{ route('home') }}#about">Tentang</a>
                <a href="{{ route('gallery') }}">Galeri</a>
                <a href="{{ route('news.index') }}">Berita</a>
                <a href="{{ route('skm') }}">SKM</a>
                <a href="{{ route('login') }}">Masuk</a>
                <div class="public-nav-actions">
                    <button class="theme-toggle" type="button" aria-label="Ubah mode tampilan" aria-pressed="false" title="Mode gelap">
                        <span class="theme-toggle-icon" aria-hidden="true">☀️</span>
                    </button>
                    <a class="complaint-link" href="{{ route('pengaduan.create', ['titik_parkir' => $titikParkir->id]) }}">&#128172; Adukan Jukir di Lokasi Ini</a>
                </div>
            </nav>
        </div>
    </header>

    <main class="location-page">
        <a class="location-back" href="{{ route('home') }}">&larr; Kembali ke Peta Lokasi</a>

        <section class="location-top" aria-label="Detail lokasi {{ $titikParkir->nama }}">
            <div class="location-summary">
                @if($titikParkir->foto)
                    <img class="location-photo" src="{{ asset('storage/' . $titikParkir->foto) }}" alt="Foto {{ $titikParkir->nama }}">
                @else
                    <div class="location-photo location-photo-fallback" role="img" aria-label="Foto lokasi belum tersedia">&#9673;</div>
                @endif
                <h1>{{ $titikParkir->nama }}</h1>
                <p class="location-address">{{ $titikParkir->alamat }}, Kelurahan {{ $titikParkir->kelurahan?->nama ?? '-' }}, Kecamatan {{ $titikParkir->kecamatan?->nama ?? '-' }}</p>
                @php($namaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'])
                @php($targetLokasi = (float) ($titikParkir->penempatanJukirs
                    ->filter(fn ($penempatan) => $penempatan->status === 'aktif' && $penempatan->role === 'koordinator')
                    ->first()->target_per_hari ?? 0))
                <table class="location-table">
                    <tr><th>Status</th><td><span class="status-badge">{{ ucfirst($titikParkir->status ?? 'aktif') }}</span></td></tr>
                    <tr><th>Jenis Lokasi</th><td class="location-value">{{ $titikParkir->jenisParkir?->nama ?? 'Lokasi Parkir' }}</td></tr>
                    @forelse($titikParkir->jenisParkir?->tarifs ?? [] as $tarif)
                        <tr><th>Tarif {{ ucfirst($tarif->jenis_kendaraan) }}</th><td>Rp {{ number_format($tarif->nominal, 0, ',', '.') }},-</td></tr>
                        @if(strtolower(trim((string) $tarif->jenis_kendaraan)) === 'motor')
                            <tr>
                                <th>Target</th>
                                <td>
                                    @if($targetLokasi > 0)
                                        Rp {{ number_format($targetLokasi, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr><th>Tarif</th><td>-</td></tr>
                        @if($targetLokasi > 0)
                            <tr>
                                <th>Target</th>
                                <td>Rp {{ number_format($targetLokasi, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    @endforelse
                </table>
            </div>

            <div>
                <div id="location-map" class="location-map" aria-label="Peta {{ $titikParkir->nama }}"></div>
                <p class="location-map-note">&copy; OpenStreetMap contributors</p>
            </div>
        </section>

        <section class="location-section" aria-label="Data petugas lokasi">
            @php($penempatansAktif = $titikParkir->penempatanJukirs
                ->filter(fn ($penempatan) => $penempatan->status === 'aktif')
                ->sortBy(fn ($penempatan) => $penempatan->role === 'koordinator' ? 0 : 1)
                ->values())
            @if($penempatansAktif->isNotEmpty())
                <h2>Petugas Lokasi</h2>
                <div class="table-responsive">
                    <table class="location-table" style="margin-top: 12px;">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Target / Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penempatansAktif as $penempatan)
                                <tr>
                                    <td>
                                        @if($penempatan->jukir?->foto)
                                            <img class="staff-photo" src="{{ asset('storage/' . $penempatan->jukir->foto) }}" alt="Foto {{ $penempatan->jukir->nama }}">
                                        @else
                                            <div class="staff-photo-fallback" aria-label="Foto belum tersedia">👤</div>
                                        @endif
                                    </td>
                                    <td class="location-value">{{ $penempatan->jukir?->nama ?? '-' }}</td>
                                    <td>
                                        @if($penempatan->role === 'koordinator')
                                            <span class="status-badge">Koordinator</span>
                                        @elseif($penempatan->role === 'anggota')
                                            <span class="status-badge" style="background:#4b5563;">Anggota</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="target-time-group">
                                            <div><span class="target-time-label">Target:</span>
                                                @php($targetUntukBaris = $penempatan->role === 'koordinator'
                                                    ? ($penempatan->target_per_hari ?? null)
                                                    : ($titikParkir->penempatanJukirs
                                                        ->filter(fn ($item) => $item->status === 'aktif' && $item->role === 'koordinator')
                                                        ->first()->target_per_hari ?? null))
                                                @if($targetUntukBaris !== null)
                                                    Rp {{ number_format((float) $targetUntukBaris, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                            <div><span class="target-time-label">Waktu:</span> {{ $penempatan->waktu_kerja ?? '-' }}</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h2>Petugas Lokasi</h2>
                <p class="empty-note">Belum ada petugas aktif yang ditempatkan di lokasi ini.</p>
            @endif
        </section>
    </main>

    <footer class="public-footer">
        <div class="container footer-inner">
            <div class="footer-copy">&copy; SAPA JUKIR {{ date('Y') }}</div>
            <p>UPTD Terminal dan Perparkiran<br>DINAS PERHUBUNGAN KABUPATEN SINJAI</p>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @if($titikParkir->latitude !== null && $titikParkir->longitude !== null)
        <script>
            const locationCoordinates = [{{ (float) $titikParkir->latitude }}, {{ (float) $titikParkir->longitude }}];
            const locationName = @json($titikParkir->nama);
            const locationAddress = @json($titikParkir->alamat ?: 'Alamat tidak tersedia');
            const locationMap = L.map('location-map').setView(locationCoordinates, 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(locationMap);
            L.marker(locationCoordinates).addTo(locationMap).bindPopup(`
                <strong>${locationName}</strong><br>
                <span>Lokasi: ${locationAddress}</span><br>
                <a href="https://www.google.com/maps/search/?api=1&query=${locationCoordinates[0]},${locationCoordinates[1]}" target="_blank" rel="noopener noreferrer">Buka di Google Maps</a>
            `).openPopup();
        </script>
    @else
        <script>document.getElementById('location-map').textContent = 'Koordinat lokasi belum tersedia.';</script>
    @endif
    <script>
        const detailNavToggle = document.querySelector('.nav-toggle');
        const detailNav = document.querySelector('.nav-links');

        detailNavToggle?.addEventListener('click', () => {
            const isOpen = detailNav.classList.toggle('is-open');
            detailNavToggle.setAttribute('aria-expanded', isOpen);
        });

        detailNav?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                detailNav.classList.remove('is-open');
                detailNavToggle?.setAttribute('aria-expanded', 'false');
            });
        });
    </script>
</body>
</html>
