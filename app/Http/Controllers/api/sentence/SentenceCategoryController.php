<?php

namespace App\Http\Controllers\api\sentence;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\api\sentence\SentenceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SentenceCategoryController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sentenceCategory = SentenceCategory::all();

        return $this->apiResponse($sentenceCategory, "data returned success", 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $allRequests = $request->all();

        $validate = Validator::make($request->all(), [
            "name" => "required|string",
            "paid" => "required|integer",
        ]);

        if ($validate->fails()) {
            return $this->apiResponse([], $validate->errors(), 404);
        } else {

            SentenceCategory::create($allRequests);


            return $this->apiResponse($allRequests, "data inserted successfully", 200);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $sentenceCategory = SentenceCategory::findOrFail($id);

        $allRequests = $request->all();

        $validate = Validator::make($request->all(), [
            "name" => "required|string",
            "paid" => "required|integer",
        ]);

        if ($validate->fails()) {
            return $this->apiResponse([], $validate->errors(), 404);
        } else {

            $sentenceCategory->update($allRequests);

            return $this->apiResponse($allRequests, "data updated successfully", 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wordsCategory = SentenceCategory::findOrFail($id);


        $wordsCategory->delete();
        // return $this ->apiResponse([],"sentence category deleted",200);
        return  response()->json("word deleted", 200);
    }
}
