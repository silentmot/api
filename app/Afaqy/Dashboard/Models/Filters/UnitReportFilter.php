<?php

namespace Afaqy\Dashboard\Models\Filters;

use Afaqy\Core\Models\Filters\ModelFilter;
use Afaqy\Permission\Lookups\PermissionTypeLookup;

class UnitReportFilter extends ModelFilter
{
    public function contractor($contractors)
    {
        return $this->whereIn('contractor_name', $contractors);
    }

    public function contract($numbers)
    {
        return $this->whereIn('contract_number', $numbers);
    }

    public function plateNumber($plate_numbers)
    {
        return $this->whereIn('plate_number', $plate_numbers);
    }

    public function unitType($types)
    {
        return $this->whereIn('unit_type', $types);
    }

    public function entranceScale($ids)
    {
        return $this->whereIn('entrance_scale_id', $ids);
    }

    public function exitScale($ids)
    {
        return $this->whereIn('exit_scale_id', $ids);
    }

    public function wasteType($types)
    {
        return $this->whereIn('waste_type', $types);
    }

    public function permissionType($types)
    {
        $values = [];
        $lookup = PermissionTypeLookup::toReverseArray();

        foreach ($types as $type) {
            $values[] = $lookup[$type];
        }

        return $this->whereIn('permission_type', $values);
    }
}
