<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function auth;

class UserController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth.api:api');
    }

    /**
     * Display a user Profile.
     *
     * @return JsonResponse
     */
    public function getUser()
    {
        $auth = auth('api')->user();
        return $this->successResponseWithData($auth);
    }

    /**
     * Update the user profile.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $authID = auth('api')->id();
        $user = User::find($authID);
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->birthdate = $this->createCustomDate($request->birthdate);
        $user->gender = $request->gender;
        $user->save();

        return $this->successResponseWithData($user);
    }
}
