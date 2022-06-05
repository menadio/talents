<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventTypeResource;
use App\Services\EventTypeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventTypeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(EventTypeService $eventTypeService)
    {
        $eventTypes = $eventTypeService->getEventTypes();

        return $this->successRes(
            EventTypeResource::collection($eventTypes),
            'Retrieved event types collection successfully',
            Response::HTTP_OK
        );
    }
}
