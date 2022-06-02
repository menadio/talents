<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Services\JobApplicationService;
use App\Http\Resources\JobApplicationResource;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\throwException;
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
        try {
            if (!$position->open) {
                return $this->errorRes(
                    null,
                    'Job is no longer receiving applications',
                    Response::HTTP_BAD_REQUEST
                );
            }
            
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
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * List job position applicants
     * 
     * @param Position $position
     * @return \Illuminate\Http\Response
     */
    public function applicants(Position $position, JobApplicationService $jobApplicationService)
    {
        try {
            $user = auth()->user();
    
            if ($user->id !== $position->user_id) {
                return $this->errorRes(
                    null,
                    'The government forbids you access',
                    Response::HTTP_UNAUTHORIZED
                );
            }
    
            $applications = $jobApplicationService->getJobApplicants($position);
            
            return $this->successRes(
                JobApplicationResource::collection($applications),
                'Retrieved job applications successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Accept a job application
     * 
     * @return \Illuminate\Http\Response
     */
    public function accept(JobApplication $jobApplication, JobApplicationService $jobApplicationService)
    {
        try {
            $user = auth()->user();

            if ($user->id !== $jobApplication->position->user_id) {
                return $this->errorRes(
                    null,
                    'The government forbids you access',
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $jobApplicationService->acceptApplication($jobApplication);
    
            if ($jobApplication->wasChanged('status_id')) {
                return $this->successRes(
                    new JobApplicationResource($jobApplication),
                    'Job application accepted',
                    Response::HTTP_OK
                );
            } else {
                return $this->errorRes(
                    null,
                    'Unable to accept application',
                    Response::HTTP_BAD_REQUEST
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Reject a job application
     * 
     * @return \Illuminate\Http\Response
     */
    public function reject(JobApplication $jobApplication, JobApplicationService $jobApplicationService)
    {
        try {
            $user = auth()->user();

            if ($user->id !== $jobApplication->position->user_id) {
                return $this->errorRes(
                    null,
                    'The government forbids you access',
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $jobApplicationService->rejectApplication($jobApplication);
    
            if ($jobApplication->wasChanged('status_id')) {
                return $this->successRes(
                    new JobApplicationResource($jobApplication),
                    'Job application rejected',
                    Response::HTTP_OK
                );
            } else {
                return $this->errorRes(
                    null,
                    'Unable to reject application',
                    Response::HTTP_BAD_REQUEST
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    public function selected(Position $position, JobApplicationService $jobApplicationService)
    {
        try {
            $user = auth()->user();

            if ($user->id !== $position->user_id) {
                return $this->errorRes(
                    null,
                    'The government forbids you access',
                    Response::HTTP_UNAUTHORIZED
                );
            }
            
            $selectApplicants = $jobApplicationService->getSelectedJobApplicants($position);
    
            return $this->successRes(
                JobApplicationResource::collection($selectApplicants),
                'Retrieved list of selected applicants successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    public function rejected(Position $position, JobApplicationService $jobApplicationService)
    {
        try {
            $user = auth()->user();

            if ($user->id !== $position->user_id) {
                return $this->errorRes(
                    null,
                    'The government forbids you access',
                    Response::HTTP_UNAUTHORIZED
                );
            }
            
            $selectApplicants = $jobApplicationService->getRejectedJobApplicants($position);
    
            return $this->successRes(
                JobApplicationResource::collection($selectApplicants),
                'Retrieved list of rejected applicants successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
