<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Success response format
     * 
     * @param $data
     * @param $message
     * @param $httpStatus
     * @return \Illuminate\Http\Response
     */
    public function successRes($data = null, $message = 'Operation successful.', $httpStatus = 200)
    {
        if (is_null($data)) {
            return response()->json([
                'success'   => true,
                'message'   => $message
            ], $httpStatus);
        } else {
            return response()->json([
                'success'   => true,
                'message'   => $message,
                'data'      => $data
            ], $httpStatus);
        }
    }

    /**
     * Error response format
     * 
     * @param $error
     * @param $message
     * @return \Illuminate\Http\Response
     */
    public function errorRes($error = null, $message = null, $httpStatus = 400)
    {
        if (is_null($error)) {
            return response()->json([
                'success'       => false,
                'message'       => $message
            ], $httpStatus);

        } else {
            return response()->json([
                'success'       => false,
                'message'       => $message,
                'error'         => $error
            ], $httpStatus);
        }
    }

    /**
     * Server error response format
     * 
     * @return \Illuminate\Http\Response
     */
    public function serverErrorRes()
    {
        return response()->json([
            'success'   => false,
            'message'   => 'Oops! That shouldn\'t happen, please try again later.'
        ], 500);
    }
}
