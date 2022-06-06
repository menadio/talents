<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Retrieve resource profile
     * 
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        try {
            $user = auth()->user();
    
            return $this->successRes(
                new UserResource($user->load('profile')),
                'Profile retrieved successfully'
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Update resource profile
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->all(), [
            'username'      => ['string', 'nullable', 'unique:profiles,username'],
            'first_name'    => ['string', 'nullable'],
            'last_name'     => ['string', 'nullable'],
            'about'         => ['string', 'nullable'],
            'phone'         => ['string', 'nullable'],
            'country'       => ['string', 'nullable'],
            'state'         => ['string', 'nullable'],
            'city'          => ['string', 'nullable'],
            'address'       => ['string', 'nullable'],
            'postal_code'   => ['string', 'nullable'],
            'facebook'      => ['string', 'nullable'],
            'instagram'     => ['string', 'nullable'],
            'twitter'       => ['string', 'nullable'],
            'tiktok'        => ['string', 'nullable'],
            'photo'         => ['image', 'mimes:jpg,bmp,png', 'max:256', 'nullable'],
            'cover_photo'   => ['image', 'mimes:jpg,bmp,png', 'max:256', 'nullable']
        ]);

        if ($validation->fails()) {
            return $this->errorRes(
                $validation->errors(), 
                'Failed validation', 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $user = auth()->user();

            $user->profile->update($request->except(['photo', 'cover_photo']));

            if ( $user->update() === false ) {
                return $this->errorRes(
                    null, 
                    'Failed to update profile', 
                    Response::HTTP_BAD_REQUEST
                );
            }

            if ($request->has('photo')) {
                $user->addMedia($request->photo)
                    ->toMediaCollection('user-photos');
            }

            if ($request->has('cover_photo')) {
                $user->addMedia($request->cover_photo)
                    ->toMediaCollection('cover-photos');
            }

            return $this->successRes(
                new UserResource($user->load('profile')),
                'Profile update was successful'
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }
}
