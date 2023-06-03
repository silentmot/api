<?php

namespace Afaqy\Dashboard\Http\Reports\Units\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Afaqy\Permission\Lookups\PermissionTypeLookup;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;

class UnitsDashboardExport implements FromQuery, WithHeadings, WithMapping, WithEvents, WithCustomChunkSize
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
        $lookup = PermissionTypeLookup::toArray();

        $start = Carbon::fromTimestamp($row->start_time)->toDateTimeString();
        $end   = Carbon::fromTimestamp($row->end_time)->toDateTimeString();

        return [
            $row->plate_number,
            $row->unit_code ?? 'N/A',
            $row->contractor_name ?? 'N/A',
            $row->contract_number ? 'عقد ' . $row->contract_number : 'N/A',
            $row->permission_id ?? 'N/A',
            $row->permission_type ? $lookup[$row->permission_type] : 'N/A',
            $row->unit_type ?? 'N/A',
            $row->waste_type,
            $row->net_weight ? $row->net_weight / 1000 : 'N/A',
            $row->max_weight ? $row->max_weight / 1000 : 'N/A',
            $row->enterance_weight / 1000,
            $row->exit_weight / 1000,
            $row->waste_weight / 1000,
            $start,
            $end,
            Carbon::parse($start)->diff($end)->format('%H:%I:%S'),
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'رقم اللوحة',
            'رمز المركبة',
            'المقاول',
            'رقم العقد',
            'رقم التصريح',
            'نوع التصريح',
            'نوع المركبة',
            'نوع النفاية',
            'الوزن الصافي',
            'أقصي وزن',
            'وزن الدخول',
            'وزن الخروج',
            'وزن النفاية',
            'وقت الدخول',
            'وقت الخروج',
            'مدة الرحلة',
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
