<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PeminjamanExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithEvents,
    ShouldAutoSize
{
    protected $search;
    protected int $totalJumlah = 0;
    protected array $totalPerJenis = [];

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    /**
     * Ambil data & hitung total
     */
    public function collection()
    {
        $data = Peminjaman::with(['peminjam', 'aset'])
            ->when($this->search, function ($query) {

                // 🔥 JIKA SEARCH FORMAT BULAN (YYYY-MM)
                if (preg_match('/^\d{4}-\d{2}$/', $this->search)) {
                    [$year, $month] = explode('-', $this->search);

                    $query->whereYear('tanggal_pinjam', $year)
                        ->whereMonth('tanggal_pinjam', $month);

                    return;
                }

                $query->where('status', 'like', '%' . $this->search . '%')
                    ->orWhereHas('peminjam', fn ($q) =>
                        $q->where('nama_peminjam', 'like', '%' . $this->search . '%')
                    )
                    ->orWhereHas('aset', fn ($q) =>
                        $q->where('identitas_barang', 'like', '%' . $this->search . '%')
                    );
            })
            ->get();

        // Total global
        $this->totalJumlah = $data->sum('jumlah');

        // Total per jenis barang
        $this->totalPerJenis = $data
            ->groupBy(fn ($item) => $item->aset->identitas_barang ?? 'Tidak Diketahui')
            ->map(fn ($group) => $group->sum('jumlah'))
            ->toArray();

        return $data;
    }

    /**
     * Mapping data
     */
    public function map($p): array
    {
        return [
            $p->peminjam->nama_peminjam ?? '-',
            $p->aset->identitas_barang ?? '-',
            $p->tanggal_pinjam
                ? Carbon::parse($p->tanggal_pinjam)->translatedFormat('d F Y')
                : '-',
            $p->tanggal_kembali
                ? Carbon::parse($p->tanggal_kembali)->translatedFormat('d F Y')
                : '-',
            $p->jumlah,
            ucfirst($p->status),
        ];
    }

    /**
     * Heading tabel
     */
    public function headings(): array
    {
        return [
            'Nama Peminjam',
            'Jenis Barang',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Jumlah',
            'Status',
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

                $judul = 'DATA PEMINJAMAN ASET';

                if ($this->search) {
                    if (strtolower($this->search) === 'dipinjam') {
                        $judul = 'DATA ASET YANG DIPINJAM';
                    } elseif (strtolower($this->search) === 'dikembalikan') {
                        $judul = 'DATA ASET YANG DIKEMBALIKAN';
                    }
                }

                $subjudul = 'Filter: ' . ($this->search ?? 'Semua Data')
                    . ' | Diekspor: ' . Carbon::now()->translatedFormat('d F Y');

                $event->sheet->setCellValue('A1', $judul);
                $event->sheet->mergeCells('A1:F1');

                $event->sheet->setCellValue('A2', $subjudul);
                $event->sheet->mergeCells('A2:F2');

                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true, 'size' => 10],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // Heading tabel di baris 3
                $event->sheet->insertNewRowBefore(3, 2);
            },

            // =============================
            // BORDER, TOTAL & FOOTER
            // =============================
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                // =============================
                // BORDER TABEL UTAMA
                // =============================
                $sheet->getStyle("A3:F{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Header bold
                $sheet->getStyle('A3:F3')->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                // =============================
                // TOTAL GLOBAL
                // =============================
                $totalRow = $lastRow + 1;

                $sheet->mergeCells("A{$totalRow}:D{$totalRow}");
                $sheet->setCellValue("A{$totalRow}", 'TOTAL JUMLAH DIPINJAM');
                $sheet->setCellValue("E{$totalRow}", $this->totalJumlah);

                $sheet->getStyle("A{$totalRow}:F{$totalRow}")->applyFromArray([
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

                $sheet->mergeCells("A{$row}:D{$row}");
                $sheet->setCellValue("A{$row}", 'TOTAL PEMINJAMAN PER JENIS BARANG');

                $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $row++;

                foreach ($this->totalPerJenis as $jenis => $total) {
                    $sheet->mergeCells("A{$row}:D{$row}");
                    $sheet->setCellValue("A{$row}", $jenis);
                    $sheet->setCellValue("E{$row}", $total);

                    $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                    $row++;
                }

                // =============================
                // FOOTER / TTD (TANPA BORDER)
                // =============================
                $row += 2;

                $sheet->mergeCells("D{$row}:F{$row}");
                $sheet->setCellValue("D{$row}", 'Mengetahui,');

                $row++;
                $sheet->mergeCells("D{$row}:F{$row}");
                $sheet->setCellValue("D{$row}", 'Kepala Sarana dan Prasarana');

                $row += 3;
                $sheet->mergeCells("D{$row}:F{$row}");
                $sheet->setCellValue("D{$row}", '( ____________________ )');

                $row++;
                $sheet->mergeCells("D{$row}:F{$row}");
                $sheet->setCellValue(
                    "D{$row}",
                    'Tanggal: ' . Carbon::now()->translatedFormat('d F Y')
                );
            },
        ];
    }
}
