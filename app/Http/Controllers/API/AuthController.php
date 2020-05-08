<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Notifications\ForgotPasswordMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        $credentials = ['email' => request('email'), 'password' => request('password')];
        $token = auth('api')->attempt($credentials);
        if ($token) {
            $user = auth('api')->user();

            $data = [
                'user' => $user,
                'auth_token' => $token,
            ];
            //After successfull authentication, notice how I return json parameters
            return $this->successResponseWithData($data);
        } else {
            //if authentication is unsuccessfull, notice how I return json parameters
            return $this->errorResponse('Invalid Email or Password');
        }
    }

    public function logout()
    {
        auth('api')->logout();
        return $this->successResponse();
    }

    public function register(Request $request)
    {
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'fullname' => $request->fullname,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
            ]
        );

        return $this->successResponseWithData($user);
    }

    public function verify(Request $request)
    {
        $user = User::where('email', $request->get("email"))->first();

        $user->email_verified_at = Carbon::now()->toDateTimeString();
//                $user->verification_number = null;
        $user->save();

        return $this->successResponse();
    }

    public function resendEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user != null) {
//            $user->notify(new UserRegistrationMail);
            return $this->successResponse();
        }

        return $this->errorResponse("Error", 500);
    }

    public function forgotPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user != null) {
            $user->reset_token = Str::random(60);
            $user->password = Str::random(8);
            $user->save();

            $user->notify(new ForgotPasswordMail);
            return $this->successResponse();
        }

        return $this->errorResponse("Error", 500);
    }

    public function resetPassword(Request $request, $token)
    {
        $user = User::where('reset_token', $token)->where('email', $request->get('email'))->first();
        if ($user != null) {
            $user->reset_token = null;
            $user->save();
            return $this->successResponse();
        }

        return $this->errorResponse("Invalid Token", 500);
    }
}
