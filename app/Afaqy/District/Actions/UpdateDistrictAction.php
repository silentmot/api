<?php

namespace Afaqy\District\Actions;

use Afaqy\Core\Actions\Action;
use Illuminate\Support\Facades\DB;
use Afaqy\District\Models\District;
use Afaqy\District\Models\Neighborhood;

class UpdateDistrictAction extends Action
{
    /**
     * @var \Afaqy\District\DTO\DistrictData
     */
    private $data;

    /**
     * @param  \Afaqy\District\DTO\DistrictData $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $district = District::findOrFail($this->data->id);

        DB::transaction(function () use ($district, &$result) {
            $district->name   = $this->data->name;
            $district->status = $this->data->status;
            $district->points = json_encode($this->data->points);
            $result           = $district->update();

            $this->attachNeighborhoods($this->data->neighborhoods, $this->data->id);
        });

        return $result;
    }

    protected function attachNeighborhoods($neighborhoods, $district_id)
    {
        foreach ($neighborhoods as $neighborhood) {
            $neighborhood_obj = Neighborhood::updateOrCreate(
                [
                    'id' => $neighborhood->id,
                ],
                [
                    'district_id' => $district_id,
                    'name'        => $neighborhood->name,
                    'status'      => $neighborhood->status,
                    'population'  => $neighborhood->population,
                    'points'      => json_encode($neighborhood->neighborhood_points),
                ]
            );

            $sub_neighborhoods = [];

            foreach ($neighborhood->sub_neighborhoods as $sub_neighborhood) {
                $sub_neighborhoods[] = [
                    'name'            => $sub_neighborhood,
                    'neighborhood_id' => $neighborhood_obj->id,
                ];
            }

            $neighborhood_obj->subNeighborhoods()->delete();
            $neighborhood_obj->subNeighborhoods()->createMany($sub_neighborhoods);
        }
    }
}
