<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserSkillResource;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserSkillController extends Controller
{
    /**
     * Get user skills collection
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return $this->successRes(
                UserSkillResource::collection(auth()->user()->skills),
                'Retrieved skills collection successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Store user skill
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addSkills(Request $request)
    {
        // validate request
        $validation =  Validator::make($request->all(), [
            'skills' => ['required', 'array']
        ]);

        if ($validation->fails()) {
            return $this->errorRes(
                $validation->errors(), 
                'Failed validation', 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            auth()->user()->skills()->attach($request->skills);
    
            return $this->successRes(
                UserSkillResource::collection(auth()->user()->skills), 
                'Added skills successffully',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Remove a user skill
     * 
     * @param App\Model\Skill $skill
     * @return \Illuminate\Http\Response
     */
    public function deleteSkill(Skill $skill)
    {
        try {
            auth()->user()->skills()->detach($skill);

            return $this->successRes(
                null, 
                'Removed skill successfully', 
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
