# 01 — Builder data tren multi-tahun

**What to build:** Mekanisme bersama untuk menyusun data tren per indikator lintas tahun, dipakai oleh halaman admin Analisis dan dashboard publik. Untuk sebuah indikator dan cakupan tahun tertentu, builder menghasilkan: daftar tahun terurut, rangkaian nilai target per tahun, rangkaian nilai realisasi per tahun, dan nilai baseline (nilai & tahun). Tahun yang tidak memiliki target maupun realisasi dilewati (dianggap tidak ada), bukan diinterpolasi. Builder menerima pilihan cakupan tahun: hanya tahun berstatus aktif atau semua tahun. Belum menampilkan UI apa pun.

**Blocked by:** None — can start immediately

**Status:** done

- [x] Untuk indikator dan cakupan tahun yang diberikan, menghasilkan daftar tahun terurut serta rangkaian target dan realisasi yang selaras.
- [x] Baseline ikut disertakan sesuai `nilai_baseline` dan `tahun_baseline` indikator.
- [x] Tahun yang tidak punya target maupun realisasi dilewati (tidak diinterpolasi).
- [x] Cakupan tahun "aktif saja" menghasilkan hanya tahun berstatus aktif; cakupan "semua" menghasilkan seluruh tahun.
- [x] Test unit mencakup urutan tahun, pelewatan data kosong, penyertaan baseline, dan perbedaan filter tahun.

## Status

Dikerjakan pada commit `d6bce4a` dan `ff30df5` (branch `try`). Seluruh checklist terpenuhi; 8 test unit lulus bersama suite penuh (18 test, 40 asersi).

Implementasi:
- `app/Services/DataTren.php` — value object (larik paralel tahun/target/realisasi + baseline, `toArray()`, `kosong()`).
- `app/Services/DataTrenBuilder.php` — mekanisme bersama; `build(Indikator, $scope)` dengan `SCOPE_AKTIF`/`SCOPE_SEMUA`, urutan naik berdasarkan nilai tahun, tahun tanpa data dilewati, baseline ikut.
- `database/factories/{Pilar,Tahun,Indikator,Target,Realisasi}Factory.php` + perbaikan `UserFactory`.
- `tests/Unit/DataTrenBuilderTest.php` — 8 test.

Perbaikan infrastruktur agar suite test SQLite dapat berjalan (masalah pra-ada): migrasi `remove_tahun_column`, `fix_target_and_realisasi_unique_index`, `add_instansi_id_to_users_table`, dan `UserFactory`.
