<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-seo title="Survei Kepuasan Masyarakat | SAPA JUKIR" description="Sampaikan penilaian Anda terhadap pelayanan UPTD Terminal dan Perparkiran Kabupaten Sinjai melalui Survei Kepuasan Masyarakat." />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="public-site skm-page">
    <x-public-header active="skm" subtitle="Survei Kepuasan Masyarakat" />

    <main class="skm-page-main">
        <section class="skm-hero" aria-labelledby="skm-title">
            <div class="container skm-hero-inner">
                <div class="skm-copy">
                    <p class="skm-welcome">Selamat Datang di</p>
                    <h1 id="skm-title">SAPA JUKIR</h1>
                    <h2>Survei Kepuasan Masyarakat</h2>
                    <p class="skm-description">
                        Kami hadir untuk meningkatkan kualitas pelayanan UPTD Terminal dan
                        Perparkiran Dinas Perhubungan Kabupaten Sinjai. Sampaikan penilaian
                        dan masukan Anda melalui survei resmi berikut.
                    </p>
                    <a class="primary-btn skm-action" href="https://skm.go.id/share/instansi/7cc2fe0e-ca0b-445f-a0cd-8003ee53ad83/1" target="_blank" rel="noopener noreferrer">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5h8l5 14H3L8 5Zm1.5 0 2.5 7 2.5-7M6 15h12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Isi Survei SKM
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>

                <div class="skm-hero-art">
                    <img
                        class="skm-hero-image"
                        src="{{ asset('images/Gambar Hero.jpeg') }}"
                        alt="Petugas menyambut masyarakat di Terminal Sinjai, dengan ajakan Dari Anda untuk Pelayanan yang Lebih Baik"
                        fetchpriority="high"
                    >
                </div>
            </div>
        </section>

        <section class="skm-why" aria-labelledby="skm-why-title">
            <div class="container">
                <div class="skm-section-heading">
                    <p>MENGAPA SKM PENTING?</p>
                    <h2 id="skm-why-title">Partisipasi Anda Membantu Kami</h2>
                    <span aria-hidden="true"></span>
                </div>
                <div class="skm-benefits">
                    <article class="skm-benefit">
                        <span class="skm-benefit-icon skm-icon-blue" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m8-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-3a4 4 0 0 1 0 8m2 8v-2a4 4 0 0 0-3-3.87" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span>
                        <h3>Meningkatkan<br>Kualitas Pelayanan</h3><p>Masukan Anda menjadi bahan evaluasi kami.</p>
                    </article>
                    <article class="skm-benefit">
                        <span class="skm-benefit-icon skm-icon-green" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m12 3 8 3v5c0 5-3.4 8.3-8 10-4.6-1.7-8-5-8-10V6l8-3Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        <h3>Mewujudkan<br>Pelayanan Prima</h3><p>Kami berkomitmen memberikan pelayanan terbaik untuk masyarakat.</p>
                    </article>
                    <article class="skm-benefit">
                        <span class="skm-benefit-icon skm-icon-gold" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 20V10m5 10V4m5 16v-7m5 7V7" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg></span>
                        <h3>Transparan<br>dan Akuntabel</h3><p>Hasil survei akan kami publikasikan secara terbuka.</p>
                    </article>
                    <article class="skm-benefit">
                        <span class="skm-benefit-icon skm-icon-purple" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M9 18h6m-5 3h4m-2-20a7 7 0 0 0-4 12.75c.6.4 1 1.1 1 1.75h6c0-.65.4-1.35 1-1.75A7 7 0 0 0 12 1Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        <h3>Inovasi Pelayanan</h3><p>Dukung kami dengan saran dan masukan konstruktif Anda.</p>
                    </article>
                    <article class="skm-benefit">
                        <span class="skm-benefit-icon skm-icon-red" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M20.8 8.7c0 4.2-8.8 10.1-8.8 10.1S3.2 12.9 3.2 8.7A4.7 4.7 0 0 1 12 6.1a4.7 4.7 0 0 1 8.8 2.6Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg></span>
                        <h3>Bersama Membangun<br>Pelayanan Publik</h3><p>Kepuasan Anda adalah prioritas kami.</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer class="skm-footer">
        <div class="container skm-footer-inner">
            <a class="skm-footer-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-sapa-jukir.png') }}" alt="Logo SAPA JUKIR" style="height: 32px; width: auto; object-fit: contain;">
                <span><strong>SAPA JUKIR</strong><small>Survei Kepuasan Masyarakat</small></span>
            </a>
            <p class="skm-footer-copy">© {{ date('Y') }}. UPTD Terminal dan Perparkiran<br>Dinas Perhubungan Kabupaten Sinjai.</p>
            <p class="skm-footer-motto">Sinjai Maju<br><strong>Bersama Masyarakat</strong><span aria-hidden="true"></span></p>
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
