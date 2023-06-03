<?php

namespace Afaqy\Unit\Http\Reports\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UnitExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
        return $this->query->get();
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->code,
            $row->model,
            $row->plate_number,
            $row->vin_number,
            $row->unit_type,
            $row->waste_type,
            $row->contractor_name,
            $row->net_weight,
            $row->max_weight,
            $row->rfid,
            ($row->active) ? 'نشطة' : 'غير نشطة',
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'رمز المركبة',
            'موديل المركبة',
            'رقم اللوحة',
            'رقم الشاسيه',
            'نوع المركبة',
            'نوع النفايات',
            'إسم المقاول',
            'الوزن الصافي',
            'الحد الأقصي للوزن',
            'RFID',
            'حالة المركبة',
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
