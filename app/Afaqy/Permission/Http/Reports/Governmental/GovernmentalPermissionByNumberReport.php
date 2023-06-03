<?php

namespace Afaqy\Permission\Http\Reports\Governmental;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Permission\Models\GovernmentalDamagedPermission;
use Afaqy\Permission\Http\Transformers\Governmental\GovernmentalPermissionByNumberTransformer;

class GovernmentalPermissionByNumberReport extends Report
{
    use Generator;

    /**
     * @var $number
     */
    private $number;

    /**
     * @param  int    $number
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
            new GovernmentalPermissionByNumberTransformer,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = GovernmentalDamagedPermission::withPermitUnit();

        $query->select([
            "governmental_damaged_permissions.id as permission_id",
            "governmental_damaged_permissions.permission_number",
            "governmental_damaged_permissions.permission_date",
            "governmental_damaged_permissions.entity_name",
            "governmental_damaged_permissions.representative_name",
            "governmental_damaged_permissions.national_id",
            "governmental_damaged_permissions.allowed_weight",
            "governmental_damaged_permissions.actual_weight",
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
