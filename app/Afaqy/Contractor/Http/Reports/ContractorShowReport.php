<?php

namespace Afaqy\Contractor\Http\Reports;

use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Contractor\Models\Contractor;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Contractor\Http\Transformers\ContractorShowTransformer;

class ContractorShowReport extends Report
{
    use Generator;

    /**
     * @var int $id
     */
    private $id;

    /**
     * @param int $id
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateJoinViewShow(
            $this->query(),
            new ContractorShowTransformer,
            ['contacts']
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = Contractor::WithContactsPhones();

        $query->select([
            'contractors.id as contractor_id',
            'contractors.name_en',
            'contractors.name_ar',
            'contractors.employees',
            'contractors.avl_company',
            'contractors.commercial_number',
            'contractors.address',
            'contacts.id as contact_id',
            'contacts.name',
            'contacts.default_contact',
            'contacts.email',
            DB::raw('GROUP_CONCAT(phones.phone order by phones.id asc SEPARATOR ",") as phones'),
        ])
            ->where('contractors.id', $this->id)
            ->groupBy([
                'contractors.id',
                'contractors.name_en',
                'contractors.name_ar',
                'contractors.employees',
                'contractors.commercial_number',
                'contractors.avl_company',
                'contractors.address',
                'contacts.id',
                'contacts.name',
                'contacts.default_contact',
                'contacts.email',
            ]);

        return $query;
    }
}
