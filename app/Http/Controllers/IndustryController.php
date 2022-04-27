<?php

namespace App\Http\Controllers;

use App\Http\Resources\IndustryResource;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndustryController extends Controller
{
    /**
     * Get a collection of industries
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $industries = Industry::all();

            return $this->successRes(
                IndustryResource::collection($industries),
                'Retrieved industry collection successfully'
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
