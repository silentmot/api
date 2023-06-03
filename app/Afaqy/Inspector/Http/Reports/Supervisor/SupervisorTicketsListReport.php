<?php

namespace Afaqy\Inspector\Http\Reports\Supervisor;

use Illuminate\Http\Request;
use Afaqy\Inspector\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Inspector\Http\Transformers\TicketsTransformer;

class SupervisorTicketsListReport extends Report
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
        $options['include'] = [
            'data',
        ];

        $result = $this->prepareData();

        $data = $this->fractalCollectionPaginated($result, new TicketsTransformer, ['data']);

        return $this->returnSuccess('', $data);
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Ticket::withInspector()
            ->withNeighborhood()
            ->select([
                'mob_inspector_tickets.id',
                'mob_inspector_tickets.created_at',
                'mob_inspector_tickets.updated_at',
                'mob_inspector_tickets.status',
                'neighborhoods.name as neighborhood_name',
                'users.username as inspector_name',
                DB::raw('Date(mob_inspector_tickets.created_at) as date'),
            ])
            ->where('mob_inspector_tickets.contract_id', $this->request->header('contract-id'))
            ->sortBy($this->request)
            ->filter($this->request->all());
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    private function prepareData()
    {
        $result = $this->query()->paginateFilter($this->request->query('per_page') ?? 20);

        // I need to override default collection with grouped by collection by date
        return $result->setCollection($result->getCollection()->groupBy('date'));
    }
}
