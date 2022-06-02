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
        return Event::orderBy('date', 'desc')
            ->orderby('time', 'desc')
            ->get();   
    }

    // get user created events
    public function getUserEvents()
    {
        $user = auth()->user();

        return $user->events;
    }

    // view event details
    public function viewEvent(Event $event)
    {
        return $event;
    }

    // update event
    public function updateEvent(Event $event, $request)
    {
        $user = auth()->user();

        if ($user->id !== $event->user_id) {
            return false;
        }

        $event->update($request->all());

        return true;
    }

    // delete event
    public function deleteEvent(Event $event)
    {
        $user = auth()->user();

        if ($user->id !== $event->user_id) {
            return false;
        }

        $event->delete();

        return true;
    }

}