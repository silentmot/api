<?php

namespace Afaqy\TripWorkflow\Actions\UnitInformation;

use Illuminate\Support\Str;
use Afaqy\Core\Actions\Action;
use Illuminate\Support\Facades\DB;
use Afaqy\Permission\Models\PermitUnit;
use Afaqy\Permission\Models\SortingAreaPermission;
use Afaqy\Permission\Models\DamagedProjectsPermission;
use Afaqy\Permission\Models\CommercialDamagedPermission;
use Afaqy\Permission\Models\IndividualDamagedPermission;
use Afaqy\Permission\Models\GovernmentalDamagedPermission;

class GetPermissionUnitInformationAction extends Action
{
    /**
     * @var array
     */
    private $checker;

    /**
     * @param array $checker
     * @return void
     */
    public function __construct(array $checker)
    {
        $this->checker = $checker;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
//        if ($this->checker['field'] == 'plate_number') {
//            $unit = PermitUnit::where($this->checker['field'], $this->checker['value'])->count();
//
//            if ($unit) {
//                return 'wait for qr or rfid signal';
//            }
//
//            return false;
//        }

        $unit = PermitUnit::withCommonPermissionsIds()
            ->select([
                'permit_units.id',
                'plate_number',
                'qr_code',
                'rfid',
                'checkinable_id as permission_id',
                'checkinable_type as permission_type',
            ])
            ->where($this->checker['field'], $this->checker['value'])
            ->orderBy('permit_units.id', 'desc')
            ->first();

        if (!$unit) {
            return false;
        }

        $permission_type = Str::camel(last(explode('\\', $unit->permission_type)));

        $permission_data = $this->{$permission_type}($unit->permission_id);

        if (!$permission_data) {
            return false;
        }

        return $this->format($unit, $permission_data);
    }

    /**
     * Get individual damaged permission information
     *
     * @param  int $id
     * @return Illuminate\Database\Eloquent\Model|null
     */
    private function individualDamagedPermission(int $id)
    {
        return IndividualDamagedPermission::select([
            'id',
            'permission_number',
            'demolition_serial',
            DB::raw("'individual' as type"),
            DB::raw("'دمارات أفراد' as waste_type"),
        ])
            ->where('id', $id)
            ->first();
    }

    /**
     * Get projects damaged permission information
     *
     * @param  int $id
     * @return Illuminate\Database\Eloquent\Model|null
     */
    private function damagedProjectsPermission(int $id)
    {
        return DamagedProjectsPermission::select([
            'id',
            'permission_number',
            'demolition_serial',
            DB::raw("'project' as type"),
            DB::raw("'دمارات مشاريع' as waste_type"),
        ])
            ->where('id', $id)
            ->first();
    }

    /**
     * Get commercial damaged permission information
     *
     * @param  int $id
     * @return Illuminate\Database\Eloquent\Model|null
     */
    private function commercialDamagedPermission(int $id)
    {
        return CommercialDamagedPermission::select([
            'id',
            'permission_number',
            DB::raw("'commercial' as type"),
            DB::raw("'امر اتلاف تجارى' as waste_type"),
        ])
            ->where('id', $id)
            ->first();
    }

    /**
     * Get governmental damaged permission information
     *
     * @param  int $id
     * @return Illuminate\Database\Eloquent\Model|null
     */
    private function governmentalDamagedPermission(int $id)
    {
        return GovernmentalDamagedPermission::select([
            'id',
            'permission_number',
            DB::raw("'governmental' as type"),
            DB::raw("'امر اتلاف حكومى' as waste_type"),
        ])
            ->where('id', $id)
            ->first();
    }

    /**
     * Get sorting area permission information
     *
     * @param  int $id
     * @return Illuminate\Database\Eloquent\Model|null
     */
    private function sortingAreaPermission(int $id)
    {
        return SortingAreaPermission::withWasteType()
            ->select([
                'sorting_area_permissions.id',
                DB::raw("'sorting' as type"),
                'waste_types.name as waste_type',
            ])
            ->where('sorting_area_permissions.id', $id)
            ->first();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $unit
     * @param  \Illuminate\Database\Eloquent\Model $permission
     * @return array
     */
    private function format($unit, $permission): array
    {
        return [
            'id'           => $unit->id,
            'plate_number' => $unit->plate_number,
            'qr_code'      => $unit->qr_code,
            'rfid'         => $unit->rfid,
            'waste_type'   => $permission->waste_type,
            'permission'   => [
                'id'                => $permission->id,
                'type'              => $permission->type,
                'number'            => $permission->permission_number ?? null,
                'demolition_serial' => $permission->demolition_serial ?? null,
            ],
        ];
    }
}
