<?php

namespace Afaqy\District\Actions;

use Afaqy\Core\Actions\Action;
use Illuminate\Support\Facades\DB;
use Afaqy\District\Models\District;
use Afaqy\District\Models\Neighborhood;

class StoreDistrictAction extends Action
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
        DB::transaction(function () use (&$district) {
            $district = District::create([
                'name'   => $this->data->name,
                'status' => $this->data->status,
                'points' => json_encode($this->data->points),
            ]);

            $this->attachNeighborhoods($this->data->neighborhoods, $district->id);
        });

        return $district;
    }

    protected function attachNeighborhoods($neighborhoods, $district_id)
    {
        foreach ($neighborhoods as $neighborhood) {
            $neighborhood_obj = Neighborhood::create([
                'district_id' => $district_id,
                'name'        => $neighborhood->name,
                'status'      => $neighborhood->status,
                'population'  => $neighborhood->population,
                'points'      => json_encode($neighborhood->neighborhood_points),
            ]);

            $sub_neighborhoods = [];

            foreach ($neighborhood->sub_neighborhoods as $sub_neighborhood) {
                $sub_neighborhoods[] = [
                    'name'            => $sub_neighborhood,
                    'neighborhood_id' => $neighborhood_obj->id,
                ];
            }

            $neighborhood_obj->subNeighborhoods()->createMany($sub_neighborhoods);
        }
    }
}
