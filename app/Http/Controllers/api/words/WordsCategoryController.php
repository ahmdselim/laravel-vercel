<?php

namespace App\Http\Controllers\api\words;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\api\words\WordsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// use

class WordsCategoryController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wordsCategory = WordsCategory::all();

        return $this->apiResponse($wordsCategory, "data returned successfully", 200);
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

            WordsCategory::create($allRequests);


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
        $wordsCategory = WordsCategory::findOrFail($id);

        $allRequests = $request->all();

        $validate = Validator::make($request->all(), [
            "name" => "required|string",
            "paid" => "required|integer",
        ]);

        if ($validate->fails()) {
            return $this->apiResponse([], $validate->errors(), 404);
        } else {

            $wordsCategory->update($allRequests);

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
        $wordsCategory = WordsCategory::findOrFail($id);


        $wordsCategory->delete();
        // return $this->apiResponse([], "word category  deleted", 200);
        return  response()->json("word category deleted", 200);
    }
}
