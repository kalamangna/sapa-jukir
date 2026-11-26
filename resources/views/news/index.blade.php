<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-seo title="Berita | SAPA JUKIR Kabupaten Sinjai" description="Berita dan informasi kegiatan UPTD Terminal dan Perparkiran Kabupaten Sinjai." />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="public-site news-page">
    <x-public-header active="news" />

    <main class="news-page-main">
        <div class="container">
            <header class="news-page-heading">
                <p class="eyebrow">Informasi dan kegiatan</p>
                <h1>Berita Terkini</h1>
                <p>Ikuti kabar terbaru dan berbagai kegiatan UPTD Terminal dan Perparkiran Kabupaten Sinjai.</p>
            </header>

            @if($newsItems->isNotEmpty())
                @php($namaBulan = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'])
                <div class="news-grid">
                    @foreach($newsItems as $news)
                        @php($tanggalBerita = $news->published_at ?? $news->created_at)
                        <article class="news-card">
                            <a class="news-card-image-link" href="{{ route('news.show', $news) }}" aria-label="Baca {{ $news->judul }}">
                                <img src="{{ asset('storage/' . $news->gambar) }}" alt="{{ $news->judul }}" loading="lazy">
                                @if($tanggalBerita)
                                    <time class="news-date-badge" datetime="{{ $tanggalBerita->format('Y-m-d') }}">
                                        <strong>{{ $tanggalBerita->format('d') }}</strong>
                                        <span>{{ $namaBulan[(int) $tanggalBerita->format('n')] }}</span>
                                    </time>
                                @endif
                            </a>
                            <div class="news-card-body">
                                <span class="news-category">{{ $news->kategori ?: 'Kegiatan' }}</span>
                                <h2><a href="{{ route('news.show', $news) }}">{{ $news->judul }}</a></h2>
                                @if($news->ringkasan)
                                    <p>{{ $news->ringkasan }}</p>
                                @else
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($news->konten), 150) }}</p>
                                @endif
                                <a class="news-read-more" href="{{ route('news.show', $news) }}">Baca Berita <span aria-hidden="true">&rarr;</span></a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="news-pagination">{{ $newsItems->links() }}</div>
            @else
                <div class="news-empty">
                    <span aria-hidden="true">▤</span>
                    <h2>Belum ada berita</h2>
                    <p>Informasi dan kegiatan terbaru akan ditampilkan di halaman ini.</p>
                </div>
            @endif
        </div>
    </main>

    <x-public-footer />

    <script>
        const toggle = document.querySelector('.nav-toggle');
        const nav = document.querySelector('.nav-links');
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
    </script>
</body>
</html>
