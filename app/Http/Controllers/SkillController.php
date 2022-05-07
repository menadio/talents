<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Get a collection of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successRes(
            SkillResource::collection(Skill::all()),
            'Retrieved skills collection successfully'
        );
    }
}
