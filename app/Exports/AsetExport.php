<?php

namespace App\Exports;

use App\Models\Aset;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AsetExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithEvents,
    ShouldAutoSize
{
    protected int $rowNumber = 0;
    protected int $totalJumlah = 0;
    protected array $totalPerJenis = [];

    /**
     * Ambil data & hitung total
     */
    public function collection()
    {
        $data = Aset::all();

        // Total global
        $this->totalJumlah = $data->sum('jumlah');

        // Total per jenis barang
        $this->totalPerJenis = $data
            ->groupBy('jenis_barang')
            ->map(fn ($group) => $group->sum('jumlah'))
            ->toArray();

        return $data;
    }

    /**
     * Mapping data
     */
    public function map($a): array
    {
        return [
            ++$this->rowNumber,
            $a->jenis_barang,
            $a->kode_barang,
            $a->identitas_barang,
            $a->pengelola_barang,
            $a->tahun_perolehan,
            $a->nilai_perolehan,
            $a->nilai_saat_ini,
            $a->jumlah,
            $a->keterangan,
        ];
    }

    /**
     * Heading tabel
     */
    public function headings(): array
    {
        return [
            'No',
            'Jenis Barang',
            'Kode Barang',
            'Identitas Barang',
            'Pengelola Barang',
            'Tahun Perolehan',
            'Nilai Perolehan',
            'Nilai Saat Ini',
            'Jumlah',
            'Keterangan',
        ];
    }

    /**
     * Event Excel
     */
    public function registerEvents(): array
    {
        return [

            // =============================
            // JUDUL & SUBJUDUL
            // =============================
            BeforeSheet::class => function (BeforeSheet $event) {

                $judul = 'DATA ASET';
                $subjudul = 'Diekspor pada: ' . Carbon::now()->translatedFormat('d F Y');

                $event->sheet->setCellValue('A1', $judul);
                $event->sheet->mergeCells('A1:J1');

                $event->sheet->setCellValue('A2', $subjudul);
                $event->sheet->mergeCells('A2:J2');

                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true, 'size' => 10],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // Geser tabel → heading di baris 3
                $event->sheet->insertNewRowBefore(3, 2);
            },

            // =============================
            // BORDER, TOTAL & FOOTER
            // =============================
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                // Border tabel utama
                $sheet->getStyle("A3:J{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Header bold
                $sheet->getStyle('A3:J3')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                // =============================
                // TOTAL GLOBAL
                // =============================
                $totalRow = $lastRow + 1;

                // Merge seluruh kolom, tapi teks di kolom A, total di kolom I
                $sheet->mergeCells("A{$totalRow}:H{$totalRow}");
                $sheet->setCellValue("A{$totalRow}", 'TOTAL JUMLAH ASET');
                $sheet->setCellValue("I{$totalRow}", $this->totalJumlah);

                // Apply border ke seluruh range
                $sheet->getStyle("A{$totalRow}:J{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // =============================
                // TOTAL PER JENIS BARANG
                // =============================
                $row = $totalRow + 2;

                // Judul total per jenis
                $sheet->mergeCells("A{$row}:J{$row}");
                $sheet->setCellValue("A{$row}", 'TOTAL ASET PER JENIS BARANG');
                $sheet->getStyle("A{$row}:J{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $row++;

                foreach ($this->totalPerJenis as $jenis => $total) {
                    $sheet->mergeCells("A{$row}:H{$row}");
                    $sheet->setCellValue("A{$row}", $jenis);
                    $sheet->setCellValue("I{$row}", $total);

                    // Border full per baris
                    $sheet->getStyle("A{$row}:J{$row}")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                    $row++;
                }

                // =============================
                // FOOTER / TTD
                // =============================
                $row += 2;

                $sheet->mergeCells("G{$row}:J{$row}");
                $sheet->setCellValue("G{$row}", 'Mengetahui,');

                $row++;
                $sheet->mergeCells("G{$row}:J{$row}");
                $sheet->setCellValue("G{$row}", 'Kepala Sarana dan Prasarana');

                $row += 3;
                $sheet->mergeCells("G{$row}:J{$row}");
                $sheet->setCellValue("G{$row}", '( ____________________ )');

                $row++;
                $sheet->mergeCells("G{$row}:J{$row}");
                $sheet->setCellValue(
                    "G{$row}",
                    'Tanggal: ' . Carbon::now()->translatedFormat('d F Y')
                );
            },
        ];
    }
}
