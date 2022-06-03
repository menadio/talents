<?php

namespace App\Services;

use App\Models\JobApplication;
use App\Models\Position;
use App\Models\Status;
use App\Models\User;

class JobApplicationService
{
    /**
     * Job application
     */
    public function applyForPosition(Position $position, User $user)
    {
        if (intval($position->user_id) === intval($user->id)) {
            return false;
        }

        $pending = Status::where('name', 'pending review')
            ->pluck('id')->first();

        JobApplication::create([
            'position_id' => $position->id,
            'user_id' => $user->id,
            'status_id' => $pending
        ]);

        return true;
    }

    /**
     * Retrieve list of job position applicants
     * 
     * @param Position $position
     * @return User $users
     */
    public function getJobApplicants(Position $position)
    {
        return $position->jobApplications;
    }

    /**
     * Accept job application
     *      
     * @param Position $position
     * @param JobApplication $jobApplication
     */
    public function acceptApplication(JobApplication $jobApplication): bool
    {
        $user = auth()->user();

        $accepted = Status::where('name', 'accepted')
            ->pluck('id')->first();

        $pendingReview = Status::where('name', 'pending review')
            ->pluck('id')->first();

        if ($jobApplication->status_id !== $pendingReview) {
            return false;
        }

        $jobApplication->update(['status_id' => $accepted]);

        return true;
    }

    /**
     * Reject job application
     *      
     * @param Position $position
     * @param JobApplication $jobApplication
     */
    public function rejectApplication(JobApplication $jobApplication): bool
    {
        $user = auth()->user();

        $rejected = Status::where('name', 'rejected')
            ->pluck('id')->first();

        $pendingReview = Status::where('name', 'pending review')
            ->pluck('id')->first();

        if ($jobApplication->status_id !== $pendingReview) {
            return false;
        }

        $jobApplication->update(['status_id' => $rejected]);

        return true;
    }

    /**
     * Get selected applicants for a job
     * 
     * @param Position $position
     */
    public function getSelectedJobApplicants(Position $position)
    {
        return JobApplication::where([
            ['position_id', $position->id]
        ])->whereHas('status', function ($query) {
            return $query->where('status_id', 4);
        })->get();
    }

    /**
     * Get selected applicants for a job
     * 
     * @param Position $position
     */
    public function getRejectedJobApplicants(Position $position)
    {
        return JobApplication::where([
            ['position_id', $position->id]
        ])->whereHas('status', function ($query) {
            return $query->where('status_id', 3);
        })->get();
    }
}
