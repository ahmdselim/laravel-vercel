<?php

namespace App\Http\Controllers\api\users;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();

        return $this->apiResponse($users, "data returned successfully", 200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requests = $request->all();
        $password = Hash::make($request->password);
        $requests["password"] = $password;

        $user = User::create($requests);

        if ($user) {
            return $this->apiResponse($user, "data returned successfully", 200);
        } else {
            return $this->apiResponse($user, "data not returned", 400);
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
        $user = User::find($id);

        if (!$user) {
            return $this->apiResponse($user, "id not found", 404);
        }

        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required",
            "status" => "required",
            "pay" => "required|integer",
        ]);

        if ($validator->fails()) {
            return $this->apiResponse([], $validator->errors(), 404);
        } else {
            $user->update($request->all());
            return $this->apiResponse($user, "data returned successfully", 200);
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

        $user = User::findOrFail($id);


        $user->delete();
        // return $this ->apiResponse([],"sentence category deleted",200);
        return  response()->json("user  deleted", 200);
    }
}
