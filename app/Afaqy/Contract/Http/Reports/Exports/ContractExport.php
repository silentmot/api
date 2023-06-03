<?php

namespace Afaqy\Contract\Http\Reports\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContractExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
            $row->contract_number ? $row->contract_number . " عقد" :'N/A',
            $row->start_at,
            $row->end_at,
            ($row->status) ? 'صالح' : 'ماغي',
            $row->district_name,
            $row->neighborhood_name,
            $row->units_codes,
            $row->contractor_name_ar,
            $row->contractor_name_en,
            $row->contact_name,
            $row->contact_title,
            $row->contact_email,
            $row->contact_phone,
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'رقم العقد',
            'تاريخ البدء',
            'تاريخ الانتهاء',
            'نوع العقد',
            'إسم المنطقة',
            'إسم الحي',
            'رموز السيارات',
            'إسم المقاول بالعربية',
            'إسم المقاول بالإنجليزية',
            'إسم مسئول الاتصال',
            'صفة مسئول الاتصال',
            'البريد الإلكتروني لمسئول الاتصال',
            'هاتف مسئول الاتصال',
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
