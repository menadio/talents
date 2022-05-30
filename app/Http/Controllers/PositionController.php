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
            'category' => ['required', 'numeric'],
            'salary' => ['required', 'numeric', 'min:1'],
            'employment_type' => ['required', 'numeric'],
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
            $newPosition = $this->positionService->newPosition($request);
            
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        //
    }
}
