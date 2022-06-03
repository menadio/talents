<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventCategoryResource;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $categories = EventCategory::all();

        return $this->successRes(
            EventCategoryResource::collection($categories),
            'Retrieved event category list successfully',
            Response::HTTP_OK
        );
    }
}
