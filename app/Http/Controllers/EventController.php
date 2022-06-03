<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EventService $eventService)
    {
        try {
            $events = $eventService->listEvents();

            return $this->successRes(
                EventResource::collection($events),
                'Retrieved list of events successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Fetch user owned events
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetch(EventService $eventService)
    {
        try {
            $events = $eventService->getUserEvents();

            return $this->successRes(
                EventResource::collection($events),
                'Retrieved list of events successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, EventService $eventService)
    {
        $validation = Validator::make($request->all(), []);

        if ($validation->fails()) {
            return $this->errorRes(
                $validation->errors()->first(),
                'Failed validation',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $event = $eventService->createEvent($request);

            return $this->successRes(
                new EventResource($event),
                'New event created successfully',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event, EventService $eventService)
    {
        try {
            $user = auth()->user();

            if ($user->id !== $event->user_id) {
                return  $this->errorRes(
                    null,
                    'The government forbids you access',
                    Response::HTTP_UNAUTHORIZED
                );
            }

            return $this->successRes(
                new  EventResource($eventService->getEventDetails($event)),
                'Retrieved event details successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event, EventService $eventService)
    {
        try {
            $user = auth()->user();

            if ($user->id !== $event->user_id) {
                return $this->errorRes(
                    null,
                    'The government forbids you access',
                    Response::HTTP_UNAUTHORIZED
                );
            }

            return $this->successRes(
                new EventResource($eventService->updateEvent($event, $request)),
                'Event updated',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event, EventService $eventService)
    {
        try {
            $user = auth()->user();
    
            if ($user->id !== $event->user_id) {
                return $this->errorRes(
                    null,
                    'The government forbids you access',
                    Response::HTTP_UNAUTHORIZED
                );
            }
    
            $deletedEvent = $eventService->deleteEvent($event);
    
            if ($deletedEvent) {
                return $this->successRes(
                    null,
                    'Event deleted',
                    Response::HTTP_NO_CONTENT
                );
            } else {
                return $this->errorRes(
                    null,
                    'Failed to delete event',
                    Response::HTTP_BAD_REQUEST
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
