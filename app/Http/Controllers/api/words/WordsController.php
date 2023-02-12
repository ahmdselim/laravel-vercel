<?php

namespace App\Http\Controllers\api\words;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\api\words\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WordsController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [];
        Word::chunk(1, function ($words) use (&$data) {
            foreach ($words as $word) {
                $data[] =  $word;
            }
        });


        // $words = Word::all();
        return $this->apiResponse($data, "data returned successfully", 200);
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
            // "recognitionEn" => "required|file|mimes:audio/mpeg,mpga,mp3,wav,aac",
            "recognitionGr" => "required|file|mimes:audio/mpeg,mpga,mp3,wav,aac",
            // "recognitionFr" => "required|file|mimes:audio/mpeg,mpga,mp3,wav,aac",
            "category_id" => "required|integer|exists:words_categories,id",
        ]);

        if ($validate->fails()) {
            return $this->apiResponse([], $validate->errors(), 404);
        } else {
            $grRec = time() . uniqid("", true) . $request->recognitionGr->getClientOriginalName();
            // // $enRec = time() . uniqid("", true) . $request->recognitionEn->getClientOriginalName();
            // // $frRec = time() . uniqid("", true) . $request->recognitionFr->getClientOriginalName();

            $allRequests["recognitionGr"] = $grRec;
            // // $allRequests["recognitionEn"] = $enRec;
            // // $allRequests["recognitionFr"] = $frRec;


            // // $request->recognitionEn->move("uploads/words/recognition/en", $enRec);
            // // $request->recognitionFr->move("uploads/words/recognition/fr", $frRec);

            Word::create($allRequests);
            $request->recognitionGr->move("uploads/words/recognition/gr/", $grRec);

            return $this->apiResponse($allRequests, "data inserted successfully", 200);

            return $request->recognitionGr;
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
    // public function update(Request $request, $id)
    // {
    //     $word = Word::findOrFail($id);
    //     $inputs = $request->all();

    //     $validate = Validator::make($inputs, [
    //         "nameAr" => "string",
    //         "nameEn" => "string",
    //         "nameFr" => "string",
    //         "nameGr" => "string",
    //         "recognitionGr" => "file|mimes:audio/mpeg,mpga,mp3,wav,aac",
    //         "category_id" => "integer|exists:words_categories,id",
    //     ]);

    //     if ($validate->fails()) {
    //         return $this->apiResponse($validate->errors(), "failed", 400);
    //     } else {
    //         if (!empty($request->file('recognitionGr'))) {

    //             return $request->file("recognitionGr");

    //             $fullImageName = time() . uniqid("", true) . $request->recognitionGr->getClientOriginalName();


    //             $inputs["recognitionGr"] = $fullImageName;
    //             $request->recognitionGr->move("uploads/words/recognition/gr/", $fullImageName);
    //             $word->update($inputs);

    //             $oldImage = public_path('uploads/words/recognition/gr/' . $word->recognitionGr);
    //             unlink($oldImage);
    //         }

    //         $word->update($inputs);

    //         return $this->apiResponse($word, "word updated", 200);
    //     }

    //     // return $request->file("recognitionGr");

    //     // return $inputs;

    //     // if ($validate->fails()) {
    //     //     return $validate->errors();
    //     // }

    //     // return $request->file("recognitionGr");
    //     // $fullImageName = time() . uniqid("", true) . $request->recognitionGr->getClientOriginalName();
    //     // return $fullImageName;

    //     // return ($inputs['recognitionGr']);
    //     // return response()->json($request->all());
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $word = Word::findOrFail($id);


        // $enRec = public_path("uploads/words/recognition/en" . $word->recognitionEn);
        // $frRec = public_path("uploads/words/recognition/fr" . $word->recognitionFr);

        $grRec = public_path("uploads/words/recognition/gr/" . $word->recognitionGr);

        if (file_exists($grRec)) {

            unlink($grRec);
        }

        $word->delete();

        // return $this->apiResponse([], "word  deleted", 200);
        return  response()->json("word deleted", 200);
    }


    public function wordsUpdate(Request $request, $id)
    {

        $word = Word::findOrFail($id);

        // return $word;

        $inputs = $request->all();


        $validate = Validator::make($inputs, [
            "nameAr" => "string",
            "nameEn" => "string",
            "nameFr" => "string",
            "nameGr" => "string",
            // "recognitionGr" => "required|file|mimes:audio/mpeg,mpga,mp3,wav,aac",
            "category_id" => "integer|exists:words_categories,id",
        ]);

        if ($validate->fails()) {
            return $this->apiResponse($validate->errors(), "failed ya ma3lm", 400);
        }

        if ($request->recognitionGr !== $word->recognitionGr) {
            $fullRecGrName = time() . uniqid("", true) . $request->recognitionGr->getClientOriginalName();


            $inputs["recognitionGr"] = $fullRecGrName;
            $request->recognitionGr->move("uploads/words/recognition/gr/", $fullRecGrName);

            $oldImage = public_path('uploads/words/recognition/gr/' . $word->recognitionGr);
            unlink($oldImage);

            $word->update($inputs);
            return $this->apiResponse($word, "word updated", 200);
        } else {
            $word->update($inputs);

            return $this->apiResponse($word, "word updated", 200);
        }
    }
}
