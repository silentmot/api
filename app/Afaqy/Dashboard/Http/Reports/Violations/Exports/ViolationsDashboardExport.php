<?php

namespace Afaqy\Dashboard\Http\Reports\Violations\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Afaqy\Permission\Lookups\PermissionTypeLookup;

class ViolationsDashboardExport implements FromQuery, WithHeadings, WithMapping, WithEvents
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
        $waste_weight = ($row->permission_type == 'sorting')
            ? $row->exit_weight - $row->enterance_weight
            : $row->enterance_weight - $row->exit_weight;

        $lookup = PermissionTypeLookup::toArray();

        return [
            Carbon::fromTimestamp($row->date)->toDateTimeString(),
            $row->plate_number,
            $row->unit_code,
            $row->ar_violation_type,
            $row->contractor_name ?? 'N/A',
            ($row->contract_number) ? 'عقد ' . $row->contract_number : 'N/A',
            $row->permission_id ?? 'N/A',
            ($row->permission_type) ? $lookup[$row->permission_type] : 'N/A',
            ($row->enterance_weight) ? $row->enterance_weight / 1000 : 'N/A',
            ($row->exit_weight) ? $row->exit_weight / 1000 : 'N/A',
            $waste_weight / 1000,
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'التاريخ',
            'رقم اللوحة',
            'رمز المركبة',
            'نوع المخالفة',
            'المقاول',
            'رقم العقد',
            'رقم التصريح',
            'نوع التصريح',
            'وزن الدخول',
            'وزن الخروج',
            'وزن النفاية',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }
}
