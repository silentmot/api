<?php

namespace Afaqy\Permission\Http\Reports\Commercial;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Permission\Models\CommercialDamagedPermission;
use Afaqy\Permission\Http\Transformers\Commercial\CommercialPermissionByNumberTransformer;

class CommercialPermissionByNumberReport extends Report
{
    use Generator;

    /**
     * @var int
     */
    private $number;

    /**
     * @param  int $number
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
            new CommercialPermissionByNumberTransformer,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = CommercialDamagedPermission::withPermitUnit();

        $query->select([
            "commercial_damaged_permissions.id as permission_id",
            "commercial_damaged_permissions.permission_number",
            "commercial_damaged_permissions.permission_date",
            "commercial_damaged_permissions.company_name",
            "commercial_damaged_permissions.company_commercial_number",
            "commercial_damaged_permissions.representative_name",
            "commercial_damaged_permissions.national_id",
            "commercial_damaged_permissions.allowed_weight",
            "commercial_damaged_permissions.actual_weight",
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
