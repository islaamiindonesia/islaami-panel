<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Notifications\AfterRegister;
use App\Notifications\ForgotPasswordMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $logUser = User::where('email', $request->email)->first();
        if ($logUser != null) { // if user found
            if ($logUser->email_verified_at != null) { // if user is verified
                $token = auth('api')->login($logUser);
                $user = auth('api')->user();

                $data = [
                    'user' => $user,
                    'auth_token' => $token,
                ];
                //After successfull authentication, notice how I return json parameters
                return $this->successResponseWithData($data);
            }

            // if not verified
            return $this->errorResponse('UNVERIFIED');
        }

        // if user not found
        return $this->errorResponse('EMAIL_NOT_FOUND');
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
                'verification_number' => mt_rand(100000, 999999),
                'fcm_token' => $request->fcm_token
            ]
        );

        $user->notify(new AfterRegister());

        return $this->successResponseWithData($user);
    }

    public function verify(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user->email_verified_at == null) { // if not verified
            if ($user->verification_number != $request->verification_number) { // if wrong number
                return $this->errorResponse("WRONG_VERIFICATION_NUMBER", 403);
            }

            $user->verification_number = "";
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user->save();
        }

        return $this->successResponseWithData($user);
    }

    public function resendVerification(Request $request)
    {
        $user = User::where('email', $request->query('email'))->first();

        if ($user->email_verified_at == null) { // if not verified
            $user->notify(new AfterRegister());

            return $this->successResponse();
        }

        return $this->errorResponse("EMAIL_NOT_FOUND");
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
