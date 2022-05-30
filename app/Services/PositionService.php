<?php

namespace App\Services;

use App\Models\EmploymentType;
use App\Models\Position;
use App\Models\Status;

class PositionService
{
    public function newPosition($request): Position
    {
        $pending = Status::where('name', 'pending')
            ->pluck('id')->first();

        return Position::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'category_id' => $request->category,
            'salary' => $request->salary,
            'employment_type_id' => $request->employment_type,
            'location' => $request->location,
            'description' => $request->description,
            'status_id' => $pending
        ]);
    }
}