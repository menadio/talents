<?php

namespace App\Http\Controllers;

use App\Http\Resources\DashboardResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $payload = $user->load('profile', 'experiences', 'skills', 'portfolios');

        return $this->successRes(
            new DashboardResource($payload),
            'Retrieved data successfully',
            Response::HTTP_OK
        );
    }
}
