<?php

namespace Afaqy\Dashboard\Http\Reports\PerHour\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PerHourDashboardExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $query;

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function __construct(Builder $query)
    {
        $this->query   = $query;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->hour . ':00',
            $row->date,
            $row->units_count,
            $row->total_weight / 1000,
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'الساعة',
            'التاريخ',
            'عدد المركبات',
            'وزن النفايات بالطن',
        ];
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
