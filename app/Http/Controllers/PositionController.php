<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Services\PositionService;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PositionResource;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PositionController extends Controller
{
    protected $positionService;

    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = auth()->user();
    
            return $this->successRes(
                PositionResource::collection($user->positions->load('category', 'employmentType')),
                'Retrieved your job positions successfully',
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
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'category_id' => ['required', 'numeric'],
            'salary' => ['required', 'numeric', 'min:1'],
            'employment_type_id' => ['required', 'numeric'],
            'location' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);

        if ($validation->fails()) {
            return $this->errorRes(
                $validation->errors()->first(),
                'Failed validation',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $newPosition = $this->positionService->createPosition($request);
            
            return $this->successRes(
                new PositionResource($newPosition->load('category', 'employmentType')),
                'New job created successfully',
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
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        try {
            return $this->successRes(
                new PositionResource($position),
                'Retrieved job position successfully',
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
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        $validation = Validator::make($request->all(), [
            'title' => ['string'],
            'category_id' => ['numeric'],
            'salary' => ['numeric', 'min:1'],
            'employment_type_id' => ['numeric'],
            'location' => ['string'],
            'description' => ['string']
        ]);

        if ($validation->fails()) {
            return $this->errorRes(
                $validation->errors()->first(),
                'Failed validation',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $positionUpdated = $this->positionService
                ->updatePosition($position, auth()->user(), $request);

            if ($positionUpdated) {
                return $this->successRes(
                    new PositionResource($position),
                    'Job position was updated successfully',
                    Response::HTTP_OK
                );
            } else {
                return $this->errorRes(
                    null,
                    'Failed to update job position',
                    Response::HTTP_BAD_REQUEST
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        try {
            $deletedposition = $this->positionService->deletePosition($position, auth()->user());

            if ($deletedposition) {
                return $this->successRes(
                    null, 
                    'Job post was deleted successfully.',
                    Response::HTTP_NO_CONTENT
                );
            } else {
                return $this->errorRes(
                    null, 
                    'Unable to delete position.', 
                    Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
