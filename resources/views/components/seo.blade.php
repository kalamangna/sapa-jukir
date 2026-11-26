@props([
    'title',
    'description' => 'SAPA JUKIR adalah sistem informasi petugas parkir dan retribusi Dinas Perhubungan Kabupaten Sinjai.',
    'image' => null,
    'type' => 'website',
    'noindex' => false,
])
@php
    // Canonical mengikuti APP_URL agar dua alamat server tetap menunjuk ke satu URL utama.
    $path = trim(request()->path(), '/');
    $canonical = rtrim(config('app.url'), '/').($path === '' ? '' : '/'.$path);
    $previewImage = $image ?: asset('images/Gambar Hero.jpeg');
    $summary = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($description))), 160);
@endphp
<title>{{ $title }}</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
@if ($noindex)
<meta name="robots" content="noindex, nofollow">
@else
<meta name="description" content="{{ $summary }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ $canonical }}">
<meta property="og:locale" content="id_ID">
<meta property="og:site_name" content="SAPA JUKIR Kabupaten Sinjai">
<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $summary }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $previewImage }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $summary }}">
<meta name="twitter:image" content="{{ $previewImage }}">
@endif
