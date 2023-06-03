<?php

namespace Afaqy\TripWorkflow\Listeners\Logs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Afaqy\Permission\Models\SortingAreaPermission;
use Afaqy\Permission\Actions\StorePermissionLogAction;
use Afaqy\Permission\Models\DamagedProjectsPermission;
use Afaqy\Permission\Models\CommercialDamagedPermission;
use Afaqy\Permission\Models\IndividualDamagedPermission;
use Afaqy\Permission\Models\GovernmentalDamagedPermission;

class StorePermissionLog implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'low';

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->trip->information->permission_id !== null) {
            $permission       = $this->getPermissionInfo($event->trip->information->permission_id, $event->trip->information->permission_type);
            $permissionNumber = ($event->trip->information->permission_type == 'sorting') ?
                $event->trip->information->permission_id : $event->trip->information->permission_number;
            (new StorePermissionLogAction([
                'permission_number' => $permissionNumber,
                'permission_type'   => $event->trip->information->permission_type,
                'allowed_weight'    => $permission->allowed_weight ?? 0,
                'actual_weight'     => ($event->trip->enterance_weight + $event->trip->exit_weight) ?? 0,
            ]))->execute();
        }
    }

    protected function getPermissionInfo(int $permissionId, string $permissionType)
    {
        switch ($permissionType) {
            case 'commercial':
                return $this->getCommercialPermissionInfo($permissionId);
            case 'governmental':
                return $this->getGovernmentalPermissionInfo($permissionId);
            case 'individual':
                return $this->getIndividualPermissionInfo($permissionId);
            case 'project':
                return $this->getProjectsPermissionInfo($permissionId);
            case 'sorting':
                return $this->getSortingPermissionInfo($permissionId);
            default:
                return false;
        }
    }

    protected function getCommercialPermissionInfo(int $permissionId)
    {
        return CommercialDamagedPermission::findOrFail($permissionId);
    }

    protected function getGovernmentalPermissionInfo(int $permissionId)
    {
        return GovernmentalDamagedPermission::findOrFail($permissionId);
    }

    protected function getIndividualPermissionInfo(int $permissionId)
    {
        return IndividualDamagedPermission::findOrFail($permissionId);
    }

    protected function getProjectsPermissionInfo(int $permissionId)
    {
        return DamagedProjectsPermission::findOrFail($permissionId);
    }

    protected function getSortingPermissionInfo(int $permissionId)
    {
        return SortingAreaPermission::findOrFail($permissionId);
    }
}
