# PJPK Kabupaten Murung Raya

Aplikasi Laravel untuk pemantauan indikator Pembangunan Jangka Panjang Kependudukan Kabupaten Murung Raya. Versi ini sudah dilengkapi autentikasi admin dan CRUD sesuai struktur database proyek.

## Fitur yang tersedia

- Login memakai username atau email
- Opsi ingat saya dan logout aman
- Proteksi seluruh halaman admin dengan middleware autentikasi
- Penolakan akses untuk akun nonaktif
- Pembatasan kelola pengguna khusus superadmin
- CRUD pengguna
- CRUD pilar
- CRUD indikator
- CRUD target tahunan
- CRUD realisasi tahunan
- CRUD data pendukung dengan unggahan file
- CRUD berita dengan unggahan foto
- CRUD publikasi dengan cover dan dokumen
- Edit profil dan kata sandi
- Validasi duplikasi target dan realisasi berdasarkan indikator dan tahun
- Penghapusan file fisik saat dokumen, berita, publikasi, realisasi, indikator, atau pilar dihapus

## Persyaratan

- PHP 8.3 atau lebih baru
- Composer
- MySQL atau MariaDB
- Ekstensi PHP: PDO MySQL, mbstring, fileinfo, openssl, tokenizer, XML, dan DOM
- Node.js hanya diperlukan bila ingin membangun ulang aset frontend publik

## Instalasi

1. Salin dan atur file lingkungan.

```bash
cp .env.example .env
php artisan key:generate
```

2. Sesuaikan koneksi database pada `.env`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pjpkmura
DB_USERNAME=root
DB_PASSWORD=
```

3. Jalankan migrasi dan seeder.

```bash
php artisan migrate
php artisan db:seed
```

4. Buat symbolic link untuk file unggahan.

```bash
php artisan storage:link
```

5. Jalankan aplikasi.

```bash
php artisan serve
```

Panel login tersedia pada `/login`. Panel admin tersedia pada `/admin/dashboard`.

## Akun awal

Seeder membuat akun berikut bila username tersebut belum tersedia:

```text
Username: superadmin
Email: admin@pjpkmura.go.id
Password: Admin@12345
```

Ubah nilai berikut pada `.env` sebelum menjalankan seeder di server produksi:

```env
PJPK_ADMIN_NAME="Super Administrator"
PJPK_ADMIN_USERNAME=superadmin
PJPK_ADMIN_EMAIL=admin@pjpkmura.go.id
PJPK_ADMIN_PASSWORD=kata-sandi-yang-kuat
```

Segera ganti kata sandi awal melalui menu Profil setelah login.

## Aset frontend

Halaman login dan panel admin memakai Tailwind CDN sesuai HTML desain yang diberikan. Halaman publik tetap memakai Vite. Untuk membangun ulang aset halaman publik:

```bash
rm -rf node_modules
npm install
npm run build
```

## Pengujian

```bash
php artisan test
```

Pengujian mencakup login, akun nonaktif, proteksi halaman admin, logout, pembatasan superadmin, dan pembuatan data pilar.
