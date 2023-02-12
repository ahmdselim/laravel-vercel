<?php

namespace App\Http\Controllers\api\favorites;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\api\favorites\Favorite;
use App\Models\api\sentence\Sentence;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = Favorite::all();

        return $this ->apiResponse($favorites,"data returned successfully",200);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = User::whereid($request->user_id)->first();
        $sentence = Sentence::whereid($request->sentence_id)->first();

        $validator = Validator::make($request->all(), [
            "sentence_id" => "required|integer",
            "user_id" => "required|integer",
        ]);



       if ($validator->fails() || !$user || !$sentence)  {
        return $this ->apiResponse([],"data not returned",400);
        }else {
            $favorites = Favorite::create($request->all());
            return $this ->apiResponse($favorites,"data returned successfully",200);
        }

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
        $favorites = Favorite::find($id);


        if ($favorites) {
            $favorites->delete();
            return $this ->apiResponse([],"favorite  deleted",200);
        }else {
            return $this ->apiResponse([],"favorite not deleted",404);
        }
    }
}
