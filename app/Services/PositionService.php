<?php

namespace App\Services;

use App\Models\User;
use App\Models\Status;
use App\Models\Position;
use App\Models\EmploymentType;

class PositionService
{
    /**
     * Create new job position
     * 
     * @param $request
     * @return App\Models\Position
     */
    public function createPosition($request): Position
    {
        $pending = Status::where('name', 'pending')
            ->pluck('id')->first();

        return Position::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'category_id' => $request->category_id,
            'salary' => $request->salary,
            'employment_type_id' => $request->employment_type_id,
            'location' => $request->location,
            'description' => $request->description,
            'status_id' => $pending
        ]);
    }

    /**
     * Update a specific job position
     * 
     * @param App\Models\Position $position
     * @param App\Models\User $user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updatePosition(Position $position, User $user, $request): bool
    {
        if (intval($position->user_id) === intval($user->id)) {
            $position->update($request->all());

            return true;
        }

        return false;
    }

    /**
     * Delete job position post
     * 
     * @return bool
     */
    public function deletePosition(Position $position, User $user): bool
    {
        if (intval($position->user_id) === intval($user->id)) {
            $position->delete();
            
            return true;
        }

        return false;
    }
}