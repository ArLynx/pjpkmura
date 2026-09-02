<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Capaian {{ $tahun->tahun }}
    </title>

    <style>
        @page {
            size: A4 landscape;
            margin: 12mm 8mm 15mm 8mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 7.5px;
            color: #111;
            margin: 0;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .header {
            text-align: center;
            margin-bottom: 8px;
        }

        .header h1 {
            font-size: 14px;
            margin: 0;
            font-weight: bold;
        }

        .header h2 {
            font-size: 10px;
            margin: 3px 0 0;
            font-weight: bold;
        }

        /* =========================================================
           IDENTITAS
        ========================================================= */

        .identitas {
            width: 100%;
            margin-bottom: 8px;
        }

        .identitas td {
            padding: 2px 0;
            vertical-align: top;
        }

        .identitas .label {
            width: 55px;
            font-weight: bold;
        }

        /* =========================================================
           TABEL UTAMA
        ========================================================= */

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 3px;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        thead th {
            text-align: center;
            font-weight: bold;
            background: #e8e8e8;
            vertical-align: middle;
        }

        .group-header {
            text-align: center;
            font-weight: bold;
            background: #dedede;
        }

        /* =========================================================
           SASARAN / PILAR
        ========================================================= */

        .sasaran-row td {
            font-weight: bold;
            background: #eeeeee;
            text-align: left;
            padding: 4px;
        }

        .pilar-row td {
            font-weight: bold;
            background: #eeeeee;
            font-size: 8.5px;
            padding: 4px;
            text-align: left;
            font-style: italic;
        }

        /* =========================================================
           DATA
        ========================================================= */

        .center {
            text-align: center;
        }

        .indikator {
            font-weight: bold;
        }

        .status-tercapai {
            color: #008000;
            font-weight: bold;
        }

        .status-tidak {
            color: #b00000;
            font-weight: bold;
        }

        .status-belum {
            color: #555;
        }

        .wrap {
            white-space: pre-line;
        }

        .small {
            font-size: 7px;
        }

        /* =========================================================
        TANDA TANGAN
        ========================================================= */

        .signature-wrapper {
            width: 100%;
            margin-top: 25px;
        }

        .signature {
            width: 45%;
            margin-left: 55%;
            text-align: center;
        }

        .signature-date {
            margin-bottom: 8px;
            font-size: 8px;
        }

        .signature-title {
            margin-top: 7px;

            font-size: 8px;
            line-height: 1.35;
            font-weight: bold;

            text-align: center;

            /* penting untuk nama instansi panjang */
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .signature-space {
            height: 75px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 75%;
            margin: 0 auto;
        }

        .signature-name {
            margin-top: 5px;
            font-size: 8px;
            line-height: 1.35;
            font-weight: bold;
            text-align: center;
        }

        .signature-pangkat {
            font-size: 8px;
            line-height: 1.35;
            text-align: center;
        }

        .signature-nip {
            font-size: 8px;
            line-height: 1.35;
            text-align: center;
        }

        .signature-instansi {
            max-width: 100%;
            margin: 0 auto;
        }
    </style>

</head>

<body>

    {{-- =========================================================
         JUDUL
    ========================================================= --}}

    <div class="header">

        <h1>
            LAPORAN RENCANA AKSI PETA JALAN
            PEMBANGUNAN KEPENDUDUKAN
        </h1>

        <h2>
            KABUPATEN MURUNG RAYA
        </h2>

    </div>


    {{-- =========================================================
     IDENTITAS LAPORAN
    ========================================================= --}}

    <div style="margin-bottom: 8px;">

        <div style="height: 16px;">

            <span
                style="
            display: inline-block;
            width: 95px;
            font-weight: bold;
        ">
                Provinsi
            </span>

            <span style="
            display: inline-block;
            width: 10px;
        ">
                :
            </span>

            <span>
                KALIMANTAN TENGAH
            </span>

        </div>


        <div style="height: 16px;">

            <span
                style="
            display: inline-block;
            width: 95px;
            font-weight: bold;
        ">
                Kabupaten/Kota
            </span>

            <span style="
            display: inline-block;
            width: 10px;
        ">
                :
            </span>

            <span>
                KAB. MURUNG RAYA
            </span>

        </div>


        <div style="height: 16px;">

            <span
                style="
            display: inline-block;
            width: 95px;
            font-weight: bold;
        ">
                Tahun
            </span>

            <span style="
            display: inline-block;
            width: 10px;
        ">
                :
            </span>

            <span>
                {{ $tahun->tahun }}
            </span>

        </div>

    </div>


    {{-- =========================================================
         TABEL UTAMA
         
         TOTAL KOLOM = 12
         
         1  #
         2  INDIKATOR
         3  PENGAMPU
         4  TERKAIT
         5  TARGET
         6  REALISASI
         7  CAPAIAN
         8  SUMBER DATA
         9  NARASI
         10 HAMBATAN
         11 BUKTI DUKUNG
         12 EVALUASI
    ========================================================= --}}

    <table>

        <thead>

            {{-- HEADER BARIS 1 --}}

            <tr>

                <th rowspan="2" style="width: 3%;">
                    #
                </th>

                <th rowspan="2" style="width: 10%;">
                    INDIKATOR
                </th>

                <th colspan="2" style="width: 15%;">
                    DINAS
                </th>

                <th colspan="4" style="width: 27%;">
                    PETA JALAN PEMBANGUNAN KEPENDUDUKAN
                </th>

                <th colspan="3" style="width: 30%;">
                    RENCANA AKSI
                </th>

                <th rowspan="2" style="width: 9%;">
                    EVALUASI<br>
                    RENCANA AKSI
                </th>

            </tr>


            {{-- HEADER BARIS 2 --}}

            <tr>

                <th style="width: 7%;">
                    PENGAMPU
                </th>

                <th style="width: 8%;">
                    TERKAIT
                </th>

                <th style="width: 5.5%;">
                    TARGET
                </th>

                <th style="width: 5.5%;">
                    REALISASI
                </th>

                <th style="width: 6%;">
                    CAPAIAN<br>
                    (%)
                </th>

                <th style="width: 10%;">
                    SUMBER DATA
                </th>

                <th style="width: 10%;">
                    NARASI
                </th>

                <th style="width: 10%;">
                    HAMBATAN
                </th>

                <th style="width: 10%;">
                    BUKTI DUKUNG
                </th>

            </tr>

        </thead>


        <tbody>

            @php
                $nomor = 1;
            @endphp


            {{-- =================================================
                 LOOP PILAR
            ================================================== --}}

            @foreach ($data as $pilarId => $indikators)
                @php
                    $indikatorPertama = $indikators->first();

                    $namaPilar = $indikatorPertama->nama_pilar ?? '-';

                    $urutanPilar = $indikatorPertama->pilar_urutan ?? $loop->iteration;
                @endphp


                {{-- =================================================
                     SASARAN
                ================================================== --}}

                <tr class="sasaran-row">

                    <td colspan="12">
                        Sasaran {{ $urutanPilar }}
                    </td>

                </tr>


                {{-- =================================================
                     NAMA PILAR
                ================================================== --}}

                <tr class="pilar-row">

                    <td colspan="12">
                        {{ $namaPilar }}
                    </td>

                </tr>


                {{-- =================================================
                     DATA INDIKATOR
                ================================================== --}}

                @foreach ($indikators as $indikator)
                    <tr>

                        {{-- NO --}}

                        <td class="center">
                            {{ $nomor++ }}
                        </td>


                        {{-- INDIKATOR --}}

                        <td class="indikator">

                            {{ $indikator->nama_indikator }}

                        </td>


                        {{-- PENGAMPU --}}

                        <td>

                            {{ $indikator->nama_instansi ?: $indikator->instansi ?: '-' }}

                        </td>


                        {{-- TERKAIT --}}

                        <td>

                            {{ $indikator->instansi_pendukung ?: '-' }}

                        </td>


                        {{-- TARGET --}}

                        <td class="center">

                            {{ $indikator->nilai_target ?? '-' }}

                        </td>


                        {{-- REALISASI --}}

                        <td class="center">

                            {{ $indikator->nilai_realisasi ?? '-' }}

                        </td>


                        {{-- CAPAIAN --}}

                        <td class="center">

                            @if ($indikator->status_pencapaian === 'tercapai')
                                <span class="status-tercapai">
                                    Tercapai
                                </span>
                            @elseif ($indikator->status_pencapaian === 'belum_tercapai')
                                <span class="status-tidak">
                                    Tidak Tercapai
                                </span>
                            @else
                                <span class="status-belum">
                                    -
                                </span>
                            @endif

                        </td>


                        {{-- SUMBER DATA --}}

                        <td>

                            {{ $indikator->sumber_data ?: '-' }}

                        </td>


                        {{-- =================================================
                             NARASI
                        ================================================== --}}

                        <td class="wrap">

                            {{ $indikator->rencana_aksi ?: '-' }}

                        </td>


                        {{-- =================================================
                             HAMBATAN
                        ================================================== --}}

                        <td class="wrap">

                            {{ $indikator->hambatan ?: '-' }}

                        </td>


                        {{-- =================================================
                             BUKTI DUKUNG
                             
                             Mengambil file dari data_pendukungs.
                        ================================================== --}}

                        <td>

                            @if (!empty($indikator->file_pendukung))
                                {{ basename($indikator->file_pendukung) }}
                            @elseif (!empty($indikator->judul_pendukung))
                                {{ $indikator->judul_pendukung }}
                            @else
                                -
                            @endif

                        </td>


                        {{-- =================================================
                             EVALUASI
                        ================================================== --}}

                        <td class="wrap">

                            {{ $indikator->evaluasi ?: '-' }}

                        </td>

                    </tr>
                @endforeach
            @endforeach

        </tbody>

    </table>


    {{-- =========================================================
        TANDA TANGAN
    ========================================================= --}}

    <div class="signature-wrapper">

        <div class="signature">

            {{-- TANGGAL --}}
            <div class="signature-date">
                Puruk Cahu,
                {{ now()->translatedFormat('d F Y') }}
            </div>


            {{-- MENGETAHUI --}}
            <div>
                Mengetahui,
            </div>


            {{-- =========================================================
                JABATAN / INSTANSI PENANDATANGAN
            ========================================================= --}}

            @php
                $namaInstansi = $instansi->nama ?? 'PEMERINTAH';

                $namaInstansiLower = strtolower(trim($namaInstansi));

                // Deteksi Sekretariat Daerah / Setda / Sekda
                $isSekda =
                    str_contains($namaInstansiLower, 'sekretariat daerah') ||
                    str_contains($namaInstansiLower, 'setda') ||
                    str_contains($namaInstansiLower, 'sekda');
            @endphp


            <div class="signature-title">

                @if ($isSekda)

                    {{-- ============================
                        SEKRETARIAT DAERAH
                    ============================= --}}

                    <div>
                        Sekretaris Daerah
                    </div>

                    <div>
                        Kabupaten Murung Raya
                    </div>

                @else

                    {{-- ============================
                        DINAS / BADAN / INSTANSI LAIN
                    ============================= --}}

                    <div>
                        Kepala
                    </div>

                    <div class="signature-instansi">
                        {{ $namaInstansi }}
                    </div>

                    <div>
                        Kabupaten Murung Raya
                    </div>

                @endif

            </div>


            {{-- =========================================================
                RUANG TANDA TANGAN
            ========================================================= --}}

            <div class="signature-space">
            </div>


            {{-- =========================================================
                GARIS TANDA TANGAN
            ========================================================= --}}

            <div class="signature-line">
            </div>


            {{-- =========================================================
                IDENTITAS PIMPINAN
            ========================================================= --}}

            <div class="signature-name">
                {{ $user->nama_pimpinan ?? '-' }}
            </div>

            <div class="signature-pangkat">
                {{ $user->pangkat_golongan ?? '-' }}
            </div>

            <div class="signature-nip">
                NIP. {{ $user->nip ?? '-' }}
            </div>

        </div>

    </div>

</body>

</html>
