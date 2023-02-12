<?php

namespace App\Http\Controllers\api\coursePrice;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\api\coursePrice\CoursesPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoursesPriceController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coursePrice = CoursesPrice::get();

        return $this->apiResponse($coursePrice,"data returned",200);

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
            "price" => "required|integer",
        ]);



       if ($validator->fails())  {
        return $this ->apiResponse([],"data not returned",400);
        }else {
            $coursePrice = CoursesPrice::create($request->all());
            return $this ->apiResponse($coursePrice,"data returned successfully",200);
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
        $coursePrice = CoursesPrice::find($id);

        if (!$coursePrice) {
            return $this ->apiResponse($coursePrice,"id not found",404);
        }

        $validator = Validator::make($request->all(), [
            "price" => "required|integer",
        ]);

             if ($validator->fails())  {
                return $this ->apiResponse([],"errors",404);
            }else {
                $coursePrice->update($request->all());
                return $this ->apiResponse($coursePrice,"data returned successfully",200);
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
