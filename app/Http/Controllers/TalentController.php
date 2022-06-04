<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Http\Resources\TalentResource;
use App\Models\User;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TalentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $individual = AccountType::where('type', 'individual')
            ->pluck('id')->first();

        $users = User::where('account_type_id', $individual)->get();

        return $this->successRes(
            TalentResource::collection($users),
            'Retrieved talents collection successfully',
            Response::HTTP_OK
        );
    }
}
