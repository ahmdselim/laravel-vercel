<?php

namespace App\Http\Controllers\api\ratings;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\api\ratings\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RatingsController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Rating::all();
        return $this->apiResponse($ratings, "all ratings returned successfully", 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|min:3|max:80",
            "rating" => "required|integer",
            "suggestion" => "required|string|min:3|max:255",
        ]);



        if ($validator->fails()) {
            return $this->apiResponse([], "data not returned", 400);
        } else {
            $favorites = Rating::create($request->all());
            return $this->apiResponse($favorites, "data returned successfully", 200);
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
        $rating = Rating::findOrFail($id);


        $rating->delete();
        // return $this ->apiResponse([],"sentence category deleted",200);

        return  response()->json("sentence  deleted", 200);
    }
}
