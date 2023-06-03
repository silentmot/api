<?php

namespace Afaqy\Permission\Http\Reports\Individual;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Permission\Models\IndividualDamagedPermission;
use Afaqy\Permission\Http\Transformers\Individual\IndividualPermissionByNumberTransformer;

class IndividualPermissionByNumberReport extends Report
{
    use Generator;

    /**
     * @var int $number
     */
    private $number;

    /**
     * @param int $number
     * @return void
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        $options['include'] = 'units';

        return $this->generateJoinViewShow(
            $this->query(),
            new IndividualPermissionByNumberTransformer,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = IndividualDamagedPermission::withPermitUnit();

        $query->select([
            "individual_damaged_permissions.id as permission_id",
            "individual_damaged_permissions.demolition_serial",
            "individual_damaged_permissions.permission_number",
            "individual_damaged_permissions.permission_date",
            "individual_damaged_permissions.type",
            "individual_damaged_permissions.district_id",
            "individual_damaged_permissions.neighborhood_id",
            "individual_damaged_permissions.street",
            "individual_damaged_permissions.owner_name",
            "individual_damaged_permissions.owner_phone",
            "individual_damaged_permissions.national_id",
            "permit_units.id as unit_id",
            "permit_units.plate_number",
            'permit_units.qr_code',
            'permit_units.rfid',
        ])
            ->where("permission_number", $this->number)
            ->whereNull('permit_units.deleted_at');

        return $query;
    }
}
