<?php

namespace Afaqy\Device\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Device\Models\Device;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Device\Http\Transformers\DeviceTransformer;

class DeviceListReport extends Report
{
    use Generator;

    /**
     * @var \Illuminate\Http\Request $request
     */
    private $request;

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateViewList(
            $this->query(),
            new DeviceTransformer,
            $this->request
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Device::select(['id', 'name', 'type', 'ip', 'door_name'])->sortBy($this->request);
    }
}
