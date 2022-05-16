<?php

namespace App\Http\Controllers;

use App\Http\Resources\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = auth()->user();

            return $this->successRes(
                PortfolioResource::collection($user->portfolios),
                'Retrieved portfolios successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->all(), [
            'title'     => ['required','string'],
            'image'     => ['mimes:jpg,bmp,png'],
            'details'   => ['required','string'],
            'avatar'    => ['mimes:jpg,bmp,png'],
            'link'      => ['required','url']
        ]);

        if ($validation->fails()) {
            return $this->errorRes(
                $validation->errors()->first(),
                'Failed validation',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $user = auth()->user();

            $portfolio = Portfolio::create([
                'user_id'   => $user->id,
                'title'     => $request->title,
                'details'   => $request->details,
                'link'      => $request->link
            ]);

            if ($request->has('image')) {
                $portfolio->addMedia($request->image)
                    ->toMediaCollection('portfolio-photos');
            }

            if ($request->has('avatar')) {
                $portfolio->addMedia($request->avatar)
                    ->toMediaCollection('portfolio-avatars');
            }

            return $this->successRes(
                new PortfolioResource($portfolio),
                'Portfolio item added successfully',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->serverErrorRes();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
