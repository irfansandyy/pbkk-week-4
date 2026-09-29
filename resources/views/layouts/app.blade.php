<!DOCTYPE html>
<html lang="id" @class(['dark' => $isDark])>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ruang akademik Mochammad Irfan Sandy. Profil mahasiswa, rancangan Agentic AI, dan ruang berbagi ide riset.">
    <meta name="color-scheme" content="{{ $isDark ? 'dark' : 'light' }}">
    <title>@yield('title') · Ruang Akademik</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    // Kelas lengkap agar kedua tema terdeteksi saat Tailwind dikompilasi.
    $themeClasses = $isDark ? 'bg-slate-950 text-slate-100' : 'bg-stone-50 text-slate-900';
@endphp
<body class="{{ $themeClasses }}">
    <a class="skip-link" href="#main">Lewati ke konten</a>
    <header class="site-header">
        <div class="shell header-inner">
            <a class="brand" href="{{ route('home', $themeQuery) }}" aria-label="Ruang Akademik — Beranda"><span class="brand-mark"><x-icon name="book" size="23" /></span><span>ruang<span class="brand-light">akademik</span><span class="brand-dot">.</span></span></a>
            <nav class="main-nav" aria-label="Navigasi utama">
                @foreach(['home' => 'Beranda', 'profile' => 'Profil Mahasiswa', 'ideas' => 'Ide & Riset'] as $name => $label)
                    <a href="{{ route($name, $themeQuery) }}" @class(['nav-link', 'active' => request()->routeIs($name) || ($name === 'home' && request()->routeIs('welcome'))]) @if(request()->routeIs($name) || ($name === 'home' && request()->routeIs('welcome'))) aria-current="page" @endif>{{ $label }}</a>
                @endforeach
            </nav>
            <div class="header-tools">
                <a class="icon-button theme-toggle" href="{{ request()->fullUrlWithQuery(['mode' => $isDark ? 'light' : 'dark']) }}" aria-label="{{ $isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap' }}" title="{{ $isDark ? 'Mode terang' : 'Mode gelap' }}"><x-icon :name="$isDark ? 'sun' : 'moon'" /></a>
                <span class="header-divider"></span><a class="avatar small" href="{{ route('profile', $themeQuery) }}" aria-label="Profil {{ $profile['name'] }}">{{ $profile['initials'] }}</a>
            </div>
        </div>
    </header>
    <main id="main" class="shell" tabindex="-1">@yield('content')</main>
    <footer class="site-footer shell"><div><strong>ITS<span class="footer-dot"> / </span></strong><span>Institut Teknologi Sepuluh Nopember</span></div><p>Ruang belajar, ruang bertumbuh.<span class="footer-year">© {{ date('Y') }}</span></p></footer>
</body>
</html>
