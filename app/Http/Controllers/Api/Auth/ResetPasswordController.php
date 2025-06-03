<?php

namespace App\Http\Controllers\Api\Auth;

use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController
{
    public function resetPassword(Request $request)
    {
        // return "it's called";
        $request->validate([
            'email' => 'required|email',
            'password' => 'required_with:confirm_password|same:confirm_password',
            '_token' => 'required|string'
        ]);
        $credential = $request->only([
            'email',
            'password',
            '_token'
        ]);

        return !is_null($this->checkEmailAndToken($credential)->first()) ? $this->reset($request) : $this->tokenNotFoundError();
    }

    // Verify if token is valid
    private function checkEmailAndToken($data)
    {
        return DB::table('password_reset_tokens')->where([
            'email' => $data['email'],
            'token' => $data['_token']
        ]);
    }

    // Token not found response
    private function tokenNotFoundError()
    {
        return response()->json([
            'error' => 'Either this password reset token or email is invalid.'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    // Reset password
    private function reset($data)
    {

        // find email
        $user = User::whereEmail($data->email)->first();

        // update password
        $user->update([
            'password' => bcrypt($data->password)
        ]);

        Mail::to($data->email)->send(new ResetPassword($data->email));

        // remove verification data from db
        $this->checkEmailAndToken($data)->delete();


        // reset password response
        return response()->json([
            'data' => 'Password has been updated.'
        ], Response::HTTP_CREATED);
    }
}
