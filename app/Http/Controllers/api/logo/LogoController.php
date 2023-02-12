<?php

namespace App\Http\Controllers\api\logo;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\api\logo\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LogoController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logo = Logo::get();

        return $this->apiResponse($logo, "logo returned successfully", 200);
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
            "logo" => "required|image|mimes:jpg,jpeg,svg,png",
        ]);


        if ($validator->fails()) {
            return $this->apiResponse([], $validator->errors(), 400);
        } else {
            $requests = $request->all();
            $fullName = time() . uniqid("", true) . $request->logo->getClientOriginalName();

            $requests["logo"] = $fullName;
            $logo = Logo::create($requests);
            $request->logo->move(public_path('uploads/logo/images/'), $fullName);

            return $this->apiResponse($logo, "data returned successfully", 200);
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
        $logo = Logo::findOrFail($id);


        $validator = Validator::make($request->all(), [
            "logo" => "required|image|mimes:jpg,jpeg,svg,png",
        ]);

        $requests = $request->all();

        if ($validator->fails()) {

            return $this->apiResponse([], $validator->errors(), 400);
        }

        if ($request->logo !== $logo->logo) {

            $oldImage = public_path('uploads/logo/images/' . $logo->logo);
            $fullName = time() . uniqid("", true) . $request->logo->getClientOriginalName();

            $requests["logo"] = $fullName;
            $logo->update($requests);

            $request->logo->move(public_path('uploads/logo/images/'), $fullName);
            unlink($oldImage);

            return $this->apiResponse($requests, "data returned successfully", 200);
        } else {


            $logo->update($requests);

            return $this->apiResponse($logo, "word updated", 200);
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
        $logo = Logo::findOrFail($id);

        $logo->delete();
        $oldImage = public_path('uploads/logo/images/' . $logo->logo);

        unlink($oldImage);
        return $this->apiResponse([], "logo  deleted", 200);
    }
}
