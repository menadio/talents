<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\AccountTypeResource;
use Symfony\Component\HttpFoundation\Response;

class AccountTypeController extends Controller
{
    /**
     * Get resource collection
     * 
     * @return \illuminate\Http\Response
     */
    public function index()
    {
        try {
            $accountTypes = AccountType::all();

            return $this->successRes(
                AccountTypeResource::collection($accountTypes),
                'Retrieved collection successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
