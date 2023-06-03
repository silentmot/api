<?php

namespace Afaqy\User\Http\Reports\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $query;

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
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
     * @param  mixed   $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->full_name,
            $row->username,
            $row->role,
            $row->email,
            $row->phone,
            ($row->status) ? 'نشط' : 'غير نشط',
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'إسم المستخدم',
            'إسم الدخول',
            'الوظيفة',
            'البريد الالكترونى',
            'رقم الهاتف',
            'الحالة',
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
