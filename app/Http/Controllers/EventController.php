<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\Eventservice;
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
    public function index(Eventservice $eventService)
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

    public function fetch(Eventservice $eventService)
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
    public function store(Request $request, Eventservice $eventService)
    
        $validation = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'event_category_id' => ['required', 'numeric', 'exists:event_categories,id'],
            'location' => ['required', 'string'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'description' => ['required', 'string'],
            'event_type_id' => ['required', 'numeric'],
            'price' => ['numeric', 'min:0']
        ]);

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
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
