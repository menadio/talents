<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Status;

class Eventservice
{
    // create event
    public function createEvent($request): Event
    {
        $user = auth()->user();
        $review = Status::where('name', 'pending review')
            ->pluck('id')->first();

        return Event::create([
            'user_id' => $user->id,
            'event_category_id' => $request->event_category_id,
            'title' => $request->title,
            'location' => $request->location,
            'date' => $request->date,
            'time' => $request->time,
            'event_type_id' => $request->event_type_id,
            'price' => $request->price,
            'description' => $request->description,
            'status_id' => $review
        ]);
    }

    // list all events
    public function listEvents()
    {
        $approved = Status::where('name', 'approved')
            ->pluck('id')->first();

        return Event::where('status_id',  $approved)
            ->orderBy('date', 'desc')
            ->orderby('time', 'desc')
            ->get();   
    }

    // get user created events
    public function getUserEvents()
    {
        $user = auth()->user();

        return $user->events;
    }

    // get event details
    public function getEventDetails(Event $event)
    {        
        return $event;
    }

    // update event
    public function updateEvent(Event $event, $request)
    {
        $event->update($request->all());

        return $event;
    }

    // delete event
    public function deleteEvent(Event $event)
    {
        if ( $event->delete() ) {
            return true;
        };

        return false;
    }

}