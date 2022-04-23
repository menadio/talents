<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountTypeResource;
use App\Models\AccountType;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    /**
     * Get resource collection
     * 
     * @return \illuminate\Http\Response
     */
    public function index()
    {
        $accountTypes = AccountType::all();

        return response()->json([
            'types' => AccountTypeResource::collection($accountTypes)
        ], 200);
    }
}
