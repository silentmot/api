<?php

namespace Afaqy\TripWorkflow\Actions\UnitInformation;

use Afaqy\Core\Actions\Action;
use Afaqy\EntrancePermission\Models\EntrancePermission;

class GetEntranceUnitInformationAction extends Action
{
    /**
     * @var array
     */
    private $checker;

    /**
     * @var string
     */
    private $date;

    /**
     * @param array  $checker
     * @param string $date
     * @return void
     */
    public function __construct(array $checker, string $date)
    {
        $this->checker = $checker;
        $this->date    = $date;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $unit = EntrancePermission::select([
            'id',
            'type',
            'name',
            'title',
            'national_id',
            'plate_number',
            'qr_code',
            'rfid',
        ])
            ->where($this->checker['field'], $this->checker['value'])
            ->where('start_date', '<=', $this->date)
            ->where('end_date', '>=', $this->date)
            ->orderBy('id', 'desc')
            ->first();

        if ($unit) {
            return $this->format($unit);
        }

        return [];
    }

    /**
     * @param  Illuminate\Database\Eloquent\Model $unit
     * @return array
     */
    public function format($unit)
    {
        return [
            'id'           => $unit->id,
            'plate_number' => $unit->plate_number,
            'qr_code'      => $unit->qr_code,
            'rfid'         => $unit->rfid,
            'owner'        => [
                'type'        => $unit->type,
                'name'        => $unit->name,
                'title'       => $unit->title,
                'national_id' => $unit->national_id,
            ],
        ];
    }
}
