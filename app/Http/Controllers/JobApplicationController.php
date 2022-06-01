<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Services\JobApplicationService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JobApplicationController extends Controller
{
    /**
     * Job position application
     * 
     * @param Position $position
     * @return \Illuminate\Http\Response
     */
    public function apply(Position $position, JobApplicationService $jobApplicationService)
    {
        $applied = $jobApplicationService->applyForPosition($position, auth()->user());

        if ($applied) {
            return $this->successRes(
                null,
                'Job application successful',
                Response::HTTP_CREATED
            );
        } else {
            return $this->errorRes(
                null,
                'Job application failed',
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
