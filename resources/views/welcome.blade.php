<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-seo :title="$siteSettings?->hero_title ? (str_contains($siteSettings->hero_title, 'SAPA JUKIR') ? $siteSettings->hero_title : $siteSettings->hero_title.' | SAPA JUKIR') : 'SAPA JUKIR | Sistem Informasi Petugas'" :description="$siteSettings?->hero_description ?? 'SAPA JUKIR adalah sistem informasi petugas parkir dan retribusi Dinas Perhubungan Kabupaten Sinjai.'" :image="$siteSettings?->hero_image ? asset('storage/'.$siteSettings->hero_image) : null" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="public-site">
    <header class="public-header">
        <div class="container public-nav">
            <a class="public-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-sapa-jukir.png') }}" alt="Logo SAPA JUKIR" style="height: 32px; width: auto; object-fit: contain;">
                <span>SAPA JUKIR</span>
            </a>

            <button class="nav-toggle" type="button" aria-label="Buka menu" aria-expanded="false">☰</button>

            <nav class="nav-links" aria-label="Navigasi utama">
                <a href="#top">Beranda</a>
                <a href="#features">Fitur Utama</a>
                <a href="#achievement">Pencapaian</a>
                <a href="#area">Area Pendapatan</a>
                <a href="#about">Tentang</a>
                <a href="{{ route('gallery') }}">Galeri</a>
                <a href="{{ route('news.index') }}">Berita</a>
                <a href="{{ route('skm') }}">SKM</a>
                <a href="{{ route('login') }}">Masuk</a>
                <div class="public-nav-actions">
                    <button class="theme-toggle" type="button" aria-label="Ubah mode tampilan" aria-pressed="false" title="Mode gelap">
                        <span class="theme-toggle-icon" aria-hidden="true">☀️</span>
                    </button>
                    <a class="complaint-link" href="{{ route('pengaduan.create') }}">💬 Kirim Aduan</a>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero" id="top">
            <div class="container hero-grid">
                <div class="hero-copy">
                    <h1>{{ $siteSettings?->hero_title ?? 'Selamat Datang di SAPA JUKIR' }}</h1>
                    <p class="lead">
                        {{ $siteSettings?->hero_description ?? 'SAPA JUKIR (Sistem Informasi Petugas) adalah aplikasi yang membantu pencatatan, monitoring, dan pengelolaan pendapatan daerah serta objek pendapatan di Kabupaten Sinjai.' }}
                    </p>

                    <div class="hero-contact-strip" aria-label="Informasi kontak publik">
                        <div class="contact-pill">
                            <span class="contact-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><path d="M12 2.5a9.5 9.5 0 0 0-8.2 14.7l-1 3.8 3.9-1A9.5 9.5 0 1 0 12 2.5Zm5.5 13.2c-.3.8-1.6 1.5-2.2 1.6-.6.1-1.4.1-4.5-1-3.1-1.2-5.2-4.5-5.4-4.7-.2-.2-1.6-2.2-1.6-4.2 0-2 1.1-3.1 1.5-3.5.4-.4.9-.5 1.2-.5h.9c.3 0 .8.1 1.2.9l1.4 3.6c.1.3 0 .8-.3 1.1l-.8.9c-.2.2-.3.5-.1.8.5.9 1.7 2.4 3.1 3.7 1.2 1.1 2.8 2.1 3.8 2.5.3.2.6.1.8-.1l.9-.9c.3-.3.8-.4 1.1-.2l3.6 1.4c.8.4.9.9.9 1.2v.9c0 .4-.1.8-.5 1.2-.4.4-1.5 1.5-3.5 1.5Z" fill="currentColor"/></svg>
                            </span>
                            <span class="contact-text">{{ $siteSettings?->service_hours ?? '08.00 – 16.00 WITA' }}</span>
                        </div>
                        <a
                            class="contact-pill"
                            href="{{ $siteSettings?->location_url ?? 'https://maps.google.com/?q=Dinas+Perhubungan+Kabupaten+Sinjai' }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Buka lokasi {{ $siteSettings?->location_name ?? 'Jl. Bulu Pattuku, Kel. Bongki, Kec. Sinjai Utara, Kab. Sinjai' }} di Google Maps"
                        >
                            <span class="contact-icon location-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><path d="M12 21s6-5.5 6-11A6 6 0 1 0 6 10c0 5.5 6 11 6 11Zm0-8.5A2.5 2.5 0 1 1 12 7a2.5 2.5 0 0 1 0 5.5Z" fill="currentColor"/></svg>
                            </span>
                            <span class="contact-text">{{ $siteSettings?->location_name ?? 'Jl. Bulu Pattuku, Kel. Bongki, Kec. Sinjai Utara, Kab. Sinjai' }}</span>
                        </a>
                        <a
                            class="contact-pill contact-whatsapp"
                            href="{{ $siteSettings?->whatsapp_url ?? 'https://wa.me/628999084343' }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Hubungi WhatsApp {{ $siteSettings?->location_name ?? 'Jl. Bulu Pattuku, Kel. Bongki, Kec. Sinjai Utara, Kab. Sinjai' }}"
                        >
                            <span class="contact-icon whatsapp-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><path d="M12.04 2a9.95 9.95 0 0 0-8.57 15.18L2.4 22l4.86-1.25A9.96 9.96 0 1 0 12.04 2Zm5.55 14.15c-.22.62-1.3 1.15-1.8 1.22-.48.07-1.09.09-3.53-.74-2.99-.98-4.91-3.54-5.07-3.72-.17-.18-1.37-1.82-1.37-3.48 0-1.66.88-2.48 1.19-2.82.31-.35.67-.43.9-.43h.65c.2 0 .47.01.72.55l.98 2.44c.09.21.03.5-.17.79l-.34.42c-.19.24-.22.42-.11.67.26.56.98 1.76 2.16 2.9 1.48 1.36 2.76 1.78 3.28 1.99.27.12.57.08.78-.15l.52-.6c.18-.2.39-.26.62-.17l2.58.97c.21.08.4.18.45.41.05.23.06.45-.15.75Z" fill="currentColor"/></svg>
                            </span>
                            <span class="contact-text">{{ $siteSettings?->whatsapp_number ?? '089 990 843 43' }}</span>
                        </a>
                    </div>

                    <p class="powered-by">Powered &amp; Designed by UPTD Terminal &amp; Perparkiran<br>Dinas Perhubungan Kab. Sinjai</p>
                </div>

                <div class="hero-visual" aria-label="Bupati dan Wakil Bupati Kabupaten Sinjai">
                    <div class="leaders-card">
                        <img src="{{ $siteSettings?->hero_image ? asset('storage/' . $siteSettings->hero_image) : asset('images/hero-sinjai.png') }}" alt="Bupati Sinjai Ratnawati Arif dan Wakil Bupati Sinjai Andi Mahyanto Mazda dengan dashboard SAPA JUKIR">
                    </div>
                </div>
            </div>
        </section>

        <section
            class="director-message"
            aria-label="Sambutan Kepala Dinas"
            @if($sambutan?->background_color)
                style="background: linear-gradient(135deg, {{ $sambutan->background_color }} 0%, {{ $sambutan->background_color }}cc 100%);"
            @endif
        >
            @if($sambutan)
                @php
                    $kadisFoto = $sambutan->foto_kadis ?: $sambutan->foto;
                @endphp

                @if($kadisFoto)
                    <div class="sambutan-container">
                        <div class="sambutan-hero">
                            <div class="single-photo-card">
                                <img src="{{ asset('storage/' . $kadisFoto) }}" alt="{{ $sambutan->nama_kepala_dinas ?? 'Kepala Dinas' }}">
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </section>

        <section class="info-section" id="features">
            <div class="container">
                <div class="feature-showcase">
                    <div class="feature-phone" aria-label="Pratinjau aplikasi SAPA JUKIR">
                        <div class="phone-speaker"></div>
                        <div class="phone-screen">
                            <div class="phone-brand">SAPA JUKIR</div>
                            <small>Sumber Pendapatan Aktif: {{ number_format($totalSumberPemasukan, 0, ',', '.') }}</small>
                            <div class="phone-donut"></div>
                            <div class="phone-bars"><i></i><i></i><i></i><i></i><i></i></div>
                        </div>
                    </div>

                    <div class="feature-content">
                        <p class="eyebrow">Fitur Utama</p>
                        <h2>Parkir dan pendapatan daerah lebih tertata.</h2>
                        <div class="feature-grid">
                            <article class="feature-card">
                                <span class="feature-icon" aria-hidden="true"><svg viewBox="0 0 48 48" focusable="false"><circle cx="24" cy="24" r="18"></circle><circle cx="18" cy="20" r="2" class="icon-fill"></circle><circle cx="30" cy="20" r="2" class="icon-fill"></circle><path d="M16 28c2.2 3.2 5 4.8 8 4.8s5.8-1.6 8-4.8"></path></svg></span>
                                <h3>Petugas</h3>
                                <p>Terdapat <strong>{{ number_format($totalJukir, 0, ',', '.') }}</strong> Petugas terdaftar resmi di Kabupaten Sinjai.</p>
                            </article>
                            <article class="feature-card">
                                <span class="feature-icon" aria-hidden="true"><svg viewBox="0 0 48 48" focusable="false"><path d="M24 42S12 30.8 12 20.5a12 12 0 1 1 24 0C36 30.8 24 42 24 42Z"></path><circle cx="24" cy="20" r="4"></circle></svg></span>
                                <h3>Titik / Objek Pendapatan</h3>
                                <p>Terdapat <strong>{{ number_format($totalTitikParkir, 0, ',', '.') }}</strong> titik/objek pendapatan terdaftar.</p>
                            </article>
                            <article class="feature-card">
                                <span class="feature-icon" aria-hidden="true"><svg viewBox="0 0 48 48" focusable="false"><path d="M7 18V9h9M32 9h9v9M41 30v9h-9M16 39H7v-9"></path><path d="M13 13h8v8h-8zM27 13h8v8h-8zM13 27h8v8h-8zM28 28h4v4h-4zM35 35h4v4h-4zM28 36h4"></path></svg></span>
                                <h3>Transaksi Penerimaan Tercatat</h3>
                                <p>Terdapat <strong>{{ number_format($totalSetoran, 0, ',', '.') }}</strong> transaksi yang tercatat di sistem.</p>
                            </article>
                            <article class="feature-card">
                                <span class="feature-icon" aria-hidden="true"><svg viewBox="0 0 48 48" focusable="false"><rect x="7" y="14" width="34" height="21" rx="3"></rect><circle cx="24" cy="24.5" r="5"></circle><path d="M7 19c3 0 5-2 5-5M41 19c-3 0-5-2-5-5M7 30c3 0 5 2 5 5M41 30c-3 0-5 2-5 5"></path></svg></span>
                                <h3>Sumber Pendapatan</h3>
                                <p>
                                    @if($activeSources->isNotEmpty())
                                        <span>Tersedia</span>
                                        <strong>{{ number_format($activeSources->count(), 0, ',', '.') }}</strong>
                                        <span>sumber pendapatan aktif saat ini.</span>
                                    @else
                                        <span>Tidak ada sumber pendapatan aktif.</span>
                                    @endif
                                </p>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="achievement-section" id="achievement">
            <div class="container">
                <div class="achievement-heading">
                    <div>
                        <p class="eyebrow">Pencapaian</p>
                        <h2>Target dan realisasi pendapatan daerah.</h2>
                    </div>
                </div>

                <div class="achievement-grid">
                    <div class="achievement-box accent-blue">
                        <small>Target pendapatan {{ $tahunAktif }}</small>
                        <h3>Rp {{ number_format($targetTahunan, 0, ',', '.') }}</h3>
                        <p>Akumulasi target dari seluruh sumber pendapatan untuk tahun berjalan.</p>
                    </div>
                    <div class="achievement-box accent-purple">
                        <small>Realisasi terverifikasi {{ $tahunAktif }}</small>
                        <h3>Rp {{ number_format($realisasiTahunan, 0, ',', '.') }}</h3>
                        <p>Total setoran berstatus terverifikasi sejak awal tahun berjalan.</p>
                    </div>
                    <div class="achievement-box accent-gold">
                        <small>Persentase capaian {{ $tahunAktif }}</small>
                        <h3>{{ number_format($persentaseCapaian, 2, ',', '.') }}%</h3>
                        <p>Perbandingan realisasi terverifikasi terhadap target pendapatan tahunan.</p>
                    </div>
                </div>

                <p class="achievement-note">Catatan: Realisasi dihitung dari setoran berstatus terverifikasi pada tahun {{ $tahunAktif }}.</p>
                <p class="achievement-updated">Halaman diperbarui: {{ $tanggalPembaruanPublik }}</p>

                <article class="achievement-chart-card achievement-trend-card">
                    <div class="achievement-chart-heading">
                        <div><h3>Tren Pendapatan {{ $tahunAktif }}</h3><p>Perbandingan target, realisasi terverifikasi, dan capaian per bulan.</p></div>
                        <span>{{ $tahunAktif }}</span>
                    </div>
                    <div class="achievement-chart-wrap"><canvas id="trend-revenue-chart" aria-label="Grafik tren pendapatan tahunan"></canvas></div>
                </article>

                <div class="achievement-chart-grid">
                    <article class="achievement-chart-card achievement-chart-card-wide">
                        <div class="achievement-chart-heading">
                            <div><h3>Capaian Bulanan</h3><p>Perbandingan target dan realisasi setiap bulan.</p></div>
                            <span>{{ $tahunAktif }}</span>
                        </div>
                        <div class="achievement-chart-wrap"><canvas id="monthly-achievement-chart" aria-label="Grafik target dan realisasi bulanan"></canvas></div>
                    </article>
                    <article class="achievement-chart-card">
                        <div class="achievement-chart-heading">
                            <div><h3>Capaian Tahunan</h3><p>Ringkasan target dan realisasi tahun berjalan.</p></div>
                            <span>{{ $tahunAktif }}</span>
                        </div>
                        <div class="achievement-chart-wrap"><canvas id="annual-achievement-chart" aria-label="Grafik target dan realisasi tahunan"></canvas></div>
                    </article>
                </div>
                <article class="achievement-chart-card achievement-source-chart-card">
                    <div class="achievement-chart-heading">
                        <div><h3>Capaian Berdasarkan Sumber Pendapatan</h3><p>Perbandingan target dan realisasi setiap sumber pendapatan.</p></div>
                        <span>{{ $tahunAktif }}</span>
                    </div>
                    <div class="achievement-source-chart-wrap"><canvas id="source-achievement-chart" aria-label="Grafik target dan realisasi berdasarkan sumber pendapatan"></canvas></div>
                </article>
            </div>
        </section>

        <section class="about-section" id="about">
            <div class="about-backdrop" aria-hidden="true"></div>
            <div class="container about-content">
                <p class="about-kicker">About Us</p>
                <h2>UPTD Terminal dan Perparkiran</h2>
                <p class="about-lead">
                    UPTD Terminal dan Perparkiran Dinas Perhubungan Kabupaten Sinjai merupakan unit pelaksana teknis
                    yang membantu pemerintah daerah menyelenggarakan pelayanan terminal dan perparkiran secara tertib,
                    aman, terukur, dan berorientasi pada pelayanan masyarakat.
                </p>
                <p>
                    Pelaksanaan tugasnya mencakup administrasi, pendataan, pengaturan, pengawasan operasional,
                    pembinaan Petugas, serta pengelolaan retribusi parkir sebagai bagian dari peningkatan
                    Pendapatan Asli Daerah Kabupaten Sinjai.
                </p>
                <div class="about-details">
                    <div><strong>Alamat Kantor</strong><span>{{ $siteSettings?->location_name ?? 'Jl. Bulu Pattuku, Kel. Bongki, Kec. Sinjai Utara, Kab. Sinjai' }}</span></div>
                    <div><strong>Waktu Pelayanan</strong><span>{{ $siteSettings?->service_hours ?? '08.00 – 16.00 WITA' }}</span></div>
                    <div><strong>Instagram</strong><span>{{ $siteSettings?->instagram ?? '@dishub_sinjai' }}</span></div>
                    <div><strong>Email</strong><span>{{ $siteSettings?->email ?? 'dishub@sinjai.go.id' }}</span></div>
                </div>
                <div class="about-map-wrap">
                    <iframe
                        title="Peta lokasi wilayah Dinas Perhubungan Kabupaten Sinjai"
                        src="https://www.openstreetmap.org/export/embed.html?bbox=120.245%2C-5.120%2C120.259%2C-5.108&amp;layer=mapnik&amp;marker=-5.1139428%2C120.2520413"
                        loading="lazy"
                    ></iframe>
                </div>
            </div>
        </section>

        <section class="area-section" id="area">
            <div class="container area-layout">
                <div class="map-panel">
                    <div class="map-header">
                        <span class="map-badge">Area Pendapatan</span>
                        <span class="map-status">Live Map</span>
                    </div>

                    <div class="map-toolbar" aria-label="Filter peta">
                        <div class="toolbar-item">
                            <label for="status-filter"><span class="filter-icon layers-icon" aria-hidden="true"></span>Tampilkan:</label>
                            <select id="status-filter">
                                <option value="">Semua Status</option>
                                <option value="AKTIF">Aktif</option>
                                <option value="NONAKTIF">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="toolbar-item">
                            <label for="kecamatan-filter"><span class="filter-icon funnel-icon" aria-hidden="true"></span>Kecamatan:</label>
                            <select id="kecamatan-filter">
                                <option value="">Semua Kecamatan</option>
                                @foreach($kecamatanList as $kecamatan)
                                    <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="toolbar-item">
                            <label for="source-filter"><span class="filter-icon layers-icon" aria-hidden="true"></span>Sumber:</label>
                            <select id="source-filter">
                                <option value="">Semua Sumber</option>
                                @foreach($sumberPemasukanPeta as $sumber)
                                    <option value="{{ $sumber->kode }}">{{ $sumber->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="toolbar-item search-item">
                            <label for="point-search"><span class="filter-icon search-icon" aria-hidden="true"></span>Cari Titik:</label>
                            <input id="point-search" type="search" placeholder="Ketik Nama Lokasi/Jalan" />
                        </div>
                        <button id="reset-map-btn" class="reset-map-btn" type="button">Reset</button>
                    </div>

                    <div class="map-summary">
                        <div>
                            <strong>{{ $totalTitikParkir }}</strong>
                            <span>Total Titik</span>
                        </div>
                        <div>
                            <strong>{{ $titikParkirAktif }}</strong>
                            <span>Aktif</span>
                        </div>
                        <div>
                            <strong>{{ $totalKecamatan }}</strong>
                            <span>Kecamatan</span>
                        </div>
                        <div>
                            <strong>{{ $totalJenisParkir }}</strong>
                            <span>Jenis Sumber Pendapatan</span>
                        </div>
                    </div>

                    <div class="map-legend" aria-label="Legenda peta">
                        <span><i class="legend-dot" style="background:#198754"></i> Retribusi Tempat Khusus Parkir</span>
                        <span><i class="legend-dot" style="background:#1a5dff"></i> Retribusi Pelayanan Parkir Tepi Jalan Umum</span>
                        <span><i class="legend-dot" style="background:#8b5cf6"></i> Retribusi Sewa Pelataran Area Terminal untuk Kegiatan Tertentu</span>
                        <span><i class="legend-dot" style="background:#d946ef"></i> Retribusi Penyediaan Tempat Kegiatan Usaha</span>
                    </div>

                    <div id="public-map" class="map-surface" aria-label="Peta area pendapatan"></div>

                </div>

            </div>
        </section>

    </main>

    <footer class="public-footer" id="contact">
        <div class="container footer-inner">
            <div class="footer-copy">© SAPA JUKIR {{ date('Y') }}</div>
            <p>UPTD Terminal dan Perparkiran<br>DINAS PERHUBUNGAN KABUPATEN SINJAI</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        const achievementMonthlyData = @json($achievementBulanan ?? []);
        const trendRevenueData = @json($trenPendapatanPublik ?? []);
        const achievementSourceData = @json($capaianPerSumber ?? []);
        const achievementCurrency = (value) => `Rp ${new Intl.NumberFormat('id-ID').format(value)}`;
        const achievementChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 18 } },
                tooltip: { callbacks: { label: (context) => `${context.dataset.label}: ${achievementCurrency(context.raw)}` } },
            },
            scales: {
                y: { beginAtZero: true, ticks: { callback: (value) => achievementCurrency(value) }, grid: { color: '#e5eaf2' } },
                x: { grid: { display: false } },
            },
        };

        if (typeof Chart !== 'undefined') {
            const trendRevenueCanvas = document.getElementById('trend-revenue-chart');
            if (trendRevenueCanvas) {
                new Chart(trendRevenueCanvas, {
                    type: 'line',
                    data: {
                        labels: trendRevenueData.map((item) => item.bulan),
                        datasets: [
                            { label: 'Target', data: trendRevenueData.map((item) => item.target), borderColor: '#0d6efd', backgroundColor: 'rgba(13, 110, 253, 0.12)', tension: 0.25, fill: false, pointRadius: 3 },
                            { label: 'Realisasi terverifikasi', data: trendRevenueData.map((item) => item.realisasi), borderColor: '#198754', backgroundColor: 'rgba(25, 135, 84, 0.12)', tension: 0.25, fill: false, pointRadius: 3 },
                            { label: 'Capaian', data: trendRevenueData.map((item) => item.capaian), borderColor: '#fd7e14', backgroundColor: 'rgba(253, 126, 20, 0.12)', yAxisID: 'yCapaian', tension: 0.25, fill: false, pointRadius: 3 },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            y: { beginAtZero: true, ticks: { callback: (value) => achievementCurrency(value) }, grid: { color: '#e5eaf2' } },
                            yCapaian: { beginAtZero: true, suggestedMax: 100, position: 'right', grid: { drawOnChartArea: false }, ticks: { callback: (value) => `${value}%` } },
                            x: { grid: { display: false } },
                        },
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 18 } },
                            tooltip: {
                                callbacks: {
                                    label: (context) => `${context.dataset.label}: ${context.dataset.yAxisID === 'yCapaian' ? `${Number(context.raw).toLocaleString('id-ID')}%` : achievementCurrency(context.raw)}`,
                                },
                            },
                        },
                    },
                });
            }

            new Chart(document.getElementById('monthly-achievement-chart'), {
                type: 'bar',
                data: {
                    labels: achievementMonthlyData.map((item) => item.bulan),
                    datasets: [
                        { label: 'Target', data: achievementMonthlyData.map((item) => item.target), backgroundColor: '#2d7ff9', borderRadius: 5 },
                        { label: 'Realisasi', data: achievementMonthlyData.map((item) => item.total), backgroundColor: '#16a085', borderRadius: 5 },
                    ],
                },
                options: achievementChartOptions,
            });

            new Chart(document.getElementById('annual-achievement-chart'), {
                type: 'bar',
                data: {
                    labels: ['{{ $tahunAktif }}'],
                    datasets: [
                        { label: 'Target', data: [{{ $targetTahunan }}], backgroundColor: '#2d7ff9', borderRadius: 5 },
                        { label: 'Realisasi', data: [{{ $realisasiTahunan }}], backgroundColor: '#16a085', borderRadius: 5 },
                    ],
                },
                options: achievementChartOptions,
            });

            new Chart(document.getElementById('source-achievement-chart'), {
                type: 'bar',
                data: {
                    labels: achievementSourceData.map((item) => item.nama),
                    datasets: [
                        { label: 'Target', data: achievementSourceData.map((item) => item.target), backgroundColor: '#2d7ff9', borderRadius: 5 },
                        { label: 'Realisasi', data: achievementSourceData.map((item) => item.realisasi), backgroundColor: '#16a085', borderRadius: 5 },
                    ],
                },
                options: {
                    ...achievementChartOptions,
                    indexAxis: 'y',
                    scales: {
                        x: { beginAtZero: true, ticks: { callback: (value) => achievementCurrency(value) }, grid: { color: '#e5eaf2' } },
                        y: { grid: { display: false } },
                    },
                },
            });
        }
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        const toggle = document.querySelector('.nav-toggle');
        const nav = document.querySelector('.nav-links');
        const kecamatanFilter = document.getElementById('kecamatan-filter');
        const statusFilter = document.getElementById('status-filter');
        const sourceFilter = document.getElementById('source-filter');
        const pointSearch = document.getElementById('point-search');
        const resetMapBtn = document.getElementById('reset-map-btn');

        toggle?.addEventListener('click', () => {
            const isOpen = nav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen);
        });

        nav?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                nav.classList.remove('is-open');
                toggle?.setAttribute('aria-expanded', 'false');
            });
        });

        const parkirPoints = @json($parkirPeta ?? []);
        const mapContainer = document.getElementById('public-map');
        const defaultLocation = { lat: -5.141, lng: 120.255 };
        let userLocation = null;
        let publicMap = null;
        let mapMarkers = [];

        function toRadians(value) {
            return (value * Math.PI) / 180;
        }

        function getFilteredPoints() {
            const selectedKecamatan = kecamatanFilter?.value ?? '';
            const selectedStatus = statusFilter?.value ?? '';
            const selectedSource = sourceFilter?.value ?? '';
            const searchTerm = (pointSearch?.value ?? '').trim().toLowerCase();

            return parkirPoints.filter((point) => {
                const matchesKecamatan = !selectedKecamatan || String(point.kecamatan_id ?? '') === String(selectedKecamatan);
                const matchesStatus = !selectedStatus || point.status === selectedStatus;
                const matchesSource = !selectedSource || point.sumber_kode === selectedSource;
                const searchableText = `${point.nama ?? ''} ${point.alamat ?? ''}`.toLowerCase();
                const matchesSearch = !searchTerm || searchableText.includes(searchTerm);

                return matchesKecamatan && matchesStatus && matchesSource && matchesSearch;
            });
        }

        function getMarkerStyle(point) {
            const isActive = point.status === 'AKTIF';
            const sourceColors = {
                'R-TKP': '#198754',
                'R-PJTU': '#1a5dff',
                'R-JASA-USAHA': '#8b5cf6',
                'R-TKU': '#d946ef',
            };

            return {
                radius: isActive ? 9 : 8,
                color: isActive ? '#ffffff' : '#dc3545',
                weight: 2,
                fillColor: sourceColors[point.sumber_kode] || '#6c757d',
                fillOpacity: isActive ? 0.92 : 0.55,
            };
        }

        function getMarkerIcon(point) {
            const sourceColors = {
                'R-TKP': '#198754',
                'R-PJTU': '#1a5dff',
                'R-JASA-USAHA': '#8b5cf6',
                'R-TKU': '#d946ef',
            };
            const markerColor = sourceColors[point.sumber_kode] || '#6c757d';
            const inactiveClass = point.status === 'AKTIF' ? '' : ' is-inactive';

            return L.divIcon({
                className: 'public-map-pin-wrapper',
                html: `<span class="public-map-pin${inactiveClass}" style="--marker-color: ${markerColor};" aria-hidden="true"></span>`,
                iconSize: [30, 42],
                iconAnchor: [15, 42],
                popupAnchor: [0, -38],
            });
        }

        function buildPopupMarkup(point) {
            return `
                <div style="min-width: 210px; line-height: 1.6;">
                    <strong style="display: block; font-size: 14px; margin-bottom: 6px;">${point.nama}</strong>
                    <span>Lokasi: ${point.alamat || 'Alamat tidak tersedia'}</span><br>
                    <small>${point.kecamatan || '-'} / ${point.kelurahan || '-'}</small><br>
                    <small>Sumber: ${point.sumber_nama || 'Belum ditentukan'}</small><br>
                    <small>Status: ${point.status || 'AKTIF'}</small><br>
                    <small>Koordinat: ${point.lat.toFixed(5)}, ${point.lng.toFixed(5)}</small>
                    <a href="${point.detail_url}" style="display: inline-block; margin-top: 2px;">Lihat Detail Lokasi</a>
                </div>
            `;
        }

        function updateMapPoints(points) {
            if (!publicMap) {
                return;
            }

            mapMarkers.forEach((marker) => publicMap.removeLayer(marker));
            mapMarkers = [];

            if (!points.length) {
                L.marker([defaultLocation.lat, defaultLocation.lng])
                    .addTo(publicMap)
                    .bindPopup('Belum ada objek pendapatan di kecamatan ini.')
                    .openPopup();
                publicMap.setView([defaultLocation.lat, defaultLocation.lng], 11);
                return;
            }

            const bounds = [];

            points.forEach((point) => {
                const marker = L.marker([point.lat, point.lng], { icon: getMarkerIcon(point) }).addTo(publicMap);
                marker.bindPopup(buildPopupMarkup(point));
                mapMarkers.push(marker);
                bounds.push([point.lat, point.lng]);
            });

            if (bounds.length > 1) {
                publicMap.fitBounds(bounds, { padding: [28, 28] });
            } else {
                publicMap.setView(bounds[0], 15);
            }

        }

        if (mapContainer && typeof L !== 'undefined') {
            publicMap = L.map('public-map', {
                zoomControl: true,
                scrollWheelZoom: true,
            }).setView([defaultLocation.lat, defaultLocation.lng], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(publicMap);

            updateMapPoints(getFilteredPoints());
        }

        kecamatanFilter?.addEventListener('change', () => {
            updateMapPoints(getFilteredPoints());
        });

        statusFilter?.addEventListener('change', () => {
            updateMapPoints(getFilteredPoints());
        });

        sourceFilter?.addEventListener('change', () => {
            updateMapPoints(getFilteredPoints());
        });

        pointSearch?.addEventListener('input', () => {
            updateMapPoints(getFilteredPoints());
        });

        resetMapBtn?.addEventListener('click', () => {
            if (kecamatanFilter) kecamatanFilter.value = '';
            if (statusFilter) statusFilter.value = '';
            if (sourceFilter) sourceFilter.value = '';
            if (pointSearch) pointSearch.value = '';
            updateMapPoints(parkirPoints);
        });

    </script>
</body>
</html>
