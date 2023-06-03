<?php

namespace Afaqy\Contract\Http\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Contract\Models\Contract;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Contract\Http\Transformers\ContractTransformer;

class ContractListReport extends Report
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
        $options['include'] = [
            'districtsCount',
            'unitsCount',
            'contractor',
            'contact',
        ];

        return $this->generateViewList(
            $this->query(),
            new ContractTransformer,
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = Contract::withContractInformation();

        $query->select([
            'contracts.id',
            'contracts.start_at',
            'contracts.end_at',
            'contracts.contract_number',
            DB::raw('COUNT(DISTINCT district_id) AS districts_count'),
            DB::raw('COUNT(DISTINCT units.id) + COUNT(DISTINCT station_unit.id) AS units_count'),
            'contractors.name_ar AS contractor_name_ar',
            'contractors.name_en AS contractor_name_en',
            'contacts.name AS contact_name',
            'contacts.email AS contact_email',
            'phones.phone AS contact_phone',
        ])
            ->limitOnePhoneNumber()
            ->groupBy([
                'contracts.id',
                'contracts.start_at',
                'contracts.end_at',
                'contracts.contract_number',
                'contractors.name_ar',
                'contractors.name_en',
                'contacts.name',
                'contacts.email',
                'phones.phone',
            ])
            ->sortBy($this->request);

        return $query;
    }
}
