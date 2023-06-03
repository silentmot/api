<?php

namespace Afaqy\Contractor\Http\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Contractor\Models\Contractor;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Contractor\Http\Transformers\ContractorTransformer;

class ContractorListReport extends Report
{
    use Generator;

    /**
     * @var \Illuminate\Http\Request
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
        $options['include'] = ['contact', 'unitsCount'];

        return $this->generateViewList(
            $this->query(),
            new ContractorTransformer(),
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = Contractor::withDefaultContact();

        $query->select([
            'contractors.id as contractor_id',
            'contractors.name_en',
            'contractors.name_ar',
            'contractors.employees',
            'contacts.id as contact_id',
            'contacts.name',
            'contacts.email',
            DB::raw("(SELECT phone FROM phones WHERE phones.contact_id = contacts.id  ORDER BY created_at DESC LIMIT 1) as phone"),
            DB::raw('(select count(units.contractor_id) from units where contractors.id = units.contractor_id
            and units.deleted_at IS Null )as units_count'),

        ])->sortBy($this->request);

        return $query;
    }
}
