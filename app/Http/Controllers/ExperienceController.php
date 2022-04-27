<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ExperienceController extends Controller
{
    /**
     * Get user experience collection
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return $this->successRes(
                ExperienceResource::collection(auth()->user()->experiences),
                'Retrieved experiences collection successfully'
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }
    /**
     * Store a resource
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->all(), [
            'title'             => ['required', 'string'],
            'employment_type'   => ['required', 'numeric'],
            'industry_type'     => ['required', 'numeric'],
            'end_date'          => ['required', 'date'],
            'start_date'        => ['required', 'date'],
            'location'          => ['required', 'string'],
            'description'       => ['required', 'string']
        ]);

        if ( $validation->fails() ) {
            return $this->errorRes(
                $validation->errors()->first(),
                'Failed validation',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $experience = Experience::create([
                'user_id'             => auth()->user()->id,
                'title'               => $request->title,
                'employment_type_id'  => $request->employment_type,
                'industry_id'         => $request->industry_type,
                'start_date'          => $request->start_date,
                'end_date'            => $request->end_date,
                'location'            => $request->location,
                'description'         => $request->description
            ]);

            return $this->successRes(
                new ExperienceResource($experience),
                'Your experience was saved successfully',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Update a user experience
     * 
     * @param App\Models\Experience $experience
     * @param \illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experience $experience)
    {
        if ( auth()->user()->id !== intval($experience->user_id) ) {
            return $this->errorRes(
                null,
                'Unauthorized operation',
                Response::HTTP_UNAUTHORIZED
            );
        }

        // validate request data
        $validation = Validator::make($request->all(), [
            'title'             => ['string'],
            'employment_type'   => ['numeric'],
            'industry_type'     => ['numeric'],
            'end_date'          => ['date'],
            'start_date'        => ['date'],
            'location'          => ['string'],
            'description'       => ['string']
        ]);

        if ( $validation->fails() ) {
            return $this->errorRes(
                $validation->errors()->first(),
                'Failed validation',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        
        try {
            $experience->fill($request->all());

            if ( $experience->update() === false ) {
                return $this->errorRes(
                    null, 
                    'Failed to update experience', 
                    Response::HTTP_BAD_REQUEST
                );
            }

            return $this->successRes(
                new ExperienceResource($experience),
                'Update successful'
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }

    }

    /**
     * Delete a user experience
     * 
     * @param \App\Models\Experience $experience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
        if ( auth()->user()->id !== intval($experience->user_id) ) {
            return $this->errorRes(
                null,
                'Unauthorized operation',
                Response::HTTP_UNAUTHORIZED
            );
        }

        try {
            $experience->delete();

            return $this->successRes(
                null,
                'Removed experience successfully'
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
