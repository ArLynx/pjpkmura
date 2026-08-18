Status: ready-for-agent
Type: spec

# Grafik Tren Multi-Tahun Indikator

## Problem Statement

Sistem PJPK saat ini menampilkan capaian indikator per tahun (mode "Tahunan") dan agregat tabel lintas tahun (mode "Gabungan"), namun keduanya berbentuk tabel. Pengguna — baik publik maupun admin — tidak dapat melihat dengan cepat bagaimana sebuah indikator berkembang dari tahun ke tahun (tren target vs realisasi). Perjalanan jangka panjang setiap indikator tidak terlihat secara visual, sehingga sulit menilai kemajuan pembangunan kependudukan secara sekilas.

## Solution

Tambahkan **grafik tren multi-tahun per indikator** berupa *line chart* yang membandingkan target, realisasi, dan baseline sepanjang tahun. Grafik ditampilkan di dua tempat:

1. **Dashboard publik** (`/dashboard`) — blok "Tren Indikator" yang ringkas, hanya menampilkan tahun berstatus aktif dan data yang tampil publik.
2. **Halaman admin "Analisis"** (baru) — grafik yang sama dilengkapi tabel detail target/realisasi/status per tahun, menampilkan semua tahun.

Pengguna memilih indikator melalui dropdown bertingkat Pilar → Indikator. Tahun tanpa data (belum diisi target/realisasi) dilewati, bukan diinterpolasi.

## User Stories

1. Sebagai pengunjung publik, saya ingin memilih sebuah indikator melalui dropdown Pilar → Indikator, sehingga saya dapat melihat grafik tren target vs realisasi untuk indikator tersebut.
2. Sebagai pengunjung publik, saya ingin grafik menampilkan garis target dan garis realisasi sepanjang tahun aktif, sehingga saya dapat melihat perkembangan indikator secara visual.
3. Sebagai pengunjung publik, saya ingin nilai baseline (nilai & tahun baseline) muncul sebagai titik acuan pada grafik, sehingga saya dapat menilai kemajuan relatif terhadap titik awal.
4. Sebagai pengunjung publik, saya ingin tahun yang datanya kosong dilewati (bukan disambung), sehingga grafik tidak menyesatkan dengan garis interpolasi yang menutupi data yang sebenarnya hilang.
5. Sebagai pengunjung publik, saya ingin dropdown hanya memuat indikator yang relevan sesuai pilar yang saya pilih, sehingga pemilihan indikator cepat dan tidak membingungkan.
6. Sebagai admin, saya ingin membuka halaman "Analisis" dari menu samping, sehingga saya dapat mengeksplorasi tren semua indikator.
7. Sebagai admin, saya ingin halaman Analisis menampilkan semua tahun (termasuk tahun non-aktif), sehingga saya dapat memeriksa data lengkap tanpa dibatasi status tahun.
8. Sebagai admin, saya ingin di bawah grafik terdapat tabel detail yang memuat target, realisasi, dan status pencapaian per tahun untuk indikator terpilih, sehingga saya dapat memverifikasi angka di balik grafik.
9. Sebagai admin superadmin dan admin OPD, saya ingin halaman Analisis dapat diakses oleh kedua peran, sehingga seluruh pengelola data dapat memantau tren.
10. Sebagai admin, saya ingin memilih indikator melalui dropdown Pilar → Indikator yang sama seperti publik, sehingga konsistensi interaksi terjaga.
11. Sebagai pengembang, saya ingin data tren dibangun melalui satu mekanisme bersama yang dipakai publik dan admin, sehingga perilaku (pengurutan tahun, pelewatan data kosong, penyertaan baseline) konsisten di kedua tempat.
12. Sebagai pengembang, saya ingin grafik dirender dengan Chart.js via CDN, konsisten dengan pendekatan Tailwind CDN yang sudah dipakai, sehingga tidak menambah langkah build.

## Implementation Decisions

