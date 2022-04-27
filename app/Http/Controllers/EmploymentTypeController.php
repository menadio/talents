<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmploymentTypeResource;
use App\Models\EmploymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmploymentTypeController extends Controller
{
    /**
     * Get resource collection
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $types = EmploymentType::all();

            return $this->successRes(
                EmploymentTypeResource::collection($types), 
                'Retreived employment types successfully'
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
