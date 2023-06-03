<?php

namespace Afaqy\Inspector\Http\Reports\Admin;

use Illuminate\Http\Request;
use Afaqy\Inspector\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Inspector\Http\Transformers\TicketAdminListTransformer;

class AdminTicketListReport extends Report
{
    use Generator;

    /**
     * @var Request $request
     */
    private $request;

    /**
     * @param Request $request
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
        $data = $this->fractalCollectionPaginated(
            $this->query()->paginate($this->request->query('per_page') ?? 20),
            new TicketAdminListTransformer,
            []
        );

        return $this->returnSuccess('', $data);
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Ticket::withInspector()
            ->withDistrict()
            ->withNeighborhood()
            ->select([
                'mob_inspector_tickets.id',
                'mob_inspector_tickets.contractor_name',
                'mob_inspector_tickets.created_at',
                'mob_inspector_tickets.updated_at',
                'mob_inspector_tickets.status',
                'neighborhoods.name as neighborhood_name',
                'districts.name as district_name',
                'users.username as inspector_name',
                DB::raw('Date(mob_inspector_tickets.created_at) as date'),
            ])
            ->sortBy($this->request)
            ->filter($this->request->all());
    }
}
