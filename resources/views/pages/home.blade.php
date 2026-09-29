@extends('layouts.app')
@section('title', 'Beranda')
@section('content')
<div class="page-kicker"><span class="eyebrow"><span class="live-dot"></span> PERSONAL ACADEMIC SPACE</span><span class="muted kicker-note">Belajar. Bereksperimen. Bertumbuh.</span></div>
@if($visitor)
    <x-status-banner title="Senang bertemu denganmu!" class="welcome-banner">Selamat datang, {{ $visitor }}. Mari jelajahi ruang akademik ini.</x-status-banner>
@endif
<section class="hero">
    <div class="hero-copy">
        <span class="pill peach"><x-icon name="spark" size="15" /> Dari rasa ingin tahu, menjadi karya.</span>
        <h1>Ruang untuk belajar,<br>berani <span>berinovasi.</span></h1>
        <p>Halo, saya <strong>{{ $profile['short_name'] }}.</strong><br>Mahasiswa {{ $profile['program'] }} ITS yang sedang mengeksplorasi pertemuan antara pengembangan web dan Agentic AI.</p>
        <div class="hero-actions"><a class="button primary" href="{{ route('ideas', $themeQuery) }}">Jelajahi riset saya <x-icon name="arrow" size="18" /></a><a class="button text-button" href="{{ route('profile', $themeQuery) }}">Kenali lebih dekat <x-icon name="external" size="17" /></a></div>
        <div class="hero-caption"><span class="mini-line"></span> Satu langkah kecil menuju teknologi yang lebih baik.</div>
    </div>
    <div class="agent-art" aria-label="Ilustrasi rancangan agen AI yang menghubungkan pengujian, keamanan, dan perbaikan kode">
        <div class="art-topline"><span><span class="live-dot"></span> THE NEXT EXPLORATION</span><span>01 / AI</span></div>
        <div class="orbital-area"><div class="orbit orbit-one"></div><div class="orbit orbit-two"></div><div class="orbit orbit-three"></div><div class="orbit-line horizontal"></div><div class="orbit-line vertical"></div>
            <div class="agent-center"><x-icon name="spark" size="36" /><span>Agentic AI</span><small>THINK · ACT · IMPROVE</small></div>
            <div class="orbit-node node-qa"><span class="node-icon blue"><x-icon name="code" /></span><span>Quality Assurance</span><i></i></div>
            <div class="orbit-node node-security"><span class="node-icon green"><x-icon name="shield" /></span><span>Security Testing</span><i></i></div>
            <div class="orbit-node node-repair"><span class="node-icon orange"><x-icon name="spark" /></span><span>Automated Repair</span><i></i></div>
            <span class="orbit-point point-one"></span><span class="orbit-point point-two"></span>
        </div>
        <div class="art-bottomline"><span>Better web. Smarter systems.</span><span class="art-badge">Rancangan riset <x-icon name="external" size="13" /></span></div>
    </div>
</section>
<section class="overview-strip" aria-label="Ringkasan akademik"><div><span class="strip-icon"><x-icon name="book" /></span><div><small>PROGRAM STUDI</small><strong>{{ $profile['program'] }}</strong></div></div><div><span class="strip-icon"><x-icon name="flask" /></span><div><small>FOKUS EKSPLORASI</small><strong>Agentic AI & Web Engineering</strong></div></div><div><span class="strip-icon"><x-icon name="pin" /></span><div><small>KAMPUS</small><strong>ITS, Surabaya</strong></div></div></section>
<section class="explore-section"><div class="section-heading"><div><span class="eyebrow muted">MULAI DARI SINI</span><h2>Kenali ruang ini.</h2></div><p>Profil, eksplorasi, dan ide yang terus bertumbuh.</p></div>
<div class="explore-grid">
    <article class="panel profile-preview"><div class="card-top"><span class="label">01 / TENTANG SAYA</span><x-icon name="user" /></div><div class="person-row"><span class="avatar">{{ $profile['initials'] }}</span><div><h3>{{ $profile['short_name'] }}</h3><p>Mahasiswa Teknik Informatika</p></div></div><p class="muted card-description">Mengenal sosok di balik ide, perjalanan akademik, dan ruang eksplorasinya.</p><a class="card-link" href="{{ route('profile', $themeQuery) }}">Lihat profil mahasiswa <x-icon name="arrow" size="18" /></a></article>
    <article class="panel research-preview"><div class="card-top"><span class="label">02 / RISET KELOMPOK</span><span class="pill green-pill">Tahap perancangan</span></div><h3>Membangun web yang lebih<br>andal dengan Agentic AI.</h3><p class="muted card-description">Dari pengujian kualitas dan keamanan hingga perbaikan otomatis dalam satu alur kolaborasi agen.</p><div class="tags"><span>Quality Assurance</span><span>Security</span><span>Auto Repair</span></div><a class="card-link" href="{{ route('ideas', $themeQuery) }}#rancangan">Lihat rancangan platform <x-icon name="arrow" size="18" /></a></article>
    <article class="panel idea-preview"><span class="idea-spark"><x-icon name="spark" size="28" /></span><span class="label">03 / RUANG KOLABORASI</span><h3>Ide bagus bisa<br>datang dari siapa saja.</h3><p>Punya sudut pandang baru? Mari berbagi ide untuk riset berikutnya.</p><a class="button light-button" href="{{ route('ideas', $themeQuery) }}#form-ide">Bagikan idemu <x-icon name="external" size="17" /></a></article>
</div></section>
<div class="bottom-note"><x-icon name="code" size="17" /><p>Dibangun sebagai bagian dari perjalanan belajar <strong>Pemrograman Berbasis Kerangka Kerja.</strong></p><span>Pertemuan 04</span></div>
@endsection
