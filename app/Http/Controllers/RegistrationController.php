<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Events\NewIndividualRegistered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    /**
     * Create individual user account
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => ['required', 'email:rfc,dns'],
                'password'  => ['required', 'min:8'],
                'account_type_id' => ['required', 'numeric']
            ]);
    
            if ($validation->fails()) {
                return $this->errorRes(
                    $validation->errors()->first(), 
                    'Failed validation', 
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
    
            $user = User::create([
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'account_type_id'   => $request->account_type_id
            ]);
    
            if ( $user->accountType->type === 'Individual') {
                NewIndividualRegistered::dispatch($user);
            }
    
            return $this->successRes(
                null, 
                'Registration was successful.', 
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
