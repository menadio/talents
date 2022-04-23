<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // validate request data
        $validation  = Validator::make($request->all(), [
            'email'     => ['required', 'email:rfc,dns'],
            'password'  => ['required']
        ]);

        if ($validation->fails())
            return $this->errorRes($validation->errors()->first(), 'Failed validation', 422);
        
        try {
            // authenticate
            $user = User::where('email', $request->email)->first();

            if ( !$user || !Hash::check($request->password, $user->password) )
                return $this->errorRes(null, 'Email/Password mismatch');
    
            // grant access token
            $accessToken = $user->createToken('chioma');
            $data = ['accessToken' => $accessToken->plainTextToken];
    
            // return response
            return $this->successRes($data, 'Login successful');
            
        } catch (\Exception $e) {
            Log::error('Login failed', $e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
