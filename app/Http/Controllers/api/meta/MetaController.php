<?php

namespace App\Http\Controllers\api\meta;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\api\meta\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MetaController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meta = Meta::get();

        return $this->apiResponse($meta,"data returned",200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            "title" => "required|string",
            "description" => "required|string",
        ]);

        if ($validator->fails()) {
            return $this->apiResponse([],$validator->errors(),400);
        }else {

            $meta = Meta::create($request->all());

            return $this->apiResponse($meta,$validator->errors(),400);
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
        $meta = Meta::findOrFail($id);

        $allRequests = $request->all();

        $validate = Validator::make($request->all(),[
            "title" => "string",
            "description" => "string",
        ]);

        if ($validate->fails()) {
            return $this->apiResponse([],$validate->errors(),404);
        }else {

            $meta->update($allRequests);

            return $this->apiResponse($allRequests,"data updated successfully",200);
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
        //
    }
}
