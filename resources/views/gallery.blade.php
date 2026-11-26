<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-seo title="Galeri | SAPA JUKIR Kabupaten Sinjai" description="Galeri kegiatan SAPA JUKIR Kabupaten Sinjai" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="public-site gallery-page">
    <x-public-header active="gallery" />

    <main class="gallery-page-main">
        <div class="container">
            <div class="gallery-page-heading">
                <p class="eyebrow">Dokumentasi kegiatan</p>
                <h1>Galeri Dokumentasi</h1>
            </div>
            @php($namaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'])

            <form class="gallery-filter" method="GET" action="{{ route('gallery') }}">
                <label for="gallery-category">Filter Kategori</label>
                <select id="gallery-category" name="kategori" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $itemKategori)
                        <option value="{{ $itemKategori }}" @selected($kategori === $itemKategori)>{{ $itemKategori }}</option>
                    @endforeach
                </select>
            </form>

            @if($galleries->isNotEmpty())
                <div class="gallery-page-grid">
                    @foreach($galleries as $gallery)
                        <article class="gallery-card">
                            <img src="{{ asset('storage/' . $gallery->gambar) }}" alt="{{ $gallery->judul }}" loading="lazy">
                            <div class="gallery-card-body">
                                <span>{{ $gallery->kategori ?: 'Dokumentasi' }}</span>
                                <h2>{{ $gallery->judul }}</h2>
                                @if($gallery->deskripsi)<p>{{ $gallery->deskripsi }}</p>@endif
                                <div class="gallery-card-footer">
                                    <button class="gallery-view-button" type="button" data-gallery-view data-title="{{ $gallery->judul }}" data-description="{{ $gallery->deskripsi }}" data-category="{{ $gallery->kategori ?: 'Dokumentasi' }}" data-date="{{ $gallery->tanggal_kegiatan ? $gallery->tanggal_kegiatan->format('d') . ' ' . $namaBulan[(int) $gallery->tanggal_kegiatan->format('n')] . ' ' . $gallery->tanggal_kegiatan->format('Y') : '-' }}" data-image="{{ asset('storage/' . $gallery->gambar) }}" data-images='@json(collect($gallery->gallery_images ?? [$gallery->gambar])->map(fn ($gambar) => asset("storage/" . $gambar))->values()->all())'>Lihat Dokumentasi</button>
                                    <time datetime="{{ $gallery->created_at?->toIso8601String() }}">{{ $gallery->created_at?->diffForHumans() ?? 'Dokumentasi' }}</time>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="gallery-pagination">{{ $galleries->links() }}</div>
            @else
                <div class="gallery-empty"><span class="gallery-empty-mark" aria-hidden="true">+</span><h2>Belum ada dokumentasi</h2><p>Dokumentasi kegiatan akan ditampilkan di halaman ini.</p></div>
            @endif
        </div>
    </main>

    <div class="gallery-modal" id="gallery-modal" role="dialog" aria-modal="true" aria-labelledby="gallery-modal-title" hidden>
        <div class="gallery-modal-backdrop" data-gallery-close></div>
        <div class="gallery-modal-dialog">
            <div class="gallery-modal-header">
                <h2 id="gallery-modal-title"></h2>
                <button class="gallery-modal-close" type="button" aria-label="Tutup pratinjau" data-gallery-close>&times;</button>
            </div>
            <div class="gallery-modal-body">
                <div class="gallery-modal-meta">
                    <div><span>Deskripsi</span><strong id="gallery-modal-description">-</strong></div>
                    <div><span>Tanggal</span><strong id="gallery-modal-date">-</strong></div>
                    <div><span>Kategori</span><strong id="gallery-modal-category">-</strong></div>
                </div>
                <div class="gallery-modal-image-wrap">
                    <button class="gallery-modal-arrow gallery-modal-prev" type="button" aria-label="Foto sebelumnya">&#8249;</button>
                    <img id="gallery-modal-image" src="" alt="">
                    <button class="gallery-modal-arrow gallery-modal-next" type="button" aria-label="Foto berikutnya">&#8250;</button>
                </div>
            </div>
        </div>
    </div>

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

        const galleryModal = document.getElementById('gallery-modal');
        const galleryViewButtons = [...document.querySelectorAll('[data-gallery-view]')];
        const galleryModalTitle = document.getElementById('gallery-modal-title');
        const galleryModalDescription = document.getElementById('gallery-modal-description');
        const galleryModalDate = document.getElementById('gallery-modal-date');
        const galleryModalCategory = document.getElementById('gallery-modal-category');
        const galleryModalImage = document.getElementById('gallery-modal-image');
        const galleryModalPrev = document.querySelector('.gallery-modal-prev');
        const galleryModalNext = document.querySelector('.gallery-modal-next');
        const galleryModalCloseBtn = document.querySelector('.gallery-modal-close');
        let activeGalleryIndex = 0;
        let activeGalleryImages = [];
        let activeGalleryImageIndex = 0;
        let lastTriggerButton = null;

        function showGalleryItem(index) {
            const button = galleryViewButtons[index];
            if (!button) return;
            lastTriggerButton = button;
            activeGalleryIndex = index;
            galleryModalTitle.textContent = button.dataset.title;
            galleryModalDescription.textContent = button.dataset.description || '-';
            galleryModalDate.textContent = button.dataset.date || '-';
            galleryModalCategory.textContent = button.dataset.category || 'Dokumentasi';
            try {
                activeGalleryImages = JSON.parse(button.dataset.images || '[]');
            } catch (error) {
                activeGalleryImages = [];
            }
            if (!activeGalleryImages.length && button.dataset.image) {
                activeGalleryImages = [button.dataset.image];
            }
            activeGalleryImageIndex = 0;
            galleryModalImage.src = activeGalleryImages[activeGalleryImageIndex];
            galleryModalImage.alt = button.dataset.title;
            const hasMultipleImages = activeGalleryImages.length > 1;
            if (galleryModalPrev) galleryModalPrev.hidden = !hasMultipleImages;
            if (galleryModalNext) galleryModalNext.hidden = !hasMultipleImages;
            galleryModal.hidden = false;
            document.body.classList.add('gallery-modal-open');
            galleryModalCloseBtn?.focus();
        }

        function closeGalleryModal() {
            galleryModal.hidden = true;
            document.body.classList.remove('gallery-modal-open');
            lastTriggerButton?.focus();
            lastTriggerButton = null;
        }

        galleryViewButtons.forEach((button, index) => button.addEventListener('click', () => showGalleryItem(index)));
        document.querySelectorAll('[data-gallery-close]').forEach((element) => element.addEventListener('click', closeGalleryModal));
        galleryModalPrev?.addEventListener('click', () => {
            if (activeGalleryImages.length <= 1) return;
            activeGalleryImageIndex = (activeGalleryImageIndex - 1 + activeGalleryImages.length) % activeGalleryImages.length;
            galleryModalImage.src = activeGalleryImages[activeGalleryImageIndex];
        });
        galleryModalNext?.addEventListener('click', () => {
            if (activeGalleryImages.length <= 1) return;
            activeGalleryImageIndex = (activeGalleryImageIndex + 1) % activeGalleryImages.length;
            galleryModalImage.src = activeGalleryImages[activeGalleryImageIndex];
        });
        document.addEventListener('keydown', (event) => {
            if (galleryModal.hidden) return;
            if (event.key === 'Escape') closeGalleryModal();
            if (activeGalleryImages.length <= 1) return;
            if (event.key === 'ArrowLeft') galleryModalPrev?.click();
            if (event.key === 'ArrowRight') galleryModalNext?.click();
        });
    </script>
</body>
</html>
