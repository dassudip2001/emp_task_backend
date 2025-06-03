<?php

namespace App\Http\Controllers\Api\Auth;

use App\Mail\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController
{
    public function sendResetLinkEmail(Request $request)
    {
        // if email doesn't exist
        // If email does not exist
        if (!$this->validEmail($request->email)) {
            return response()->json([
                'message' => 'We can\'t find a user with that email address.'
            ], Response::HTTP_NOT_FOUND);
        } else {
            if (!$this->validActive($request->email)) {
                return response()->json([
                    'message' => 'Whoops! This account is disabled.'
                ], Response::HTTP_FORBIDDEN);
            }
            // If email exists
            $this->sendMail($request->email);
            return response()->json([
                'message' => 'We have emailed your password reset link!'
            ], Response::HTTP_OK);
        }
    }

    public function sendMail($email)
    {
        $token = $this->createNewToken($email);
        Mail::to($email)->send(new ResetPasswordRequest($token));
    }
    private function validEmail($email)
    {
        return !!User::where('email', $email)->first();
    }

    private function validActive($email)
    {
        return !!User::where('email', $email)->where('status', 1)->first();
    }

    public function createNewToken($email)
    {
        $isOtherToken = DB::table('password_reset_tokens')->where('email', $email)->first();

        if ($isOtherToken) {
            return $isOtherToken->token;
        }

        $token = Str::random(80);;
        $this->storeToken($token, $email);
        return $token;
    }
    public function storeToken($token, $email)
    {
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }
}
