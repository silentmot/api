<?php

namespace Afaqy\Dashboard\Http\Reports\Contractors\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContractorsDashboardExport implements FromArray, WithHeadings, WithEvents
{
    /**
     * @var array
     */
    private $headers;

    /**
     * @var array
     */
    private $data;

    /**
     * @param array $headers
     * @param array $data
     * @return void
     */
    public function __construct(array $headers, array $data)
    {
        $this->headers = $headers;
        $this->data    = $data;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }
}
