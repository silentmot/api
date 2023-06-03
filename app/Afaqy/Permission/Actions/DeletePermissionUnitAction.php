<?php

namespace Afaqy\Permission\Actions;

use Afaqy\Core\Actions\Action;
use Illuminate\Support\Facades\DB;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Permission\Models\PermitUnit;
use Afaqy\Permission\Models\CheckinUnit;

class DeletePermissionUnitAction extends Action
{
    /** @var string */
    private $model_name;

    /** @var int */
    private $qr_code;

    /**
     * @param string $model_name
     * @param int    $qr_code
     * @return void
     */
    public function __construct($model_name, $qr_code)
    {
        $this->model_name = $model_name;
        $this->qr_code    = $qr_code;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $has_trip = Dashboard::where('qr_code', $this->qr_code)->count();

        if ($has_trip) {
            return false;
        }

        $unit = PermitUnit::where('qr_code', $this->qr_code)->firstOrFail();

        DB::transaction(function () use (&$result, $unit) {
            CheckinUnit::where('unit_id', $unit->id)
                ->where('checkinable_type', $this->model_name)
                ->delete();

            $result = $unit->delete();
        });

        return $result;
    }
}
