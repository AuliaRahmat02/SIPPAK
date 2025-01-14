<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;


class BaseExport implements FromCollection, WithHeadings, WithStyles,WithEvents
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    protected $collection;
    protected $headings;

    protected $judul;

    public function __construct(Collection $collection, array $headings, $judul)
    {
        $this->collection = $collection;
        $this->headings = $headings;
        $this->judul = $judul;
    }

    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return $this->headings;
    }
    public function styles(Worksheet $sheet)
    {
        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        foreach ($sheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $cell->getStyle()->getAlignment()->setWrapText(true);
            }
        }
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge cells for the title
                $sheet->mergeCells('A1:J1');

                // Set the title
                $sheet->setCellValue('A1', $this->judul);

                // Apply style to the title
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Adjust the height of the row to fit the title
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Insert a blank row after the title
                $sheet->insertNewRowBefore(2, 1);

                $headingRow = 2;

                // Add the headings in the next row
                $headings = $this->headings();
                $columnIndex = 0;
                foreach ($headings as $heading) {
                    $sheet->setCellValueByColumnAndRow(++$columnIndex, 2, $heading);
                }

                // Apply styling to the headings
                $headingRange = 'A2:' . $sheet->getHighestColumn() . '2';
                $sheet->getStyle($headingRange)->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle($headingRange)->getAlignment()->setHorizontal('center');

                // Apply consistent font size to all data rows
                $dataRange = 'A3:' . $sheet->getHighestColumn() . $sheet->getHighestRow();
                $sheet->getStyle($dataRange)->getFont()->setSize(12);

                $sheet->getRowDimension(1)->setRowHeight(60);
            },
        ];
    }

}
