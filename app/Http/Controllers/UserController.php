<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use App\Models\Profile;
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
            'username'      => ['string', 'unique:username'],
            'first_name'    => ['string'],
            'last_name'     => ['string'],
            'about'         => ['string'],
            'phone'         => ['string'],
            'country'       => ['string'],
            'state'         => ['string'],
            'city'          => ['string'],
            'address'       => ['string'],
            'postal_code'   => ['string'],
            'facebook'      => ['string'],
            'instagram'     => ['string'],
            'twitter'       => ['string'],
            'tiktok'        => ['string'],
            'photo'         => ['image', 'mimes:jpg,bmp,png', 'max:256'],
            'cover_photo'   => ['image', 'mimes:jpg,bmp,png', 'max:256']
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
