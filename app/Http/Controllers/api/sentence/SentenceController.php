<?php

namespace App\Http\Controllers\api\sentence;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\api\sentence\Sentence;
use App\Models\api\sentence\SentenceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SentenceController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sentences = Sentence::all();

        return $this->apiResponse($sentences, "data returned successfully", 200);
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
            "nameAr" => "required|string",
            "nameEn" => "required|string",
            "nameFr" => "required|string",
            "nameGr" => "required|string",
            "recognitionAr" => "required|file|mimes:audio/mpeg,mpga,mp3,wav,aac",
            "category_id" => "required|integer|exists:sentence_categories,id",
        ]);

        if ($validate->fails()) {
            return $this->apiResponse([], $validate->errors(), 404);
        } else {
            $nameRec = time() . uniqid("", true) . $request->recognitionAr->getClientOriginalName();
            $allRequests["recognitionAr"] = $nameRec;

            Sentence::create($allRequests);
            $request->recognitionAr->move("uploads/sentences/recognition/ar", $nameRec);


            return $this->apiResponse($allRequests, "data inserted successfully", 200);
        }
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $sentence = Sentence::findOrFail($id);
    //     $inputs = $request->all();


    //     // $allRequests = $request->all();



    //     // $validate = Validator::make($inputs, [
    //     //     "nameAr" => "string",
    //     //     "nameEn" => "string",
    //     //     "nameFr" => "string",
    //     //     "nameGr" => "string",
    //     //     // "recognitionAr" => "required",
    //     //     "category_id" => "integer|exists:sentence_categories,id",
    //     // ]);

    //     // if ($validate->fails()) {
    //     //     return $this->apiResponse($validate->errors(), "failed", 400);
    //     // } else {
    //     //     if (!empty($request->recognitionAr)) {

    //     //         $fullImageName = time() . uniqid("", true) . $request->recognitionAr->getClientOriginalName();


    //     //         $inputs["recognitionAr"] = $fullImageName;
    //     //         $request->recognitionAr->move(public_path('uploads/sentences/recognition/ar/'), $fullImageName);

    //     //         $sentence->update($inputs);

    //     //         $oldImage = public_path('uploads/sentences/recognition/ar/' . $sentence->recognitionAr);
    //     //         unlink($oldImage);
    //     //     }

    //     //     $sentence->update($inputs);

    //     //     return $this->apiResponse($sentence, "sentence updated", 200);
    //     // }
    // }


    public function update(Request $request, $id)
    {

        $sentence = Sentence::findOrFail($id);

        $inputs = $request->all();


        $validate = Validator::make($inputs, [
            "nameAr" => "string",
            "nameEn" => "string",
            "nameFr" => "string",
            "nameGr" => "string",
            // "recognitionAr" => "required",
            "category_id" => "integer|exists:sentence_categories,id",
        ]);



        if ($validate->fails()) {
            return $this->apiResponse($validate->errors(), "failed ya ma3lm", 400);
        }

        if ($request->recognitionAr !== $sentence->recognitionAr) {
            $fullRecGrName = time() . uniqid("", true) . $request->recognitionAr->getClientOriginalName();


            $inputs["recognitionAr"] = $fullRecGrName;
            $request->recognitionAr->move("uploads/sentences/recognition/ar/", $fullRecGrName);
            $oldImage = public_path('uploads/sentences/recognition/ar/' . $sentence->recognitionAr);


            unlink($oldImage);

            $sentence->update($inputs);
            return $this->apiResponse($sentence, "sentence updated", 200);
        } else {
            $sentence->update($inputs);

            return $this->apiResponse($sentence, "sentence updated", 200);
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
        $sentence = Sentence::findOrFail($id);

        $sentence->delete();
        $oldImage = public_path('uploads/sentences/recognition/ar/' . $sentence->recognitionAr);

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        // return $this->apiResponse([], "sentence  deleted", 200);
        return  response()->json("sentence  deleted", 200);
    }
}
