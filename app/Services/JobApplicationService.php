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
}