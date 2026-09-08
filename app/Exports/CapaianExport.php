<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CapaianExport implements FromCollection, WithEvents, WithStyles
{
    protected int $tahunId;

    protected $user;


    /**
     * =========================================================
     * CONSTRUCTOR
     * =========================================================
     */
    public function __construct(int $tahunId)
    {
        $this->tahunId = $tahunId;

        $this->user = auth()->user();
    }


    /**
     * =========================================================
     * AMBIL DATA LAPORAN
     * =========================================================
     */
    public function collection()
    {
        $user = $this->user;


        $query = DB::table('indikators')


            /*
            |--------------------------------------------------------------------------
            | PILAR
            |--------------------------------------------------------------------------
            */
            ->join(
                'pilars',
                'pilars.id',
                '=',
                'indikators.pilar_id'
            )


            /*
            |--------------------------------------------------------------------------
            | TARGET
            |--------------------------------------------------------------------------
            */
            ->leftJoin('targets', function ($join) {

                $join->on(
                    'targets.indikator_id',
                    '=',
                    'indikators.id'
                )
                ->where(
                    'targets.tahun_id',
                    '=',
                    $this->tahunId
                );

            })


            /*
            |--------------------------------------------------------------------------
            | REALISASI
            |--------------------------------------------------------------------------
            */
            ->leftJoin('realisasis', function ($join) {

                $join->on(
                    'realisasis.indikator_id',
                    '=',
                    'indikators.id'
                )
                ->where(
                    'realisasis.tahun_id',
                    '=',
                    $this->tahunId
                );

            })


            /*
            |--------------------------------------------------------------------------
            | INSTANSI
            |--------------------------------------------------------------------------
            */
            ->leftJoin(
                'instansis',
                'instansis.id',
                '=',
                'indikators.instansi_id'
            )


            /*
            |--------------------------------------------------------------------------
            | DATA PENDUKUNG
            |--------------------------------------------------------------------------
            */
            ->leftJoin('data_pendukungs', function ($join) {

                $join->on(
                    'data_pendukungs.realisasi_id',
                    '=',
                    'realisasis.id'
                );

            })


            /*
            |--------------------------------------------------------------------------
            | SELECT DATA
            |--------------------------------------------------------------------------
            */
            ->select([

                // INDIKATOR
                'indikators.id',
                'indikators.pilar_id',
                'indikators.nama_indikator',
                'indikators.instansi_pendukung',
                'indikators.sumber_data',
                'indikators.urutan',

                // PILAR
                'pilars.nama as nama_pilar',
                'pilars.urutan as pilar_urutan',

                // INSTANSI
                'instansis.nama as nama_instansi',

                // TARGET
                'targets.nilai_target',

                // REALISASI
                'realisasis.nilai_realisasi',
                'realisasis.status_pencapaian',
                'realisasis.rencana_aksi',
                'realisasis.hambatan',
                'realisasis.evaluasi',

                // DATA PENDUKUNG
                'data_pendukungs.file as file_pendukung',

            ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER ADMIN
        |--------------------------------------------------------------------------
        |
        | SUPERADMIN
        |   -> melihat semua indikator
        |
        | ADMIN
        |   -> hanya melihat indikator instansinya sendiri
        |
        */

        if ($user->role !== 'superadmin') {

            $query->where(
                'indikators.instansi_id',
                $user->instansi_id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | URUTKAN
        |--------------------------------------------------------------------------
        */

        return $query
            ->orderBy('pilars.urutan')
            ->orderBy('indikators.urutan')
            ->get();
    }


    /**
     * =========================================================
     * STYLES
     * =========================================================
     */
    public function styles(Worksheet $sheet)
    {
        return [];
    }


    /**
     * =========================================================
     * EVENT EXCEL
     * =========================================================
     */
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();


                /*
                |--------------------------------------------------------------------------
                | DATA
                |--------------------------------------------------------------------------
                */

                $data = $this->collection();


                /*
                |--------------------------------------------------------------------------
                | HAPUS DATA DEFAULT
                |--------------------------------------------------------------------------
                */

                $highestRow = $sheet->getHighestRow();

                if ($highestRow > 0) {

                    $sheet->removeRow(
                        1,
                        $highestRow
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | JUDUL
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A1:L1');

                $sheet->setCellValue(
                    'A1',
                    'LAPORAN RENCANA AKSI PETA JALAN PEMBANGUNAN KEPENDUDUKAN'
                );

                $sheet
                    ->getStyle('A1:L1')
                    ->applyFromArray([

                        'font' => [
                            'bold' => true,
                            'size' => 16,
                        ],

                        'alignment' => [

                            'horizontal' =>
                                Alignment::HORIZONTAL_CENTER,

                            'vertical' =>
                                Alignment::VERTICAL_CENTER,

                        ],

                    ]);

                $sheet
                    ->getRowDimension(1)
                    ->setRowHeight(30);


                /*
                |--------------------------------------------------------------------------
                | INFORMASI LAPORAN
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A2:L2');

                $sheet->setCellValue(
                    'A2',
                    'Provinsi : KALIMANTAN TENGAH'
                );


                $sheet->mergeCells('A3:L3');

                $sheet->setCellValue(
                    'A3',
                    'Kabupaten/Kota : KAB. MURUNG RAYA'
                );


                $tahun = DB::table('tahuns')
                    ->where(
                        'id',
                        $this->tahunId
                    )
                    ->value('tahun');


                $sheet->mergeCells('A4:L4');

                $sheet->setCellValue(
                    'A4',
                    'Tahun : ' . $tahun
                );


                $sheet
                    ->getStyle('A2:L4')
                    ->applyFromArray([

                        'font' => [
                            'size' => 10,
                        ],

                        'alignment' => [

                            'horizontal' =>
                                Alignment::HORIZONTAL_LEFT,

                            'vertical' =>
                                Alignment::VERTICAL_CENTER,

                        ],

                    ]);


                /*
                |--------------------------------------------------------------------------
                | HEADER UTAMA
                |--------------------------------------------------------------------------
                */

                $headerRow1 = 6;

                $headerRow2 = 7;


                /*
                |--------------------------------------------------------------------------
                | BARIS HEADER 1
                |--------------------------------------------------------------------------
                */

                $sheet->setCellValue(
                    'A' . $headerRow1,
                    '#'
                );


                $sheet->setCellValue(
                    'B' . $headerRow1,
                    'INDIKATOR'
                );


                $sheet->setCellValue(
                    'C' . $headerRow1,
                    'DINAS'
                );


                $sheet->setCellValue(
                    'E' . $headerRow1,
                    'PETA JALAN PEMBANGUNAN KEPENDUDUKAN'
                );


                $sheet->setCellValue(
                    'I' . $headerRow1,
                    'RENCANA AKSI'
                );


                $sheet->setCellValue(
                    'L' . $headerRow1,
                    'EVALUASI RENCANA AKSI'
                );


                /*
                |--------------------------------------------------------------------------
                | MERGE HEADER
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A6:A7');

                $sheet->mergeCells('B6:B7');

                $sheet->mergeCells('C6:D6');

                $sheet->mergeCells('E6:H6');

                $sheet->mergeCells('I6:K6');

                $sheet->mergeCells('L6:L7');


                /*
                |--------------------------------------------------------------------------
                | BARIS HEADER 2
                |--------------------------------------------------------------------------
                */

                $sheet->setCellValue(
                    'C7',
                    'PENGAMPU'
                );


                $sheet->setCellValue(
                    'D7',
                    'TERKAIT'
                );


                $sheet->setCellValue(
                    'E7',
                    'TARGET'
                );


                $sheet->setCellValue(
                    'F7',
                    'REALISASI'
                );


                $sheet->setCellValue(
                    'G7',
                    'CAPAIAN (%)'
                );


                $sheet->setCellValue(
                    'H7',
                    'SUMBER DATA'
                );


                $sheet->setCellValue(
                    'I7',
                    'NARASI'
                );


                $sheet->setCellValue(
                    'J7',
                    'HAMBATAN'
                );


                $sheet->setCellValue(
                    'K7',
                    'BUKTI DUKUNG'
                );


                /*
                |--------------------------------------------------------------------------
                | STYLE HEADER
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A6:L7')
                    ->applyFromArray([

                        'font' => [
                            'bold' => true,
                            'size' => 10,
                        ],

                        'alignment' => [

                            'horizontal' =>
                                Alignment::HORIZONTAL_CENTER,

                            'vertical' =>
                                Alignment::VERTICAL_CENTER,

                            'wrapText' => true,

                        ],

                        'fill' => [

                            'fillType' =>
                                Fill::FILL_SOLID,

                            'color' => [
                                'rgb' => 'EEEEEE',
                            ],

                        ],

                        'borders' => [

                            'allBorders' => [

                                'borderStyle' =>
                                    Border::BORDER_THIN,

                                'color' => [
                                    'rgb' => '000000',
                                ],

                            ],

                        ],

                    ]);


                $sheet
                    ->getRowDimension(6)
                    ->setRowHeight(30);


                $sheet
                    ->getRowDimension(7)
                    ->setRowHeight(30);


                /*
                |--------------------------------------------------------------------------
                | DATA PER PILAR
                |--------------------------------------------------------------------------
                */

                $row = 8;

                $nomor = 1;

                $grouped = $data->groupBy('pilar_id');


                foreach (
                    $grouped as $pilarId => $indikators
                ) {

                    $indikatorPertama =
                        $indikators->first();


                    /*
                    |--------------------------------------------------------------------------
                    | SASARAN
                    |--------------------------------------------------------------------------
                    */

                    $sheet->mergeCells(
                        'A' . $row . ':L' . $row
                    );


                    $sheet->setCellValue(
                        'A' . $row,
                        'Sasaran ' .
                        ($indikatorPertama->pilar_urutan ?? '')
                    );


                    $sheet
                        ->getStyle(
                            'A' . $row . ':L' . $row
                        )
                        ->applyFromArray([

                            'font' => [

                                'bold' => true,

                                'size' => 11,

                            ],

                            'fill' => [

                                'fillType' =>
                                    Fill::FILL_SOLID,

                                'color' => [
                                    'rgb' => 'EEEEEE',
                                ],

                            ],

                            'alignment' => [

                                'horizontal' =>
                                    Alignment::HORIZONTAL_LEFT,

                                'vertical' =>
                                    Alignment::VERTICAL_CENTER,

                                'wrapText' => true,

                            ],

                            'borders' => [

                                'allBorders' => [

                                    'borderStyle' =>
                                        Border::BORDER_THIN,

                                    'color' => [
                                        'rgb' => '000000',
                                    ],

                                ],

                            ],

                        ]);


                    $row++;


                    /*
                    |--------------------------------------------------------------------------
                    | NAMA PILAR
                    |--------------------------------------------------------------------------
                    */

                    $sheet->mergeCells(
                        'A' . $row . ':L' . $row
                    );


                    $sheet->setCellValue(
                        'A' . $row,
                        $indikatorPertama->nama_pilar
                    );


                    $sheet
                        ->getStyle(
                            'A' . $row . ':L' . $row
                        )
                        ->applyFromArray([

                            'font' => [

                                'bold' => true,

                                'italic' => true,

                                'size' => 11,

                            ],

                            'fill' => [

                                'fillType' =>
                                    Fill::FILL_SOLID,

                                'color' => [
                                    'rgb' => 'EEEEEE',
                                ],

                            ],

                            'alignment' => [

                                'horizontal' =>
                                    Alignment::HORIZONTAL_LEFT,

                                'vertical' =>
                                    Alignment::VERTICAL_CENTER,

                                'wrapText' => true,

                            ],

                            'borders' => [

                                'allBorders' => [

                                    'borderStyle' =>
                                        Border::BORDER_THIN,

                                    'color' => [
                                        'rgb' => '000000',
                                    ],

                                ],

                            ],

                        ]);


                    $row++;


                    /*
                    |--------------------------------------------------------------------------
                    | DATA INDIKATOR
                    |--------------------------------------------------------------------------
                    */

                    foreach (
                        $indikators as $indikator
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | NOMOR
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'A' . $row,
                            $nomor++
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | INDIKATOR
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'B' . $row,
                            $indikator->nama_indikator
                                ?? '-'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | DINAS PENGAMPU
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'C' . $row,
                            $indikator->nama_instansi
                                ?? '-'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | DINAS TERKAIT
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'D' . $row,
                            $indikator->instansi_pendukung
                                ?? '-'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | TARGET
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'E' . $row,
                            $indikator->nilai_target
                                ?? '-'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | REALISASI
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'F' . $row,
                            $indikator->nilai_realisasi
                                ?? '-'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | CAPAIAN
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'G' . $row,
                            $indikator->status_pencapaian
                                ?? '-'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | SUMBER DATA
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'H' . $row,
                            $indikator->sumber_data
                                ?? '-'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | NARASI
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'I' . $row,
                            $indikator->rencana_aksi
                                ?? '-'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | HAMBATAN
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'J' . $row,
                            $indikator->hambatan
                                ?? '-'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | BUKTI DUKUNG
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'K' . $row,
                            $indikator->file_pendukung
                                ?? '-'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | EVALUASI
                        |--------------------------------------------------------------------------
                        */

                        $sheet->setCellValue(
                            'L' . $row,
                            $indikator->evaluasi
                                ?? '-'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | BORDER + WRAP
                        |--------------------------------------------------------------------------
                        */

                        $sheet
                            ->getStyle(
                                'A' . $row .
                                ':L' . $row
                            )
                            ->applyFromArray([

                                'alignment' => [

                                    'vertical' =>
                                        Alignment::VERTICAL_CENTER,

                                    'wrapText' => true,

                                ],

                                'borders' => [

                                    'allBorders' => [

                                        'borderStyle' =>
                                            Border::BORDER_THIN,

                                        'color' => [
                                            'rgb' => '000000',
                                        ],

                                    ],

                                ],

                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | CENTER NOMOR
                        |--------------------------------------------------------------------------
                        */

                        $sheet
                            ->getStyle(
                                'A' . $row
                            )
                            ->getAlignment()
                            ->setHorizontal(
                                Alignment::HORIZONTAL_CENTER
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | CENTER TARGET - REALISASI - CAPAIAN
                        |--------------------------------------------------------------------------
                        */

                        $sheet
                            ->getStyle(
                                'E' . $row .
                                ':G' . $row
                            )
                            ->getAlignment()
                            ->setHorizontal(
                                Alignment::HORIZONTAL_CENTER
                            );


                        $row++;
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | TANDA TANGAN
                |--------------------------------------------------------------------------
                */

                $row += 2;

                $signatureStart = $row;


                /*
                |--------------------------------------------------------------------------
                | DATA USER
                |--------------------------------------------------------------------------
                */

                $user = $this->user;


                /*
                |--------------------------------------------------------------------------
                | NAMA INSTANSI
                |--------------------------------------------------------------------------
                */

                $namaInstansi = trim(
                    $user?->instansi_id
                        ? DB::table('instansis')
                            ->where(
                                'id',
                                $user->instansi_id
                            )
                            ->value('nama')
                        : 'PEMERINTAH'
                );


                /*
                |--------------------------------------------------------------------------
                | NORMALISASI SPASI
                |--------------------------------------------------------------------------
                */

                $namaInstansi = preg_replace(
                    '/\s+/',
                    ' ',
                    $namaInstansi
                );


                /*
                |--------------------------------------------------------------------------
                | HILANGKAN KABUPATEN MURUNG RAYA
                |--------------------------------------------------------------------------
                */

                $namaInstansiTampil = preg_replace(
                    '/\s+Kabupaten\s+Murung\s+Raya\s*$/i',
                    '',
                    $namaInstansi
                );

                $namaInstansiTampil = trim(
                    $namaInstansiTampil
                );


                /*
                |--------------------------------------------------------------------------
                | DETEKSI SEKRETARIAT DAERAH
                |--------------------------------------------------------------------------
                */

                $namaInstansiLower = strtolower(
                    $namaInstansi
                );


                $isSekda =
                    str_contains(
                        $namaInstansiLower,
                        'sekretariat daerah'
                    )
                    ||
                    str_contains(
                        $namaInstansiLower,
                        'setda'
                    )
                    ||
                    str_contains(
                        $namaInstansiLower,
                        'sekda'
                    );


                /*
                |--------------------------------------------------------------------------
                | PEMECAHAN NAMA INSTANSI PANJANG
                |--------------------------------------------------------------------------
                */

                if (
                    mb_strlen($namaInstansiTampil) > 55
                    &&
                    preg_match(
                        '/\s+serta\s+/i',
                        $namaInstansiTampil
                    )
                ) {

                    $namaInstansiBaris = preg_replace(
                        '/\s+serta\s+/i',
                        "\nserta ",
                        $namaInstansiTampil,
                        1
                    );

                } elseif (
                    mb_strlen($namaInstansiTampil) > 60
                ) {

                    $namaInstansiBaris = wordwrap(
                        $namaInstansiTampil,
                        55,
                        "\n",
                        false
                    );

                } else {

                    $namaInstansiBaris =
                        $namaInstansiTampil;
                }


                /*
                |--------------------------------------------------------------------------
                | DATA PIMPINAN
                |--------------------------------------------------------------------------
                */

                $namaPimpinan =
                    $user?->nama_pimpinan ?: '-';


                $pangkatGolongan =
                    $user?->pangkat_golongan ?: '-';


                $nip =
                    $user?->nip ?: '-';


                /*
                |--------------------------------------------------------------------------
                | TANGGAL
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells(
                    'I' .
                    $signatureStart .
                    ':L' .
                    $signatureStart
                );


                $sheet->setCellValue(
                    'I' . $signatureStart,
                    'Puruk Cahu, ' .
                    now()->translatedFormat('d F Y')
                );


                /*
                |--------------------------------------------------------------------------
                | MENGETAHUI
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells(
                    'I' .
                    ($signatureStart + 1) .
                    ':L' .
                    ($signatureStart + 1)
                );


                $sheet->setCellValue(
                    'I' . ($signatureStart + 1),
                    'Mengetahui,'
                );


                /*
                |--------------------------------------------------------------------------
                | JABATAN / INSTANSI
                |--------------------------------------------------------------------------
                */

                $jabatanRow =
                    $signatureStart + 2;


                $sheet->mergeCells(
                    'I' .
                    $jabatanRow .
                    ':L' .
                    $jabatanRow
                );


                /*
                |--------------------------------------------------------------------------
                | TEKS JABATAN
                |--------------------------------------------------------------------------
                */

                if ($isSekda) {

                    $teksJabatan =
                        "Sekretaris Daerah\n" .
                        "Kabupaten Murung Raya";

                } else {

                    $teksJabatan =
                        "Kepala\n" .
                        $namaInstansiBaris .
                        "\nKabupaten Murung Raya";
                }


                $sheet->setCellValue(
                    'I' . $jabatanRow,
                    $teksJabatan
                );


                /*
                |--------------------------------------------------------------------------
                | AREA KOSONG TANDA TANGAN
                |--------------------------------------------------------------------------
                */

                $signatureSpaceStart =
                    $signatureStart + 3;


                $signatureSpaceEnd =
                    $signatureStart + 6;


                $sheet->mergeCells(
                    'I' .
                    $signatureSpaceStart .
                    ':L' .
                    $signatureSpaceEnd
                );


                /*
                |--------------------------------------------------------------------------
                | GARIS TANDA TANGAN
                |--------------------------------------------------------------------------
                */

                $lineRow =
                    $signatureStart + 7;


                $sheet->mergeCells(
                    'I' .
                    $lineRow .
                    ':L' .
                    $lineRow
                );


                $sheet
                    ->getStyle(
                        'I' .
                        $lineRow .
                        ':L' .
                        $lineRow
                    )
                    ->getBorders()
                    ->getBottom()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );


                /*
                |--------------------------------------------------------------------------
                | NAMA PIMPINAN
                |--------------------------------------------------------------------------
                */

                $namaRow =
                    $signatureStart + 8;


                $sheet->mergeCells(
                    'I' .
                    $namaRow .
                    ':L' .
                    $namaRow
                );


                $sheet->setCellValue(
                    'I' . $namaRow,
                    $namaPimpinan
                );


                /*
                |--------------------------------------------------------------------------
                | PANGKAT / GOLONGAN
                |--------------------------------------------------------------------------
                */

                $pangkatRow =
                    $signatureStart + 9;


                $sheet->mergeCells(
                    'I' .
                    $pangkatRow .
                    ':L' .
                    $pangkatRow
                );


                $sheet->setCellValue(
                    'I' . $pangkatRow,
                    $pangkatGolongan
                );


                /*
                |--------------------------------------------------------------------------
                | NIP
                |--------------------------------------------------------------------------
                */

                $nipRow =
                    $signatureStart + 10;


                $sheet->mergeCells(
                    'I' .
                    $nipRow .
                    ':L' .
                    $nipRow
                );


                $sheet->setCellValue(
                    'I' . $nipRow,
                    'NIP. ' . $nip
                );


                /*
                |--------------------------------------------------------------------------
                | STYLE TANDA TANGAN
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle(
                        'I' .
                        $signatureStart .
                        ':L' .
                        $nipRow
                    )
                    ->applyFromArray([

                        'alignment' => [

                            'horizontal' =>
                                Alignment::HORIZONTAL_CENTER,

                            'vertical' =>
                                Alignment::VERTICAL_TOP,

                            'wrapText' => true,

                        ],

                    ]);


                /*
                |--------------------------------------------------------------------------
                | BOLD JABATAN
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle(
                        'I' .
                        $jabatanRow .
                        ':L' .
                        $jabatanRow
                    )
                    ->getFont()
                    ->setBold(true);


                /*
                |--------------------------------------------------------------------------
                | BOLD NAMA PIMPINAN
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle(
                        'I' .
                        $namaRow .
                        ':L' .
                        $namaRow
                    )
                    ->getFont()
                    ->setBold(true);


                /*
                |--------------------------------------------------------------------------
                | TINGGI BARIS TANDA TANGAN
                |--------------------------------------------------------------------------
                */

                // Tanggal
                $sheet
                    ->getRowDimension(
                        $signatureStart
                    )
                    ->setRowHeight(22);


                // Mengetahui
                $sheet
                    ->getRowDimension(
                        $signatureStart + 1
                    )
                    ->setRowHeight(22);


                // Jabatan + instansi
                $jumlahBarisJabatan =
                    substr_count(
                        $teksJabatan,
                        "\n"
                    ) + 1;


                $sheet
                    ->getRowDimension(
                        $jabatanRow
                    )
                    ->setRowHeight(
                        max(
                            35,
                            $jumlahBarisJabatan * 18
                        )
                    );


                // Area kosong tanda tangan
                for (
                    $i = 3;
                    $i <= 6;
                    $i++
                ) {

                    $sheet
                        ->getRowDimension(
                            $signatureStart + $i
                        )
                        ->setRowHeight(20);

                }


                // Garis
                $sheet
                    ->getRowDimension(
                        $lineRow
                    )
                    ->setRowHeight(8);


                // Nama
                $sheet
                    ->getRowDimension(
                        $namaRow
                    )
                    ->setRowHeight(20);


                // Pangkat
                $sheet
                    ->getRowDimension(
                        $pangkatRow
                    )
                    ->setRowHeight(20);


                // NIP
                $sheet
                    ->getRowDimension(
                        $nipRow
                    )
                    ->setRowHeight(20);


                /*
                |--------------------------------------------------------------------------
                | LEBAR KOLOM
                |--------------------------------------------------------------------------
                */

                $widths = [

                    'A' => 6,

                    'B' => 30,

                    'C' => 24,

                    'D' => 32,

                    'E' => 12,

                    'F' => 12,

                    'G' => 14,

                    'H' => 28,

                    'I' => 45,

                    'J' => 35,

                    'K' => 35,

                    'L' => 35,

                ];


                foreach (
                    $widths as $column => $width
                ) {

                    $sheet
                        ->getColumnDimension(
                            $column
                        )
                        ->setWidth($width);

                }


                /*
                |--------------------------------------------------------------------------
                | WRAP DATA
                |--------------------------------------------------------------------------
                */

                $lastDataRow =
                    $row - 1;


                if (
                    $lastDataRow >= 8
                ) {

                    $sheet
                        ->getStyle(
                            'A8:L' .
                            $lastDataRow
                        )
                        ->getAlignment()
                        ->setWrapText(true);

                }


                /*
                |--------------------------------------------------------------------------
                | BORDER SELURUH TABEL
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle(
                        'A6:L' .
                        $lastDataRow
                    )
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );


                /*
                |--------------------------------------------------------------------------
                | PAGE SETUP
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getPageSetup()
                    ->setOrientation(
                        PageSetup::ORIENTATION_LANDSCAPE
                    );


                $sheet
                    ->getPageSetup()
                    ->setPaperSize(
                        PageSetup::PAPERSIZE_A4
                    );


                $sheet
                    ->getPageSetup()
                    ->setFitToWidth(1);


                $sheet
                    ->getPageSetup()
                    ->setFitToHeight(0);


                /*
                |--------------------------------------------------------------------------
                | MARGIN
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getPageMargins()
                    ->setTop(0.3)
                    ->setBottom(0.3)
                    ->setLeft(0.3)
                    ->setRight(0.3);


                /*
                |--------------------------------------------------------------------------
                | HILANGKAN GRIDLINE
                |--------------------------------------------------------------------------
                */

                $sheet->setShowGridlines(false);


                /*
                |--------------------------------------------------------------------------
                | PRINT AREA
                |--------------------------------------------------------------------------
                |
                | SEKARANG SAMPAI NIP.
                |
                */

                $sheet
                    ->getPageSetup()
                    ->setPrintArea(
                        'A1:L' . $nipRow
                    );


                /*
                |--------------------------------------------------------------------------
                | FREEZE HEADER
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane('A8');

            },

        ];
    }
}