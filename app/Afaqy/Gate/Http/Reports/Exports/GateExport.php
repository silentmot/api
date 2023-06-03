<?php

namespace Afaqy\Gate\Http\Reports\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class GateExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
        $this->query = $query;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return   $this->query->get();
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->name,
            $row->serial,
            ($row->direction == 'in') ? 'دخول' : 'خروج',
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'أسم البوابة',
            'رقم البوابة',
            'الاتجاه',
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