- **Library**: Chart.js via CDN, ditambahkan ke kedua layout (admin & frontend). Tidak menggunakan bundling npm/Vite untuk chart; konsisten dengan Tailwind CDN yang ada.
- **Bentuk visual**: *line chart* dasar. Sumbu X = tahun, sumbu Y = nilai indikator. Tiga dataset: Target, Realisasi, dan Baseline. Baseline dirender sebagai titik acuan (garis putus-putus / titik tunggal di tahun baseline).
- **Cakupan grafik**: satu grafik per indikator yang dipilih; pengguna mengganti indikator lewat dropdown. Tidak ada perbandingan multi-indikator dalam satu kanvas.
- **Pemilihan indikator**: dropdown bertingkat (form GET, reload halaman) — pilih Pilar terlebih dahulu, lalu pilih Indikator milik pilar tersebut.
- **Data tahun**:
  - **Publik**: hanya tahun berstatus `aktif` (konsisten dengan filter dashboard yang ada).
  - **Admin**: semua tahun.
  - Tahun yang tidak memiliki target maupun realisasi **dilewati** (nilai dianggap tidak ada), bukan diinterpolasi. Di Chart.js ini direpresentasikan dengan `spanGaps: false`.
- **Baseline**: `nilai_baseline` dan `tahun_baseline` dari indikator ditampilkan sebagai titik awal acuan pada grafik.
- **Mekanisme data bersama**: satu builder/pendefinisian data tren yang dipakai publik dan admin, sehingga pengurutan, pelewatan data kosong, dan penyertaan baseline konsisten. Data diserialize ke JavaScript (mis. `@json()`) dan dirender pada kanvas.
- **Halaman admin "Analisis"** (baru): route GET `admin.analisis.index`, menu di sidebar terlihat untuk superadmin dan admin OPD (dekat menu Capaian), halaman berisi dropdown + kanvas grafik + tabel detail per tahun (target, realisasi, status pencapaian).
- **Dashboard publik**: tambah blok "Tren Indikator" dengan dropdown Pilar → Indikator dan kanvas grafik. Tidak mengubah tampilan tabel monitoring yang sudah ada.
- Tidak ada perubahan skema database; data bersumber dari relasi `targets`, `realisasis`, dan kolom baseline `indikators` yang sudah ada.

## Testing Decisions

- **Seam utama**: feature test HTTP, mengikuti pola `AdminCrudTest` (buka route dengan user terautentikasi, periksa respons dan data view).
- **Modul yang diuji**:
  - Halaman admin `Analisis` terbuka (OK) untuk superadmin dan admin OPD; memuat indikator terpilih beserta data tren yang benar.
  - Dashboard publik memuat data tren dengan hanya tahun aktif.
  - Pelewatan tahun kosong: ketika suatu tahun tidak punya target/realisasi, nilai tahun tersebut tidak ikut dalam rangkaian data.
  - Penyertaan baseline sesuai `nilai_baseline`/`tahun_baseline`.
- **Apa yang membuat tes baik**: menguji perilaku eksternal (halaman terbuka dan data view benar), bukan detail implementasi render Chart.js.
- **Prior art**: `tests/Feature/AdminCrudTest.php` memakai `RefreshDatabase`, factory user, dan assertion route + `assertDatabaseHas`.

## Out of Scope

- Perbandingan multi-indikator dalam satu grafik.
- Filter rentang tahun yang bisa dipilih pengguna.
- Grafik agregat per pilar (agregasi seluruh indikator menjadi satu rangkaian).
- Persentase capaian (realisasi/target) sebagai dataset tambahan.
- Alur verifikasi/approval realisasi oleh superadmin.
- Audit trail / log aktivitas.
- Perubahan skema database atau penambahan library chart via npm/Vite.

## Further Notes

- Keputusan awal ("mulai sesederhana mungkin") berarti fitur pertama hanya mencakup line chart dasar per-indikator tanpa % capaian maupun filter rentang. Pengayaan seperti % capaian, filter rentang, dan agregat per pilar dapat menjadi spesifikasi lanjutan.
- Publik hanya menampilkan data yang layak tampil (tahun aktif); admin melihat semua data.
