<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-seo :title="$titikParkir->nama.' | SAPA JUKIR'" :description="'Lokasi parkir '.$titikParkir->nama.' di '.$titikParkir->alamat.', Kabupaten Sinjai.'" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --detail-ink: #172033; --detail-muted: #697386; --detail-line: #dce2ea; --detail-accent: #087f5b; }
        body { margin: 0; color: var(--public-ink, var(--detail-ink)); font-family: 'DM Sans', sans-serif; }
        .public-header { z-index: 1000; }
        .location-page .leaflet-pane,
        .location-page .leaflet-control { z-index: 400; }
        .location-page { width: min(960px, calc(100% - 32px)); margin: 42px auto 64px; }
        .location-back { display: inline-flex; align-items: center; min-height: 40px; margin-bottom: 24px; border-radius: 8px; color: var(--detail-accent); font-size: .9rem; font-weight: 700; text-decoration: none; }
        .location-back:hover { text-decoration: underline; }
        .location-back:focus-visible { outline: 2px solid var(--blue, #1a5dff); outline-offset: 2px; }
        .dark-theme .location-back { color: #34d399; }
        .location-top { display: grid; grid-template-columns: minmax(0, 1fr) minmax(320px, 1fr); gap: 38px; align-items: start; }
        .location-summary { text-align: center; }
        .location-photo { width: 100%; max-width: 420px; height: 260px; margin: 0 auto 18px; border-radius: 14px; border: 1px solid var(--public-line, var(--detail-line)); object-fit: cover; background: var(--public-card, #edf2f5); }
        .location-photo-fallback { display: grid; place-items: center; color: var(--public-muted, #78a095); font-size: 3rem; }
        .location-summary h1 { margin: 0 0 6px; font-size: clamp(1.35rem, 2.5vw, 1.85rem); text-transform: uppercase; }
        .location-address { margin: 0; color: var(--public-muted, var(--detail-muted)); font-size: .88rem; font-style: italic; }
        .location-map { width: 100%; height: 420px; border: 1px solid var(--public-line, #e2e7ed); border-radius: 14px; overflow: hidden; }
        .location-map-empty { display: grid; place-items: center; padding: 16px; color: var(--public-muted, var(--detail-muted)); text-align: center; }
        .location-map-note { margin: 8px 0 0; text-align: right; font-size: .74rem; color: var(--public-muted, var(--detail-muted)); }
        .table-responsive { width: 100%; overflow-x: auto; }
        .location-table { width: 100%; margin-top: 28px; border-collapse: collapse; table-layout: fixed; font-size: .88rem; }
        .location-table th, .location-table td { padding: 12px 8px; border-bottom: 1px solid var(--public-line, var(--detail-line)); text-align: left; vertical-align: middle; }
        .location-table th { width: 42%; }
        .location-table thead th { color: var(--public-ink-soft, #2c3748); font-weight: 700; }
        .staff-table { min-width: 540px; }
        .staff-table tbody td:nth-child(1) { padding-top: 8px; padding-bottom: 8px; }
        .staff-table thead th:nth-child(1), .staff-table tbody td:nth-child(1) { width: 88px; }
        .staff-table thead th:nth-child(2), .staff-table tbody td:nth-child(2) { width: 32%; }
        .staff-table thead th:nth-child(3), .staff-table tbody td:nth-child(3) { width: 22%; }
        .staff-table thead th:nth-child(4), .staff-table tbody td:nth-child(4) { width: auto; }
        .location-value { font-weight: 600; }
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 999px; color: #fff; background: var(--detail-accent); font-size: .78rem; font-weight: 700; }
        .status-badge.is-inactive { background: #64748b; }
        .location-section { margin-top: 42px; padding: 24px 28px 18px; border: 1px solid var(--public-line, var(--detail-line)); border-radius: 16px; background: var(--public-panel, #f8fafb); }
        .location-section h2 { margin: 0 0 16px; font-size: 1.05rem; }
        .officer-grid { display: grid; grid-template-columns: 160px minmax(0, 1fr); gap: 28px; align-items: start; }
        .officer-photo { width: 118px; height: 142px; object-fit: cover; border: 2px solid var(--public-line, #c7dfe8); background: var(--public-card, #e8f0f2); }
        .officer-photo-fallback { display: grid; place-items: center; color: var(--public-muted, #73949c); font-size: 2.5rem; }
        .staff-photo { width: 70px; height: 70px; object-fit: cover; border-radius: 50%; border: 2px solid var(--public-line, #dfe8ee); background: var(--public-card, #eef4f6); display: block; margin: 0 auto; transform: translateY(2px); }
        .staff-photo-fallback { display: grid; place-items: center; width: 70px; height: 70px; border-radius: 50%; background: var(--public-card, #e7f0f2); color: var(--public-muted, #6c8690); font-size: 1.2rem; border: 2px solid var(--public-line, #dfe8ee); margin: 0 auto; transform: translateY(2px); }
        .target-time-group { display: flex; flex-direction: column; gap: 2px; line-height: 1.35; }
        .target-time-label { font-weight: 700; }
        .empty-note { color: var(--public-muted, var(--detail-muted)); font-size: .9rem; }
        @media (max-width: 700px) {
            .location-page { width: min(100% - 24px, 560px); margin-top: 24px; }
            .location-top { grid-template-columns: 1fr; gap: 24px; }
            .location-map { height: 260px; }
            .location-section { padding: 18px 14px 10px; }
            .officer-grid { grid-template-columns: 1fr; gap: 12px; }
        }
    </style>
</head>
<body class="public-site">
    <x-public-header :complaint-url="route('pengaduan.create', ['titik_parkir' => $titikParkir->id])" complaint-label="Kirim Aduan Lokasi" />

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
                @php($targetLokasi = (float) ($titikParkir->penempatanJukirs
                    ->filter(fn ($penempatan) => $penempatan->status === 'aktif' && $penempatan->role === 'koordinator')
                    ->first()->target_per_hari ?? 0))
                <table class="location-table">
                    <tr><th>Status</th><td><span class="status-badge {{ ($titikParkir->status ?? 'aktif') === 'aktif' ? '' : 'is-inactive' }}">{{ ($titikParkir->status ?? 'aktif') === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}</span></td></tr>
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
                    <table class="location-table staff-table" style="margin-top: 12px;">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Target dan Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penempatansAktif as $penempatan)
                                <tr>
                                    <td>
                                        @if($penempatan->jukir?->foto)
                                            <img class="staff-photo" src="{{ asset('storage/' . $penempatan->jukir->foto) }}" alt="Foto {{ $penempatan->jukir->nama }}">
                                        @else
                                            <div class="staff-photo-fallback" aria-label="Foto belum tersedia">
                                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M5 20c1.5-3.2 4.3-4.8 7-4.8s5.5 1.6 7 4.8"/></svg>
                                            </div>
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

    <x-public-footer />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @if($titikParkir->latitude !== null && $titikParkir->longitude !== null)
        <script>
            const locationCoordinates = [{{ (float) $titikParkir->latitude }}, {{ (float) $titikParkir->longitude }}];
            const locationName = @json($titikParkir->nama);
            const locationAddress = @json($titikParkir->alamat ?: 'Alamat tidak tersedia');
            const locationMap = L.map('location-map', { scrollWheelZoom: false }).setView(locationCoordinates, 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(locationMap);
            const popupContent = document.createElement('div');
            const titleEl = document.createElement('strong');
            titleEl.textContent = locationName;
            const addressEl = document.createElement('span');
            addressEl.textContent = 'Lokasi: ' + locationAddress;
            const mapLinkEl = document.createElement('a');
            mapLinkEl.href = `https://www.google.com/maps/search/?api=1&query=${locationCoordinates[0]},${locationCoordinates[1]}`;
            mapLinkEl.target = '_blank';
            mapLinkEl.rel = 'noopener noreferrer';
            mapLinkEl.textContent = 'Buka di Google Maps';
            popupContent.append(
                titleEl,
                document.createElement('br'),
                addressEl,
                document.createElement('br'),
                mapLinkEl
            );
            L.marker(locationCoordinates).addTo(locationMap).bindPopup(popupContent).openPopup();
        </script>
    @else
        <script>
            const locationMapEl = document.getElementById('location-map');
            if (locationMapEl) {
                locationMapEl.classList.add('location-map-empty');
                locationMapEl.textContent = 'Koordinat lokasi belum tersedia.';
            }
        </script>
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
