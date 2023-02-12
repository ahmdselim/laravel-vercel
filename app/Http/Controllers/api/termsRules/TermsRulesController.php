<?php

namespace App\Http\Controllers\api\termsRules;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\api\termsRules\TermsRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TermsRulesController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $termsRules = TermsRule::get();
        return $this->apiResponse($termsRules,"termsRules returned successfully",200);

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
            "terms" => "required|string",
        ]);


       if ($validator->fails())  {
        return $this ->apiResponse([],$validator->errors(),400);
        }else {
            $requests = $request->all();

            $termsRules = TermsRule::create($requests);

            return $this ->apiResponse($termsRules,"data returned successfully",200);
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
        $termsRules = TermsRule::findOrFail($id);

        $validator = Validator::make($request->all(), [
            "terms" => "required|string",
        ]);

        if ($validator->fails())  {
            return $this ->apiResponse([],"data not returned",400);
            }else {
                $requests = $request->all();

                $termsRules = $termsRules->update($requests);

                return $this ->apiResponse($termsRules,"data returned successfully",200);
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
        $sentence = TermsRule::findOrFail($id);
        $sentence->delete();
        return $this ->apiResponse([],"sentence  deleted",200);

    }
}
