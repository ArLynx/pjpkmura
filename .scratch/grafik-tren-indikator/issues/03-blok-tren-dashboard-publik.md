# 03 — Blok tren pada dashboard publik

**What to build:** Blok "Tren Indikator" pada dashboard publik (`/dashboard`) yang menampilkan grafik tren multi-tahun per indikator. Pengunjung memilih Pilar lalu Indikator melalui dropdown dan melihat line chart yang membandingkan target, realisasi, dan baseline. Hanya tahun berstatus aktif dan data yang layak tampil publik yang ditampilkan. Chart.js dipasang via CDN pada layout frontend. Memanfaatkan builder data tren yang sama dengan halaman admin.

**Blocked by:** 01 — Builder data tren multi-tahun

**Status:** done

- [x] Blok "Tren Indikator" muncul pada dashboard publik dengan dropdown Pilar → Indikator.
- [x] Memilih indikator memuat line chart target, realisasi, dan baseline.
- [x] Hanya tahun berstatus aktif yang ditampilkan.
- [x] Tahun tanpa data dilewati pada grafik (bukan diinterpolasi).
- [x] Tampilan tabel monitoring yang sudah ada tidak berubah.
- [x] Feature test: dashboard publik memuat data tren dengan hanya tahun aktif.
- [x] Memilih pilar/indikator memuat grafik tanpa me-refresh halaman (via AJAX) sehingga posisi scroll tidak bergeser.

## Status

Dikerjakan di cabang `try`. Seluruh checklist terpenuhi; feature test baru lulus bersama suite penuh (24 test, 60 asersi).

Implementasi:
- `app/Http/Controllers/Frontend/DashboardController.php` — menangani parameter GET `pilar_tren`/`indikator_tren`, memuat indikator per pilar, dan membangun data tren dengan `DataTrenBuilder::SCOPE_AKTIF` (hanya tahun aktif) untuk indikator terpilih. Ditambah metode `trenData()` (GET `/dashboard/tren-data`) yang mengembalikan JSON (indikator per pilar + data tren indikator terpilih) untuk pemuatan via AJAX.
- `resources/views/frontend/dashboard.blade.php` — blok "Tren Indikator" dengan dropdown bertingkat Pilar → Indikator dan kanvas `trenChart`; dataset Target, Realisasi, dan Baseline dirender via Chart.js. Pemilihan pilar/indikator memuat ulang data grafik lewat `fetch` (endpoint `dashboard.trenData`) tanpa submit form, sehingga halaman tidak me-refresh dan posisi scroll terjaga. Tabel monitoring yang sudah ada tidak diubah.
- `resources/views/frontend/layouts/app.blade.php` — memasang Chart.js via CDN dan menyediakan `@stack('scripts')`.
- `routes/web.php` — menambahkan rute GET `/dashboard/tren-data` untuk endpoint AJAX blok tren.
- `tests/Feature/DashboardPublicTrenTest.php` — 6 feature test (blok muncul, hanya tahun aktif, baseline, dropdown indikator per pilar, dan 2 test untuk endpoint JSON `trenData`).
