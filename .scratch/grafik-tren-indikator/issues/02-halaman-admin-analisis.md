# 02 — Halaman admin Analisis

**What to build:** Halaman admin "Analisis" yang menampilkan grafik tren multi-tahun per indikator untuk superadmin dan admin OPD. Dari menu samping, pengguna membuka halaman, memilih Pilar lalu Indikator melalui dropdown, dan melihat line chart yang membandingkan target, realisasi, dan baseline sepanjang semua tahun. Di bawah grafik terdapat tabel detail target, realisasi, dan status pencapaian per tahun untuk indikator terpilih. Chart.js dipasang via CDN pada layout admin. Menampilkan semua tahun (termasuk non-aktif).

**Blocked by:** 01 — Builder data tren multi-tahun

**Status:** done

- [x] Menu "Analisis" muncul di sidebar untuk superadmin dan admin OPD, dan mengarah ke halaman yang benar.
- [x] Halaman menampilkan dropdown bertingkat Pilar → Indikator; memilih indikator memuat grafik yang sesuai.
- [x] Line chart menampilkan dataset target, realisasi, dan baseline sepanjang semua tahun.
- [x] Tahun tanpa data dilewati pada grafik (bukan diinterpolasi).
- [x] Tabel detail di bawah grafik memuat target, realisasi, dan status pencapaian per tahun.
- [x] Feature test: halaman terbuka (OK) untuk superadmin dan admin OPD; data view berisi indikator terpilih beserta data tren yang benar.
