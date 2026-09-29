# Ruang Akademik

Mini-website akademik **Mochammad Irfan Sandy — 5025241127 — Teknik Informatika ITS**, untuk tugas mandiri PBKK pertemuan 4 (halaman 38–43).

Topik kelompok: **Agentic AI-Based Web Application Quality Assurance, Security Testing, and Automated Repair System**. Diagram merupakan rancangan platform, bukan implementasi mesin pengujian atau agen AI.

## Menjalankan proyek

Prasyarat: PHP 8.2+, Composer, Node.js 20.19+ atau 22.12+, NPM, dan ekstensi PHP standar Laravel.

```bash
composer install
cp .env.example .env
php artisan key:generate
npm ci
npm run build
php artisan serve
```

Buka http://127.0.0.1:8000. Tidak perlu membuat database atau menjalankan migrasi: sesi dan cache menggunakan berkas lokal. Jika `.env` sudah ada, jangan menimpanya; pastikan `SESSION_DRIVER=file`, `CACHE_STORE=file`, dan `QUEUE_CONNECTION=sync`.

Saat mengembangkan tampilan, gunakan `composer run dev` untuk menjalankan Laravel dan Vite sekaligus. Setelah perubahan selesai, gunakan `npm run build` untuk menghasilkan aset produksi lokal.

## Halaman dan fitur

| URL | Fungsi |
| --- | --- |
| `/` | Beranda, ringkasan akademik, dan pengantar riset |
| `/profil-mahasiswa` | Identitas mahasiswa dan bidang eksplorasi |
| `/ide-agent` | Diagram rancangan platform, formulir, dan riwayat ide sesi |
| `/ide-agent?mode=dark` | Tantangan 1: mode gelap dari parameter URL |
| `/beranda?user=Andi` | Tantangan 2: sapaan dinamis melalui komponen notifikasi |
| `/beranda?user=Andi&mode=dark` | Kedua tantangan sekaligus |

Tombol bulan/matahari mengubah parameter `mode`. Tema ikut dipertahankan saat berpindah halaman dan mengirim formulir. Formulir memvalidasi nama, judul, kategori, dan deskripsi di server, mempertahankan input ketika gagal, dan memakai token CSRF. Semua data pengguna dirender dengan escaping Blade.

Ide disimpan sementara di sesi browser (maksimal 20 ide terakhir, sesi default 120 menit), bukan sebagai koleksi bersama atau database permanen. Setelah sesi berakhir, daftar tidak tersedia melalui sesi baru. Riwayat pengiriman tidak ditanam sebagai data contoh.

## Pemetaan rubrik

| Kriteria | Implementasi |
| --- | --- |
| Master layout / `@extends` (30%) | `resources/views/layouts/app.blade.php`; ketiga view `pages/*` mewarisinya. Memuat title dinamis, navbar, container dan footer ITS. |
| Komponen & slot (25%) | `components/info-card.blade.php` menerima `label`, `value`, `icon`, slot isi, serta attributes. `components/status-banner.blade.php` menerima `type`, `title`, `dismissible`, slot isi, serta attributes. Keduanya dipanggil pada halaman. |
| Vite (25%) | Tailwind CSS 4 dan JavaScript dibundel melalui NPM, `vite.config.js`, dan `@vite`. Tidak ada aset CDN. |
| Desain UI (10%) | Layout responsif, tema terang/gelap, label input, fokus keyboard, error per field, tautan lewati konten, dan reduced motion. |
| Challenge (10%) | Variabel Blade `$themeClasses` memilih kelas Tailwind literal berdasarkan `mode`; `PageController::home` membaca parameter `user` dengan aman. |

Semua rute halaman dan penerimaan formulir ditangani satu `app/Http/Controllers/PageController.php`. Identitas dan judul proyek dapat diubah di `config/academic.php`.

## Pengujian

```bash
php artisan test
vendor/bin/pint --test
npm run build
```

Pengujian fitur mencakup rendering ketiga halaman, data profil, tema gelap, sapaan dinamis, escaping HTML, input URL berbentuk array, pengiriman ide, validasi dan pemulihan input, redirect tema, flash message, serta batas 20 ide.

## Alur demo singkat

1. Buka `/` dan navigasi ke profil untuk menunjukkan identitas.
2. Buka `/ide-agent`, jelaskan diagram input → QA/security → repair → review/retest.
3. Aktifkan mode gelap, kirim ide, lalu tunjukkan notifikasi dan riwayat sesi.
4. Buka `/beranda?user=Andi` untuk sapaan dinamis.
5. Tunjukkan master layout, `@extends`, kedua komponen, dan konfigurasi Vite.

## Persiapan pengumpulan

`.gitignore` mengecualikan `.env`, `vendor/`, `node_modules/`, hasil build, dan berkas sesi/log. Sertakan `composer.lock`, `package-lock.json`, dan `.env.example` di repositori. Source code disiapkan lokal; unggah ke GitHub dan pengumpulan tautan LMS dilakukan terpisah oleh pemilik tugas.

## Referensi implementasi

- [Laravel — Vite](https://laravel.com/docs/12.x/vite)
- [Tailwind CSS — Laravel + Vite](https://tailwindcss.com/docs/installation/framework-guides/laravel/vite)
