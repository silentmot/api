<?php

namespace Afaqy\Inspector\Http\Controllers;

use Afaqy\Inspector\DTO\TicketData;
use Afaqy\Inspector\DTO\TicketImageData;
use Afaqy\Core\Http\Controllers\Controller;
use Afaqy\Inspector\DTO\TicketResponseData;
use Afaqy\Inspector\Http\Reports\TicketShowReport;
use Afaqy\Inspector\Actions\UpdateTicketStatusAction;
use Afaqy\Inspector\Http\Requests\TicketImageRequest;
use Afaqy\Inspector\Actions\Inspector\CreateTicketAction;
use Afaqy\Inspector\Http\Requests\UpdateTicketStatusRequest;
use Afaqy\Inspector\Http\Requests\CreateTicketResponseRequest;
use Afaqy\Inspector\Http\Requests\Inspector\StoreTicketRequest;
use Afaqy\Inspector\Actions\Supervisor\UpdateViewedTicketAction;
use Afaqy\Inspector\Actions\Aggregator\StoreTicketImageAggregator;
use Afaqy\Inspector\Actions\Aggregator\CreateTicketResponseAggregator;

class TicketController extends Controller
{
    /**
     * @SWG\Get(
     *  path="/v1/mob/tickets",
     *  tags={"TIckets"},
     *  summary="list inspector tickets by status.",
     *  description="",
     *  operationId="inspector-tickets-list",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="status", type="string", in="query", description="To get list of tickets for the given status.", required=true
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example=""),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 42,
     *          "contracto_name": "Mohamed osama",
     *          "contracto_name": "Mohamed osama",
     *          "neighborhood": "Al.Riyad",
     *      })
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function show($id)
    {
        if (request()->hasHeader('supervisor-id')) {
            (new UpdateViewedTicketAction($id))->execute();
        }

        return (new TicketShowReport($id))->show();
    }

    /**
     * @SWG\Post(
     *  path="/v1/mob/tickets/",
     *  tags={"Tickets"},
     *  summary="Store ticket.",
     *  description="",
     *  operationId="ticket-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="contract_id", type="int", example="1"),
     *         @SWG\Property(property="district_id", type="int", example="1"),
     *         @SWG\Property(property="neighborhood_id", type="int", example="1"),
     *         @SWG\Property(property="location", type="string", example="129,129"),
     *         @SWG\Property(property="details", type="string", example="We have an issue in Riyad"),
     *     )
     *   ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ الحى بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 1
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="13001"),
     *      @SWG\Property(property="message", type="string", example="حديث خطأ أثناء الحفظ, ربجاء المحاولة مرة اخري."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "name"={"The name must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreTicketRequest $request)
    {
        $dto = TicketData::fromRequest($request);

        $result = (new CreateTicketAction($dto))->execute();

        $messages = [
            'success' => 'inspector::inspector.store-success',
            'fail'    => 'inspector::inspector.store-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            13001
        );
    }

    /**
     * @SWG\Post(
     *  path="/v1/mob/tickets/1/images",
     *  tags={"Tickets"},
     *  summary="Store ticket's image.",
     *  description="store the ticket's image one by one",
     *  operationId="ticket-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="image", type="file", example="image.png")     )
     *   ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ الحى بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 1
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="13001"),
     *      @SWG\Property(property="message", type="string", example="حديث خطأ أثناء الحفظ, ربجاء المحاولة مرة اخري."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "name"={"The name must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function storeImage(TicketImageRequest $request, $ticket_id)
    {
        $data = TicketImageData::fromRequest($request, $ticket_id);

        $result = (new StoreTicketImageAggregator($data))->execute();

        $messages = [
            'success' => 'inspector::inspector.store-image-success',
            'fail'    => 'inspector::inspector.store-image-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            13001
        );
    }

    /**
     * @SWG\Patch (
     *  path="/v1/mob/tickets/{ticket}/status/{status}",
     *  tags={"Tickets"},
     *  summary="Update the ticket status.",
     *  description="Update the ticket status",
     *  operationId="ticket-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *      name="ticket",
     *      type="integer",
     *      in="path",
     *      required=true,
     *      description="the ticket id.",
     *      @SWG\Schema(
     *       type="integer"
     * )
     *  ),
     *@SWG\Parameter(
     *      name="status",
     *      type="string",
     *      required=true,
     *      in="path",
     *      description="Update the ticket by  status.",
     *     @SWG\Schema(
     *       type="string",
     *       enum={"ACCEPTED", "REPORTED"}
     *          )
     *  ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="تم حفظ الحى بنجاح"),
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 1
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="13001"),
     *      @SWG\Property(property="message", type="string", example="حديث خطأ أثناء الحفظ, ربجاء المحاولة مرة اخري."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "name"={"The name must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function updateStatus(UpdateTicketStatusRequest $request)
    {
        $result = (new UpdateTicketStatusAction($request->id, $request->status))->execute();

        $messages = [
            'success' => 'inspector::inspector.update-success',
            'fail'    => 'inspector::inspector.update-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            13001
        );
    }

    /**
     * @SWG\Post(
     *  path="/v1/mob/tickets/{ticket}/response",
     *  tags={"Tickets"},
     *  summary="Store ticket's response.",
     *  description="store the ticket's response",
     *  operationId="ticket-store",
     *  security={
     *      {"passport": {"*"}},
     *  },
     *  @SWG\Parameter(
     *     name="Request body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         @SWG\Property(property="details", type="string", example="تم حل المشكله")     )
     *   ),
     *  @SWG\Response(response=200, description="successful operation with pagination", @SWG\Schema(type="object",
     *      @SWG\Property(property="data", type="string", example={
     *          "id": 1
     *      })
     *  )),
     *  @SWG\Response(response=400, description="Bad Request", @SWG\Schema(type="object",
     *      @SWG\Property(property="code", type="integer", example="13001"),
     *      @SWG\Property(property="message", type="string", example="حديث خطأ أثناء الحفظ, ربجاء المحاولة مرة اخري."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=401, description="Unauthorized", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Unauthenticated."),
     *  )),
     *  @SWG\Response(response=403, description="Forbidden", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="Access is denied."),
     *      @SWG\Property(property="errors", type="string", example={})
     *  )),
     *  @SWG\Response(response=422, description="Unprocessable Entity", @SWG\Schema(type="object",
     *      @SWG\Property(property="message", type="string", example="The given data was invalid."),
     *      @SWG\Property(property="errors", type="string", example={
     *          "name"={"The name must be string."},
     *      })
     *  )),
     *  @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function respond(CreateTicketResponseRequest $request, $ticket_id)
    {
        $data = TicketResponseData::fromRequest($request, $ticket_id);

        $result = (new CreateTicketResponseAggregator($data))->execute();

        $messages = [
            'success' => 'inspector::inspector.store-response-success',
            'fail'    => 'inspector::inspector.store-response-failed',
        ];

        return $this->generateViewResponse(
            $result,
            $messages,
            13001
        );
    }
}
