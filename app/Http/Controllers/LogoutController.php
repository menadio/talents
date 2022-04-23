<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    /**
     * Revoke resource access token
     * 
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();

            return $this->successRes(null, 'Logout was successful');
            
        } catch (\Exception $e) {
            
            dd($e->getMessage);
            Log::error('Logout error', $e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
