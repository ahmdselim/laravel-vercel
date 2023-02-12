<?php

namespace  App\Http\Controllers\api;

trait ApiResponseTrait
{

    function apiResponse($data = null, $message = null, $status = null)
    {

        $arr = [
            "data" => $data,
            "message" => $message,
            "status" => $status
        ];

        if (!$data) {
            return  response()->json($arr, 404);
        }

        return  response()->json($arr);
    }
}
