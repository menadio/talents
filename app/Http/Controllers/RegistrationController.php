<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Events\NewIndividualRegistered;
use Illuminate\Support\Facades\Validator;

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
        $validation = Validator::make($request->all(), [
            'email' => ['required', 'email:rfc,dns'],
            'password'  => ['required', 'min:8'],
            'account_type_id' => ['required', 'numeric']
        ]);

        if ($validation->fails())
            return $this->errorRes($validation->errors(), 'Failed validation', 422);

        $user = User::create([
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'account_type_id'   => $request->account_type_id
        ]);

        if ( $user->accountType->type === 'Individual') {
            NewIndividualRegistered::dispatch($user);
        }

        return $this->successRes(null, 'Registration was successful.', 201);
    }
}
