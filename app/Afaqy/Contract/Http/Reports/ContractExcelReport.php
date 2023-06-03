<?php

namespace Afaqy\Contract\Http\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Contract\Models\Contract;
use Afaqy\Core\Http\Reports\Report;
use Maatwebsite\Excel\Facades\Excel;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Contract\Http\Reports\Exports\ContractExport;

class ContractExcelReport extends Report
{
    use Generator;

    /**
     * @var \Illuminate\Http\Request $request
     */
    private $request;

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return Excel::download(new ContractExport($this->query()), 'contracts.xlsx');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = Contract::withContractDetailedInformation();

        $query->select([
            'contracts.id',
            'contracts.contract_number',
            'contracts.start_at',
            'contracts.end_at',
            'contracts.status',
            'districts.name AS district_name',
            'neighborhoods.name AS neighborhood_name',
            DB::raw('GROUP_CONCAT(units.code SEPARATOR ",") AS units_codes'),
            'contractors.name_ar AS contractor_name_ar',
            'contractors.name_en AS contractor_name_en',
            'contacts.name AS contact_name',
            'contacts.title AS contact_title',
            'contacts.email AS contact_email',
            'phones.phone AS contact_phone',
        ])
            ->limitOnePhoneNumber()
            ->groupBy([
                'contracts.id',
                'contracts.start_at',
                'contracts.end_at',
                'contracts.status',
                'districts.name',
                'neighborhoods.name',
                'contractors.name_ar',
                'contractors.name_en',
                'contacts.name',
                'contacts.title',
                'contacts.email',
                'phones.phone',
            ])
            ->sortBy($this->request)
            ->filter($this->request->all());

        return $query;
    }
}
