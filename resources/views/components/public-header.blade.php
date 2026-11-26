@props([
    'active' => null,
    'subtitle' => null,
    'complaintUrl' => null,
    'complaintLabel' => 'Kirim Aduan',
])

@php
    $anchorPrefix = $active === 'home' ? '' : route('home');
@endphp

<header class="public-header">
    <div class="container public-nav">
        <a class="public-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo-sapa-jukir.png') }}" alt="Logo SAPA JUKIR" style="height: 32px; width: auto; object-fit: contain;">
            @if($subtitle)
                <span class="public-brand-copy"><strong>SAPA JUKIR</strong><small>{{ $subtitle }}</small></span>
            @else
                <span>SAPA JUKIR</span>
            @endif
        </a>

        <button class="nav-toggle" type="button" aria-label="Buka menu" aria-expanded="false">&#9776;</button>

        <nav class="nav-links" aria-label="Navigasi utama">
            <a @if($active === 'home') class="active" aria-current="page" @endif href="{{ $anchorPrefix }}#top">Beranda</a>
            <a href="{{ $anchorPrefix }}#features">Fitur Utama</a>
            <a href="{{ $anchorPrefix }}#achievement">Pencapaian</a>
            <a href="{{ $anchorPrefix }}#area">Area Pendapatan</a>
            <a href="{{ $anchorPrefix }}#about">Tentang</a>
            <a @if($active === 'gallery') class="active" aria-current="page" @endif href="{{ route('gallery') }}">Galeri</a>
            <a @if($active === 'news') class="active" aria-current="page" @endif href="{{ route('news.index') }}">Berita</a>
            <a @if($active === 'skm') class="active" aria-current="page" @endif href="{{ route('skm') }}">SKM</a>
            <a href="{{ route('login') }}">Login</a>
            <div class="public-nav-actions">
                <button class="theme-toggle" type="button" aria-label="Ubah mode tampilan" aria-pressed="false" title="Mode gelap">
                    <span class="theme-toggle-icon" aria-hidden="true">☀️</span>
                </button>
                <a class="complaint-link" @if($active === 'pengaduan') aria-current="page" @endif href="{{ $complaintUrl ?? route('pengaduan.create') }}">{{ $complaintLabel }}</a>
            </div>
        </nav>
    </div>
</header>
