<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-seo :title="$news->judul.' | SAPA JUKIR Kabupaten Sinjai'" :description="$news->ringkasan ?: $news->konten" :image="$news->gambar ? asset('storage/'.$news->gambar) : null" type="article" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="public-site news-page">
    <header class="public-header">
        <div class="container public-nav">
            <a class="public-brand" href="{{ route('home') }}"><span class="brand-mark">SJ</span><span>SAPA JUKIR</span></a>
            <button class="nav-toggle" type="button" aria-label="Buka menu" aria-expanded="false">☰</button>
            <nav class="nav-links" aria-label="Navigasi utama">
                <a href="{{ route('home') }}#top">Beranda</a>
                <a href="{{ route('home') }}#features">Fitur Utama</a>
                <a href="{{ route('home') }}#achievement">Pencapaian</a>
                <a href="{{ route('home') }}#area">Area Pendapatan</a>
                <a href="{{ route('home') }}#about">Tentang</a>
                <a href="{{ route('gallery') }}">Galeri</a>
                <a class="active" href="{{ route('news.index') }}" aria-current="page">Berita</a>
                <a href="{{ route('skm') }}">SKM</a>
                <a href="{{ route('login') }}">Masuk</a>
                <div class="public-nav-actions">
                    <button class="theme-toggle" type="button" aria-label="Ubah mode tampilan" aria-pressed="false" title="Mode gelap"><span class="theme-toggle-icon" aria-hidden="true">☀️</span></button>
                </div>
            </nav>
        </div>
    </header>

    <main class="news-page-main">
        <div class="container">
            <nav class="news-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span>
                <a href="{{ route('news.index') }}">Berita</a><span aria-hidden="true">/</span>
                <span aria-current="page">Detail Berita</span>
            </nav>

            <div class="news-detail-layout">
                <article class="news-article">
                    <header class="news-detail-heading">
                        @if($news->kategori)<span class="news-category">{{ $news->kategori }}</span>@endif
                        <h1>{{ $news->judul }}</h1>
                        <div class="news-article-meta">
                            <span><i class="bi bi-calendar3" aria-hidden="true"></i>
                                <time datetime="{{ ($news->published_at ?? $news->created_at)->toDateString() }}">{{ ($news->published_at ?? $news->created_at)->translatedFormat('d F Y') }}</time>
                            </span>
                            <span><i class="bi bi-person" aria-hidden="true"></i>UPTD Terminal dan Perparkiran</span>
                        </div>
                    </header>
                    <figure class="news-article-image">
                        <img src="{{ asset('storage/' . $news->gambar) }}" alt="{{ $news->judul }}">
                    </figure>
                    @if($news->ringkasan)<p class="news-article-summary">{{ $news->ringkasan }}</p>@endif
                    <div class="news-article-content">{!! nl2br(e($news->konten)) !!}</div>
                    <a class="news-back-link" href="{{ route('news.index') }}"><span aria-hidden="true">&larr;</span> Kembali ke Berita</a>
                </article>

                <aside class="news-latest" aria-labelledby="news-latest-title">
                    <h2 id="news-latest-title">Berita Terbaru</h2>
                    @forelse($relatedNews as $item)
                        <a class="news-latest-item" href="{{ route('news.show', $item) }}">
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="" loading="lazy">
                            <span class="news-latest-copy">
                                <time datetime="{{ ($item->published_at ?? $item->created_at)->toDateString() }}">{{ ($item->published_at ?? $item->created_at)->translatedFormat('d M Y') }}</time>
                                <strong>{{ $item->judul }}</strong>
                            </span>
                        </a>
                    @empty
                        <p class="news-latest-empty">Belum ada berita lainnya.</p>
                    @endforelse
                </aside>
            </div>
        </div>
    </main>

    <footer class="public-footer">
        <div class="container footer-inner">
            <div class="footer-copy">© SAPA JUKIR {{ date('Y') }}</div>
            <p>UPTD Terminal dan Perparkiran<br>DINAS PERHUBUNGAN KABUPATEN SINJAI</p>
        </div>
    </footer>

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
