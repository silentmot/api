<?php

namespace Afaqy\Inspector\Http\Reports;

use Afaqy\Inspector\Models\Ticket;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Inspector\Http\Transformers\ShowTicketTransformer;

class TicketShowReport extends Report
{
    use Generator;

    /**
     * @var int $id
     */
    private $id;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        $includes = [
            'created_by',
            'media',
            'response',
            'penalty',
        ];

        return $this->generateJoinViewShow(
            $this->query(),
            new ShowTicketTransformer,
            $includes
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $ticket = $this->mainTicket();

        if ($this->hasResponse()) {
            return $this->appendResponse($ticket);
        }

        return $ticket;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function mainTicket(): Builder
    {
        return Ticket::withContract()
            ->withInspector()
            ->withImages()
            ->withSupervisor()
            ->withDistrict()
            ->withNeighborhood()
            ->where('mob_inspector_tickets.id', $this->id)
            ->select([
                'mob_inspector_tickets.id',
                'mob_inspector_tickets.contractor_name',
                'contacts.name as supervisor_name',
                'mob_inspector_tickets.created_at',
                'mob_inspector_tickets.updated_at',
                'mob_inspector_tickets.details',
                'mob_inspector_images.imageable_type',
                'mob_inspector_images.url',
                'neighborhoods.name as neighborhood_name',
                'districts.name as district_name',
                'users.username',
                'users.avatar',
            ]);
    }

    /**
     * @return boolean
     */
    private function hasResponse(): bool
    {
        $status = Ticket::findOrFail($this->id)->status;

        if ($status == "RESPONDED" || $status == "REPORTED" || $status == "PENALTY") {
            return true;
        }

        return false;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function appendResponse(Builder $query): Builder
    {
        return $query->withResponse()->addSelect([
            'mob_inspector_responses.responseable_type',
            'mob_inspector_responses.details as response',
        ]);
    }
}
